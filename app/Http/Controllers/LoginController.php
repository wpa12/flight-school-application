<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request): RedirectResponse
    {
        $remember = $request->boolean('remember');
        $normaliseEmail = strtolower(trim($request->input('email')));

        if (! Auth::attempt([
            'email' => $normaliseEmail,
            'password' => $request->input('password'),
        ], $remember)) {

            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }
}
