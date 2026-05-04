<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegistrationRequest;
use App\Services\UserService;

class RegistrationController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {}

    /**
     * Register a new user
     *
     * @param RegistrationRequest $request
     * @return RedirectResponse
     */
    public function register(RegistrationRequest $request): RedirectResponse
    {
        $this->userService->register($request->safe()->only(['name', 'email', 'password']));

        return redirect()->route('login')->with('status', 'Account created. Please sign in.');
    }
}
