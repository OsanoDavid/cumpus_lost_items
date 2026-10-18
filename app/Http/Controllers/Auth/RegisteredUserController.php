<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request with strict validation and explicit failure reasons.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                   => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone'                  => ['required', 'string', 'max:10', 'regex:/^[0-9]{10}$/'], // Phone cannot exceed 10 digits
            'reg_number'             => ['required', 'string', 'regex:/^[A-Za-z0-9]{1,5}\/\d{1,5}\/\d{1,2}$/', 'unique:'.User::class],
            'course'                 => ['required', 'string', 'max:255'],
            'year_of_study'          => ['required', 'string', 'in:Year 1,Year 2,Year 3,Year 4,Year 5,Year 6'],
            'school'                 => ['required', 'string', 'max:255'],
            'password'               => ['required', 'confirmed', Rules\Password::defaults()],
            'reason_for_registering' => ['required', 'string'],
            'what_lost'              => ['nullable', 'string'],
            'what_searching'         => ['nullable', 'string'],
        ], [
            // Explicit error feedback explaining why registration cannot proceed
            'reg_number.regex'       => 'We cannot register your account because of an invalid registration number format. Please use format like IN13/00000/23 (e.g. IN13/00000/23).',
            'reg_number.unique'      => 'We cannot register your account because this registration number is already registered in the system.',
            'reg_number.required'    => 'We cannot register your account because registration number is required.',
            
            'phone.max'              => 'We cannot register your account because the phone number exceeds 10 digits. Please provide a 10-digit phone number (e.g., 0712345678).',
            'phone.regex'            => 'We cannot register your account because the phone number must be exactly 10 numeric digits (e.g., 0712345678).',
            'phone.required'         => 'We cannot register your account because a 10-digit phone number is required.',
            
            'password.confirmed'     => 'We cannot register your account because the password confirmation does not match the entered password.',
            'password.required'      => 'We cannot register your account because a password is required.',
            
            'email.unique'           => 'We cannot register your account because this email address is already associated with an account.',
            'name.required'          => 'We cannot register your account because your full name is required.',
            'course.required'        => 'We cannot register your account because your degree/diploma course is required.',
            'school.required'        => 'We cannot register your account because your school/faculty is required.',
        ]);

        $user = User::create([
            'name'                   => $request->name,
            'email'                  => $request->email,
            'phone'                  => $request->phone,
            'reg_number'             => $request->reg_number,
            'course'                 => $request->course,
            'year_of_study'          => $request->year_of_study,
            'school'                 => $request->school,
            'password'               => Hash::make($request->password),
            'reason_for_registering' => $request->reason_for_registering,
            'what_lost'              => $request->what_lost,
            'what_searching'         => $request->what_searching,
            'is_admin'               => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on intent
        if ($request->reason_for_registering === 'Posting a lost item') {
            return redirect(route('dashboard.finder'))->with('success', 'Registration successful! Welcome to the Finder Hub.');
        } else {
            return redirect(route('dashboard.seeker'))->with('success', 'Registration successful! Welcome to the Seeker Hub.');
        }
    }
}