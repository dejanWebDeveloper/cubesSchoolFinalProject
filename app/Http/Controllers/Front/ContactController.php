<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('front.contact_page.contact_page');
    }
    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:2', 'max:30', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'message' => ['required', 'string', 'min:5', 'max:500'],
            'g-recaptcha-response' => new ReCaptcha()
        ]);
        Mail::to('dejan_web@outlook.com')->send(new ContactUs($data['name'], $data['email'], $data['message']));
        session()->put('system_message', 'Your message has been received!');
        return redirect()->back();
    }
}
