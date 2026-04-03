<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Message;

class PublicLeadController extends Controller
{
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'fullName' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $name = $request->input('fullName') ?? $request->input('name') ?? 'Unknown Lead';

        Client::create([
            'company_name' => $name,
            'email' => [$request->email],
            'phone' => $request->phone ? [$request->phone] : null,
            'background_info' => $request->message,
            'status' => 'Lead',
            'source' => 'Contact Form',
        ]);

        $superAdmin = User::where('role', 'super_admin')->first();
        if ($superAdmin) {
            Message::create([
                'sender_id' => $superAdmin->id,
                'receiver_id' => $superAdmin->id,
                'subject' => 'New Contact Form Submission',
                'body' => "Name: {$name}\nEmail: {$request->email}\nPhone: " . ($request->phone ?? 'N/A') . "\nMessage: {$request->message}",
                'sent_at' => now(),
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function auditSubmit(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'storeLink' => 'required|string|max:255',
            'preferredAsin' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $backgroundInfo = "Store Link: {$request->storeLink}\n" .
                         "Preferred ASIN: {$request->preferredAsin}\n" .
                         "Message: {$request->message}";

        Client::create([
            'company_name' => $request->fullName,
            'email' => [$request->email],
            'phone' => [$request->phone],
            'background_info' => $backgroundInfo,
            'status' => 'Lead',
            'source' => 'Audit Form',
        ]);

        $superAdmin = User::where('role', 'super_admin')->first();
        if ($superAdmin) {
            Message::create([
                'sender_id' => $superAdmin->id,
                'receiver_id' => $superAdmin->id,
                'subject' => 'New Free Audit Request',
                'body' => "Name: {$request->fullName}\nEmail: {$request->email}\nPhone: {$request->phone}\nStore Link: {$request->storeLink}\nPreferred ASIN: {$request->preferredAsin}\nMessage: {$request->message}",
                'sent_at' => now(),
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Your audit request has been received. Our team will review it and contact you soon.');
    }
}
