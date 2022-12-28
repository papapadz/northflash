<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index() {

        return view('pages.admin.accounts.index')->with('accounts',User::get());
    }

    public function store(Request $request) {

        $this->validate($request, [
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'password' => 'required|min:4',
        ]);
        
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);
        return redirect()->back()->with('success','Account created!');
    }
}
