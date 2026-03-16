<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

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

        return back()->with('success', 'Your audit request has been received. Our team will review it and contact you soon.');
    }
}
