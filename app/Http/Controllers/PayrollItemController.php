<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollItem;

class PayrollItemController extends Controller
{
    public function index() {

        $payrollItems = PayrollItem::where('flexirate',false)->get();

        return view('pages.admin.payrollItem.index')
            ->with('payrollItems',$payrollItems);
    }

    public function store(Request $request) {

        $percentage = 0;
        if($request->percentage>0)
            $percentage = $request->percentage/100;

        $payrollItem = PayrollItem::firstOrCreate(
            ['item' => $request->item ],
            [
                'amount' => $request->amount,
                'percentage' => $percentage,
                'type' => $request->type,
                'date_effective' => $request->date_effective
            ]
        );

        if($payrollItem->wasRecentlyCreated)
            return redirect()->back()->with('success','Record has been added!');
        else
            return redirect()->back()->with('danger','Item name already exists!');
    }

    public static function delete($id) {
        PayrollItem::find($id)->delete();
    }
}