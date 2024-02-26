<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::select('id', DB::raw('concat(first_name, " ", last_name) as name'), 'email', 'gender', 'phone', 'address')->user()->get();
        return view('userList', ['users' => $users]);
    }

    public function show() {
        return view('profile', ['user' => auth()->user()]);
    }
}
