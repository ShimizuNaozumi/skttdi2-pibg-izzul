<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function fee()
    {
        $acc = Auth::guard('admin')->user();

        // $fees = DB::table('fees')
        //                 ->join('transactions', 'fees.transaction_id', '=', 'transactions.id')
        //                 ->select('fees.*', 'transactions.*')
        //                 ->get();
                        
        return view('admin.fee',compact('acc'));
    }
}
