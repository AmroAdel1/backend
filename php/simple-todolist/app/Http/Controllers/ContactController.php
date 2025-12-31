<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\ContactAutoReply;

class ContactController extends Controller
{
    function index(){
        return view('contact-us');
    }

    function submit(Request $request){

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        // Send email using Mailable class
        Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));   // Send email (configure mail settings in .env first)

        Mail::to($validated['email'])->send(new ContactAutoReply());                    // Send auto-reply to sender

        return redirect()->route('todos.index')
            ->with('success', 'Your message has been sent successfully!');
    }
}

/*
php artisan make:mail TestMail          // Mailable Class

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

Route::get('/send-test-email', function () {            // Send a Test Email
    Mail::to('recipient@example.com')->send(new TestMail());
    return 'Email sent to Mailtrap!';
});


Sending Email: You would use Laravel's built-in mail functionality, often involving a separate Mailable class to structure the email content. The controller method uses the Mail facade to dispatch the email.
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail; // Your specific Mailable class       (Sending Email)

// ... in the store method after validation:
Mail::to('your_email@example.com')->send(new ContactFormMail($validated));

// Log the submission
//Log::info('Contact Form Submission', $contactData);
*/
