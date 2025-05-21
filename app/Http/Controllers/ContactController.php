<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Send email
        Mail::to('sthsarita18@gmail.com')->send(new ContactFormMail($request->all()));

        // Redirect with success message
        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}
