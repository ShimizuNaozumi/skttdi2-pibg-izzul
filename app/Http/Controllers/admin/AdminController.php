<?php

namespace App\Http\Controllers\admin;

use App\Mail\AdminRegistration;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function admins()
    {
        $acc = Auth::guard('admin')->user();
        $admins = DB::table('admins')
                  ->where('admin_id', '!=', $acc->id)
                  ->where('admin_category', '!=', '1')
                  ->get();
        return view('admin.admins', compact('acc','admins'));
    }
    public function create_admin(Request $request)
    {
        $request->validate([
            'username' => 'string',
            'name' => 'required|string',
            'email' => 'required|email',
            'category' => 'required|integer',
        ]);

        if(Admin::where('admin_email', $request->email)->exists()){
            return back()->with([
                'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                'alert' => 'danger',
                'title' => 'Pendaftaran gagal',
                'message' => 'Akaun sudah berdaftar.',
            ]);
        }else{

            if($request->username == null){
                // Generate a username based on the name
                $baseUsername = strtolower(explode(' ', trim($request->name))[0]);
                $username = $baseUsername;
                $counter = 1;

                // Check for uniqueness and append a number if necessary
                while (Admin::where('admin_username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
            }else{
                $username = $request->username;
            }

            if(Admin::where('admin_username', $username)->exists()){
                return back()->withInput()->with([
                    'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                    'alert' => 'danger',
                    'title' => 'Pendaftaran gagal',
                    'message' => 'Username sudah digunakan.',
                ]);
            }
            
            $generatedPassword = Str::password(8);
            Admin::create([
                        'admin_username' => $username,
                        'admin_name' => $request->name,
                        'admin_email' => $request->email,
                        'admin_status' => 1,
                        'admin_category' => $request->category,
                        'admin_password' => $generatedPassword,
                    ]);

            Mail::to($request->email)->send(new AdminRegistration([
                'name' => $request->name,
                'username' => $username,
                'password' => $generatedPassword,
            ]));

            return back()->with([
                'icon' => '<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" />',
                'alert' => 'success',
                'title' => 'Pendaftaran berjaya',
                'message' => 'Akaun berjaya didaftar.',
            ]);
        }
    }
    public function activate(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->admin_status = '1';
        $admin->save();

        return to_route('admins');
    }
    public function deactivate(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->admin_status = '2';
        $admin->save();

        return to_route('admins');
    }
}
