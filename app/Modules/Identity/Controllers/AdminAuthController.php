<?php

namespace App\Modules\Identity\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Identity\Requests\LoginRequest;
use App\Modules\Identity\Services\AuthService;
use App\Modules\Identity\Services\CaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected CaptchaService $captchaService
    ) {}

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $captchaImage = $this->captchaService->generate();

        return view('admin.identity.auth.login', compact('captchaImage'));
    }

    public function login(LoginRequest $request)
    {
        // 1. Validasi Captcha
        if (!$this->captchaService->validate($request->input('captcha'))) {
            return back()->withErrors([
                'captcha' => 'Kode captcha yang Anda masukkan tidak sesuai.',
            ])->onlyInput('email');
        }

        // 2. Cek Kredensial Login
        $credentials = $request->only('email', 'password');

        if ($this->authService->attemptLogin($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function refreshCaptcha()
    {
        return response()->json([
            'captcha' => $this->captchaService->generate()
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
