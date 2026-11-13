<?php

return [

    /*
    |--------------------------------------------------------------------------
    | VAPID identity
    |--------------------------------------------------------------------------
    |
    | Web Push requires the server to identify itself to the push services
    | (Google's FCM, Apple's, Mozilla's) with a P-256 key pair. Generate one
    | with:
    |
    |     php artisan webpush:keys
    |
    | and paste the three lines it prints into .env. Without them the portal
    | silently falls back to in-page notifications, which only fire while a
    | tab is open — no background delivery.
    |
    | The private key may be given either as the base64 encoded PEM our
    | generator emits, or as the base64url 32 byte scalar other Web Push
    | tooling produces. Keep it out of version control either way.
    |
    */

    'public_key'  => env('WEBPUSH_VAPID_PUBLIC_KEY', ''),
    'private_key' => env('WEBPUSH_VAPID_PRIVATE_KEY', ''),
    'private_pem' => env('WEBPUSH_VAPID_PRIVATE_PEM', ''),

    /*
    | A mailto: or https: URL a push service can use to contact us if our
    | pushes start misbehaving. Required by RFC 8292.
    */
    'subject' => env('WEBPUSH_VAPID_SUBJECT', 'mailto:info@xpertva.com'),

];
