<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

    public function view($id) {
        return view('pages.admin.accounts.view')->with('account',User::find($id));
    }

    public function update(Request $request) {

        User::where('id',$request->id)->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->back()->with('success','Account has been updated!');
    }

    public function delete($id) {

        if(User::count()>1) {
            User::find($id)->delete();
            return redirect()->back()->with('success','Account has been deleted!');
        }
        return redirect()->back()->with('danger','Cannot delete last account!');
    }
}
