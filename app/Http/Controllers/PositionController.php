<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function index() {

        $positions = Position::orderBy('title')->get();

        return view('pages.admin.position.index')->with('positions',$positions);
    }

    public function store(Request $request) {

        $position = Position::firstOrCreate(
            ['title' => $request->title]
        );

        if($position)
            return redirect()->back()->with('success','Record has been added!');
        else
            return redirect()->back()->with('danger','Position already exists.');
    }
}
