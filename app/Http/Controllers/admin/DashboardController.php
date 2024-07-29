<?php

namespace App\Http\Controllers\admin;

use App\Models\Donation;
use App\Models\User;
use App\Models\Admin;
use App\Models\Fund;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $acc = Auth::guard('admin')->user();

        $statUsers = User::count();
        $statAdmins = Admin::count();
        $statFunds = Fund::count();
        $statDonations = DB::table('transactions')
                            ->join('donations', 'transactions.transaction_id', '=', 'donations.transaction_id')
                            ->where('transaction_status', '1')
                            ->sum('transaction_amount');

        $users = User::orderBy('created_at', 'desc')->limit(6)->get();
        $donors = DB::table('donations')
                  ->join('transactions', 'donations.transaction_id', 'transactions.transaction_id')
                  ->where('transaction_status', '1')
                  ->orderBy('transactions.created_at', 'desc')
                  ->limit(3)
                  ->get();

        
        return view('admin.dashboard', compact('acc','users','donors','statUsers','statAdmins','statDonations','statFunds'));
    }
}
