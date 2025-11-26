<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user (mendukung bcrypt & non-bcrypt)
     */
    public function login(Request $request)
    {
      $request->validate([
          'email'    => 'required|email',
          'password' => 'required',
      ]);

      $credentials = $request->only('email', 'password');
      $user = User::where('email', $credentials['email'])->first();

      if ($user) {
          $inputPassword = $credentials['password'];
          $dbPassword = $user->password;

          // Cek apakah password di database hasil bcrypt (biasanya panjangnya 60 dan diawali '$2y$')
          $isBcrypt = strlen($dbPassword) === 60 && str_starts_with($dbPassword, '$2y$');

          $validPassword = $isBcrypt
              ? Hash::check($inputPassword, $dbPassword)
              : $dbPassword === $inputPassword;

          if ($validPassword) {
              Auth::login($user);
              return redirect('/home')->with('success', 'Selamat datang, ' . $user->name);
          }
      }

      return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses register user baru (pakai bcrypt)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        // Simpan password dalam bentuk hash (bcrypt)
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect('/home')->with('success', 'Akun berhasil dibuat, selamat datang ' . $user->name);
    }
}