<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * The two public lead forms.
 *
 * These run without a session, because the pages they sit on are cached by
 * the CDN and a cached page cannot carry a per-visitor CSRF token. That
 * removes three things this controller used to lean on, so each is replaced
 * explicitly below:
 *
 *   CSRF           -> honeypot + same-origin check + the route's rate limit.
 *                     There is no signed-in action to forge here; the worst a
 *                     forged request achieves is creating a lead.
 *   success flash  -> a real /thank-you page, which is also a far better
 *                     conversion goal to track than a flashed message.
 *   error flash    -> errors are returned inline (JSON to fetch, a rendered
 *                     page otherwise) instead of redirected through session.
 */
class PublicLeadController extends Controller
{
    /** A field real people never see and never fill. Bots fill everything. */
    private const HONEYPOT = 'company_website';

    public function contactSubmit(Request $request)
    {
        if ($reject = $this->guard($request)) {
            return $reject;
        }

        $validator = Validator::make($request->all(), [
            'fullName' => 'nullable|string|max:255',
            'name'     => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:255',
            'message'  => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return $this->failed($request, $validator, 'contact');
        }

        $name = $request->input('fullName') ?: $request->input('name') ?: 'Unknown Lead';

        $this->record(
            companyName: $name,
            email: $request->input('email'),
            phone: $request->input('phone'),
            background: (string) $request->input('message'),
            source: 'Contact Form',
            subject: 'New Contact Form Submission',
            body: "Name: {$name}\nEmail: {$request->input('email')}\n"
                . 'Phone: ' . ($request->input('phone') ?: 'N/A') . "\n"
                . "Message: {$request->input('message')}",
        );

        return $this->succeeded($request);
    }

    public function auditSubmit(Request $request)
    {
        if ($reject = $this->guard($request)) {
            return $reject;
        }

        $validator = Validator::make($request->all(), [
            'fullName'      => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:255',
            'storeLink'     => 'required|string|max:255',
            'preferredAsin' => 'required|string|max:255',
            'message'       => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return $this->failed($request, $validator, 'audit');
        }

        $background = "Store Link: {$request->input('storeLink')}\n"
            . "Preferred ASIN: {$request->input('preferredAsin')}\n"
            . "Message: {$request->input('message')}";

        $this->record(
            companyName: (string) $request->input('fullName'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            background: $background,
            source: 'Audit Form',
            subject: 'New Free Audit Request',
            body: "Name: {$request->input('fullName')}\nEmail: {$request->input('email')}\n"
                . "Phone: {$request->input('phone')}\nStore Link: {$request->input('storeLink')}\n"
                . "Preferred ASIN: {$request->input('preferredAsin')}\n"
                . "Message: {$request->input('message')}",
        );

        return $this->succeeded($request);
    }

    /* ------------------------------------------------------------------ */

    /**
     * Spam and cross-origin screening, standing in for the CSRF token.
     *
     * A filled honeypot gets the ordinary success response rather than an
     * error: telling a bot it was detected only teaches it to try again.
     */
    private function guard(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse|null
    {
        if (filled($request->input(self::HONEYPOT))) {
            Log::info('Lead form honeypot tripped', ['ip' => $request->ip()]);
            return $this->succeeded($request);   // look successful, store nothing
        }

        // Reject a request that announces an origin and it is not ours. A
        // missing Origin and Referer is allowed: plenty of legitimate privacy
        // settings strip both, and blocking those would cost real leads.
        $claimed = $request->headers->get('Origin') ?: $request->headers->get('Referer');
        if ($claimed) {
            $theirs = parse_url($claimed, PHP_URL_HOST);
            $ours   = $request->getHost();
            if ($theirs && strcasecmp($theirs, $ours) !== 0 && strcasecmp($theirs, 'www.' . $ours) !== 0) {
                Log::warning('Lead form posted from another origin', ['origin' => $claimed, 'ip' => $request->ip()]);
                abort(403, 'This form must be submitted from xpertva.com.');
            }
        }

        return null;
    }

    private function record(
        string $companyName,
        ?string $email,
        ?string $phone,
        string $background,
        string $source,
        string $subject,
        string $body,
    ): void {
        Client::create([
            'company_name'    => $companyName,
            'email'           => $email ? [$email] : null,
            'phone'           => $phone ? [$phone] : null,
            'background_info' => $background,
            'status'          => 'Lead',
            'source'          => $source,
        ]);

        $superAdmin = User::where('role', 'super_admin')->first();
        if (!$superAdmin) {
            return;
        }

        Message::create([
            'sender_id'   => $superAdmin->id,
            'receiver_id' => $superAdmin->id,
            'subject'     => $subject,
            'body'        => $body,
            'sent_at'     => now(),
            'is_read'     => false,
        ]);
    }

    /** fetch() gets JSON; an ordinary form post gets the thank-you page. */
    private function succeeded(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok'      => true,
                'message' => 'Thank you. We have your details and will be in touch shortly.',
            ]);
        }

        return redirect()->route('thank-you');
    }

    /** Errors are returned with the response, never flashed through a session. */
    private function failed(Request $request, $validator, string $form)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok'     => false,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        return response()->view('lead-error', [
            'errors' => $validator->errors(),
            'form'   => $form,
        ], 422);
    }
}
