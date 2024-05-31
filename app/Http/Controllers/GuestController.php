<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers',
        ], [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already subscribed.'
        ]);

        // Create a new subscriber
        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'You have successfully subscribed to our newsletter!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Your name is required.',
            'email.required' => 'Your email is required.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'The subject is required.',
            'message.required' => 'The message is required.',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent. Thank you!');
    }
}
