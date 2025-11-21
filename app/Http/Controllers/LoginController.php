<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function showLogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
        $user = User::where('student_number', $credentials['username'])
            ->orWhere('lecturer_code', $credentials['username'])
            ->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {

            Auth::login($user);
            $request->session()->regenerate();

            if ($user->role == "student") {
                return redirect()->route('siswa.dashboard');
            }

            if ($user->role == "admin") {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dosen.dashboard');
        }

        // 4. Login Failed
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
