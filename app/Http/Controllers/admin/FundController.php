<?php

namespace App\Http\Controllers\admin;


use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FundController extends Controller
{
    public function add_fund()
    {
        $acc = Auth::guard('admin')->user();
        return view('admin.add_fund', compact('acc'));
    }
    public function create_fund(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'target' => 'required|numeric|min:0',
            'image' => 'required|image|file|max:20480'
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $path = 'uploads/images/';
        $file->move($path,$filename);

        Fund::create([
            'admin_id' => $request->admin_id,
            'fund_name' => $request->name,
            'fund_description' => $request->description,
            'fund_target' => $request->target,
            'fund_image_path' => $path.$filename,
        ]);

        return to_route('fund');
    }

    public function fund()
    {
        $acc = Auth::guard('admin')->user();
        
        $funds = DB::table('funds')
            ->join('admins', 'funds.admin_id', '=', 'admins.admin_id')
            ->select('funds.*', 'admins.*')
            ->get();
        
        $donations = DB::table('donations')
            ->join('transactions', 'donations.transaction_id', '=', 'transactions.transaction_id')
            ->select('donations.fund_id', DB::raw('SUM(transaction_amount) as total_donations'))
            ->where('transaction_status', 1)
            ->groupBy('donations.fund_id')
            ->get();
        
        // Map donations to funds
        $funds = $funds->map(function ($fund) use ($donations) {
            $donation = $donations->firstWhere('fund_id', $fund->fund_id);
            $fund->total_donations = $donation ? $donation->total_donations : 0;
            return $fund;
        });

        return view('admin.fund', compact('acc', 'funds'));
    }

    public function edit_fund(string $id)
    {
        $id = decrypt_string($id);
        $acc = Auth::guard('admin')->user();
        $fund = Fund::find($id);
        return view('admin.edit_fund', compact('acc','fund'));
    }
    public function update_fund(Request $request, string $id)
    {
        $id = decrypt_string($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'target' => 'required|numeric|min:0',
            'image' => 'image|file|max:20480'
        ]);

        $fund = Fund::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($fund->fund_image_path && file_exists(public_path($fund->fund_image_path))) {
                unlink(public_path($fund->fund_image_path));
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/images/';
            $file->move(public_path($path), $filename);
            $fund->fund_image_path = $path . $filename;
        }

        
        $fund->fund_name = $request->name;
        $fund->fund_description = $request->description;
        $fund->fund_target = $request->target;
        $fund->save();

        return to_route('fund');
    }

    public function delete_fund(string $id)
    {
        $id = decrypt_string($id);

        $fund = DB::table('funds')
                ->join('donations', 'funds.fund_id', '=', 'donations.fund_id')
                ->join('transactions', 'transactions.transaction_id', '=', 'donations.transaction_id')
                ->select(DB::raw('SUM(transaction_amount) as total_amount'))
                ->where('funds.fund_id', $id)
                ->first();

        if($fund && $fund->total_amount > 0.01){
            return back()->with([
                'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                'alert' => 'danger',
                'title' => 'Gagal dihapuskan',
                'message' => 'Tabung yang mempunyai sumbangan tidak boleh dihapuskan.',
            ]);
        }else{
            DB::table('funds')->where('fund_id', $id)->delete();
            return back()->with([
                'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                'alert' => 'success',
                'title' => 'Berjaya dihapuskan',
                'message' => 'Tabung telah berjaya dipadam.',
            ]);
        }
    }

    public function publish_fund(string $id)
    {
        $id = decrypt_string($id);

        $fund = Fund::findOrFail($id);
        $fund->fund_status = '2';
        $fund->save();

        return to_route('fund');
    }

    public function conceal_fund(string $id)
    {
        $id = decrypt_string($id);
        
        $fund = Fund::findOrFail($id);
        $fund->fund_status = '1';
        $fund->save();

        return to_route('fund');
    }


}
