<?php

namespace App\Http\Controllers\admin;

use App\Mail\ChangePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function login_admin()
    {
        return view('admin.login');
    }

    public function auth_admin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'admin_email' : 'admin_username';

        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password'),
        ];
    
        if (Auth::guard('admin')->attempt($credentials)) {

            $admin = Auth::guard('admin')->user();

            if ($admin->admin_status != 1) {
                Auth::guard('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with([
                    'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                    'alert' => 'danger',
                    'message' => 'Akaun anda telah dinyahaktifkan. Sila hubungi pentadbir untuk maklumat lanjut.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
    
        return back()->with([
            'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
            'alert' => 'danger',
            'message' => 'Username/E-mel atau kata laluan tidak tepat.',
        ]);
    }

    public function forgot_username()
    {
        return view('admin.forgot_username');
    }
    public function forgot_password()
    {
        return view('admin.forgot_password');
    }
    public function change_password(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $acc = DB::table('admins')
                ->where('admin_username', $request->username)
                ->first();
        
        if($acc){
            Mail::to($acc->admin_email)->send(new ChangePassword([
                'id' => $acc->admin_id,
            ]));
            return back()->with([
                'icon' => '<path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" />',
                'alert' => 'success',
                'message' => 'E-mel telah dihantar',
            ]);

        }else{
            return back()->withInput()->with([
                'icon' => '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" />',
                'alert' => 'danger',
                'message' => 'Username tidak wujud.',
            ]);
        }
    }
    public function modify_password(string $id){
        $id = decrypt_string($id);
        return view('admin.change_password', compact('id'));
    }
}
