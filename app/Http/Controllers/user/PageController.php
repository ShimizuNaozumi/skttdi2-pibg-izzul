<?php

namespace App\Http\Controllers\user;

use App\Models\Fund;
use App\Models\User;
use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        $funds = DB::table('funds')
                ->where('fund_status', '!=', '1')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
    $donations = DB::table('donations')
                ->join('transactions', 'donations.transaction_id', '=', 'transactions.transaction_id')
                ->select('donations.fund_id', DB::raw('SUM(transactions.transaction_amount) as total_donations'))
                ->where('transactions.transaction_status', 1)
                ->groupBy('donations.fund_id')
                ->get();

            
        // Map donations to funds
        $funds = $funds->map(function ($fund) use ($donations) {
                $donation = $donations->firstWhere('fund_id', $fund->fund_id);
                $fund->total_donations = $donation ? $donation->total_donations : 0;
                return $fund;
            });

        return view('user.index' , compact('funds'));
    }

    public function pibg()
    {
        return view('user.pibg');
    }

    public function tabung()
    {
        $funds = DB::table('funds')
                ->where('fund_status', '!=', '1')
                ->orderBy('created_at', 'desc')
                ->get();

        $donations = DB::table('donations')
                ->join('transactions', 'donations.transaction_id', '=', 'transactions.transaction_id')
                ->select('donations.fund_id', DB::raw('SUM(transactions.transaction_amount) as total_donations'))
                ->where('transactions.transaction_status', 1)
                ->groupBy('donations.fund_id')
                ->get();
            
        // Map donations to funds
        $funds = $funds->map(function ($fund) use ($donations) {
                $donation = $donations->firstWhere('fund_id', $fund->fund_id);
                $fund->total_donations = $donation ? $donation->total_donations : 0;
                return $fund;
            });
                
        return view('user.tabung' , compact('funds'));
    }
    
    public function login_user()
    {
        return view('user.login');
    }

    public function detail(string $id)
    {
        $details = Fund::find($id);
        $donors = DB::table('donations')
                ->where('donations.fund_id', $id)
                ->count();

        $donations = DB::table('donations')
                    ->join('transactions', 'donations.transaction_id', 'transactions.transaction_id')
                    ->where('donations.fund_id', $id)
                    ->sum('transaction_amount');
        return view('user.detail', compact('details','donors','donations'));

    }

    public function sumbang(string $id)
    {
        $details = Fund::find($id);
        $acc = Auth::user();
        return view('user.payment', compact('details' , 'acc'));
    }

    public function edit()
    {
        $acc = Auth::user();
        return view('user.update', compact('acc'));
    }

    public function akaun()
    {
        $guardians = Guardian::all();
        $students = Student::all();
        $acc = Auth::user();
        return view('user.akaun' , compact('acc' , 'guardians' , 'students'));
    }
}

