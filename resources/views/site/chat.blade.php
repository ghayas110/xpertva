{{--
    Website chat widget. Anonymous visitors; the conversation token lives in
    localStorage so a refresh keeps the thread. WhatsApp is offered alongside
    rather than instead, because some people would simply rather use it.
--}}
@php
    $waNumber  = '17324906272';
    $waDisplay = '+1 (732) 490-6272';
@endphp

<div class="chat" id="chat-widget"
     data-start="{{ route('chat.start') }}"
     data-wa="https://wa.me/{{ $waNumber }}?text={{ rawurlencode('Hi XpertVA, I have a question about my marketplace account.') }}">

    <div class="chat__panel" id="chat-panel" role="dialog" aria-modal="false" aria-label="Chat with XpertVA" hidden>
        <div class="chat__head">
            <span class="chat__avatar" aria-hidden="true">
                <img src="{{ asset('favicon-32x32.png') }}" alt="" width="32" height="32">
            </span>
            <span class="chat__who">
                <strong>XpertVA</strong>
                <span class="chat__status" id="chat-status">Monday to Friday, 09:00 to 18:00 Eastern</span>
            </span>
            <button type="button" class="chat__x" id="chat-close" aria-label="Close chat">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="chat__body" id="chat-body">
            <div class="chat__msg chat__msg--them">
                <p>Hello. Tell us what you sell and where it is stuck, and an operator will pick this up.</p>
            </div>

            <div class="chat__quick" id="chat-quick">
                <button type="button" data-q="I want a free listing audit for one ASIN.">Free listing audit</button>
                <button type="button" data-q="What does it cost to have you run my Amazon account?">What does it cost?</button>
                <button type="button" data-q="I sell on Shopify and Walmart as well as Amazon. Can you handle all of them?">Multiple marketplaces</button>
                <button type="button" data-q="I would like to book a consultation.">Book a consultation</button>
            </div>
        </div>

        {{-- Shown once, before the first message is sent. --}}
        <div class="chat__intro" id="chat-intro">
            <div class="chat__row">
                <label class="sr-only" for="chat-name">Your name</label>
                <input id="chat-name" type="text" placeholder="Your name" autocomplete="name" maxlength="120">
                <label class="sr-only" for="chat-email">Email</label>
                <input id="chat-email" type="email" placeholder="Email" autocomplete="email" maxlength="190">
            </div>
        </div>

        <form class="chat__compose" id="chat-form">
            <label class="sr-only" for="chat-input">Message</label>
            <textarea id="chat-input" rows="1" placeholder="Write a message" maxlength="2000" required></textarea>
            <button type="submit" class="chat__send" id="chat-send" aria-label="Send message">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4Z"/></svg>
            </button>
        </form>

        <p class="chat__err" id="chat-err" role="alert" hidden></p>

        <a class="chat__wa" id="chat-wa" href="#" target="_blank" rel="noopener noreferrer">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884a9.82 9.82 0 0 1 6.988 2.896 9.82 9.82 0 0 1 2.893 6.994c-.003 5.45-4.437 9.886-9.885 9.886M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.359.101 11.945c0 2.096.549 4.142 1.595 5.945L0 24l6.305-1.654a11.9 11.9 0 0 0 5.683 1.448h.005c6.585 0 11.946-5.359 11.949-11.945a11.9 11.9 0 0 0-3.421-8.4"/></svg>
            Continue on WhatsApp
            <span class="chat__wa-num">{{ $waDisplay }}</span>
        </a>
    </div>

    <button type="button" class="chat__bubble" id="chat-toggle" aria-expanded="false" aria-controls="chat-panel">
        <span class="chat__bubble-open" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
        </span>
        <span class="chat__bubble-close" aria-hidden="true" hidden>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </span>
        <span class="sr-only">Open chat</span>
        <span class="chat__dot" id="chat-dot" hidden aria-hidden="true"></span>
    </button>
</div>
