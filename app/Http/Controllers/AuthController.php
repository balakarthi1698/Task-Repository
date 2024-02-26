<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginPage() {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('login');
    }

    public function registerPage() {
        if (Auth::check()) {
            return redirect(route('home'));
        }
        return view('register');
    }

    public function login(LoginRequest $request) {
        $credentials = request(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            return redirect(route('loginPage'))->with("error", "Incorrect Email or Password");
        }
        $user = $request->user();
        $tokenResult = $user->createToken('access_token', ['*']);
        $user->update([
            'access_token' => $tokenResult->accessToken->token,
            'access_token_expires_at' => $tokenResult->accessToken->expires_at
        ]);

        $user->save();
        return redirect()->intended(route('home'));
    }

    public function register(RegisterRequest $request) {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        //Mail
        try {
            $template = '<p>Dear '.$user->first_name.' '.$user->last_name.',</p><p>Thank you for registration. Please find below your submitted details.</p>
                <p>Username: '.$user->email.'<br>Password: '.$request->password.'<br>Gender: '.$user->gender.'<br>Address: '.$user->address.'<br>Phone: '.$user->phone.'<br></p>
                <p>Thanks,<br>Admin</p>';
            Mail::html($template, function ($message) use ($user) {
                $message->to(trim($user->email))
                    ->from(env('ADMIN_EMAIL'))
                    ->subject('Registered Successfully');
            });
        } catch (Exception $e) {
            Log::error($e);
        }
        return redirect(route('loginPage'))->with('success', 'Registration successful, Login to access the app');
    }

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
        return redirect(route('loginPage'));
    }
}
