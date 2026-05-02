<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->withFragment('contact');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('contact');
        }

        $validated = $validator->validated();

        try {
            Mail::to(config('mail.contact_to.address', 'milfinawaf@gmail.com'))->send(new ContactMessageMail($validated));
        } catch (Throwable $exception) {
            Log::error('Failed to send portfolio contact message.', [
                'error' => $exception->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['contact' => 'Message could not be sent right now. Please try again later.'])
                ->withFragment('contact');
        }

        return back()
            ->with('contact_success', 'Thank you. Your message has been sent.')
            ->withFragment('contact');
    }
}
