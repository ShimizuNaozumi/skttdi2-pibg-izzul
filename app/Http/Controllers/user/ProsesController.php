<?php

namespace App\Http\Controllers\user;

use Exception;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Student;
use App\Models\Donation;
use App\Models\Guardian;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProsesController extends Controller
{


    public function auth_user(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = [
            'user_email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return to_route('index')->with(['message' => 'Anda telah berjaya log masuk.', 'status' => 'success']);
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/')->with(['message' => 'Berjaya log keluar.', 'status' => 'success']);
    }

    public function addG(Request $request){
        $request->validate([
            'guardian_name'=> 'required|string',
            'guardian_email'=> 'required|email',
            'guardian_notel'=> 'required|string',
            // 'guardian_gaji'=> 'required|string',
            'guardian_role'=> 'required|string',
        ],[
            'guardian_name.required' => 'Masukkan nama.',
            'guardian_email.required' => 'Masukkan e-mel.',
            'guardian_notel.required' => 'Masukkan nombor telefon.',
            // 'guardian_gaji.required' => 'Masukkan gaji bulanan.',
            'guardian_role.required' => 'Sila pilih peranan keluarga.',
        ]);
        

        $guardian_role = $request->guardian_role;

        //pastikan role itu lain
        $existingRole = Guardian::where('guardian_role' , $guardian_role)->first();
        
        if ($existingRole) {
            return to_route('akaun')->with(['message' => 'Peranan tidak boleh sama dengan ahli keluarga yang lain. Sila buang ahli keluarga untuk menggunakan peranan tersebut.', 'status' => 'error']);
        }else{
            $guardian = new Guardian();
            $guardian->guardian_name = $request->guardian_name;
            $guardian->guardian_email = $request->guardian_email;
            $guardian->guardian_notel = $request->guardian_notel;
            // $guardian->guardian_gaji = $request->guardian_gaji;
            $guardian->guardian_role = $guardian_role;
            $guardian->save();
            return to_route('akaun')->with(['message' => 'Berjaya di masukkan.', 'status' => 'success']);
        }
        
       
    }

    public function addS(Request $request){
        $request->validate([
            'student_name'=> 'required|string',
            'student_ic'=> 'required',
            'student_class'=> 'required|string',
        ],[
            'student_name.required' => 'Masukkan nama.',
            'student_ic.required' => 'Masukkan nombor kad pengenalan.',
            'student_class.required' => 'Masukkan nombor telefon.',
        ]);
        
        $guardian = new Student();
        $guardian->student_name = $request->student_name;
        $guardian->student_ic = $request->student_ic;
        $guardian->student_class = $request->student_class;
        $guardian->save();
        return to_route('akaun')->with(['message' => 'Berjaya di masukkan.', 'status' => 'success']);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'notel' => 'required',
            // 'gaji' => 'required',
        ], [
            'name.required' => 'Masukkan nama.',
            'email.required' => 'Masukkan alamat emel.',
            'notel.required' => 'Masukkan nombor telefon.',
            // 'gaji.required' => 'Masukkan gaji bulanan.',
        ]);

        $update = User::findOrFail($id);

        
        $update->user_name = $request->name;
        $update->user_email = $request->email;
        $update->user_notel = $request->notel;
        // $update->gaji = $request->gaji;
        $update->save();

        return to_route('akaun')->with(['message' => 'Maklumat berjaya dikemas kini.', 'status' => 'success']);
    }

    public function gambar(Request $request, string $id){
        $update = User::findOrFail($id);

        if ($request->hasFile('user_photo')) {
            if ($update->photo && file_exists(public_path($update->user_photo))) {
                unlink(public_path($update->user_photo));
            }

            $file = $request->file('user_photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $path = 'uploads/images/';
            $file->move(public_path($path), $filename);
            $update->user_photo = $path . $filename;
        }
        $update->save();

        return to_route('akaun')->with(['message' => 'Gambar berjaya dikemas kini.', 'status' => 'success']);
    
    }

    public function pay(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'notel' => 'required|string',
            'amount' => 'required|numeric|min:2',
            'tabung' => 'required|string|max:255',
            'fund_id' => 'required|integer',
        ]);

        try {
            $client = new Client([
                'verify' => storage_path('certificates/cacert.pem'),
            ]);

            $randomNumber = mt_rand(1000000000, 9999999999);

            $response = $client->post('https://dev.toyyibpay.com/index.php/api/createBill', [
                'form_params' => [
                    'userSecretKey' => env('TOYYIBPAY_API_KEY'),
                    'categoryCode' => env('TOYYIBPAY_CATEGORY_CODE'),
                    'billName' => $request->tabung,
                    'billDescription' => 'Sumbangan untuk tabung ' . $request->tabung,
                    'billPriceSetting' => 1,
                    'billPayorInfo' => 1,
                    'billAmount' => $request->amount * 100,
                    'billReturnUrl' => route('return'),
                    'billCallbackUrl' => route('callBack'),
                    'billExternalReferenceNo' => 'PIBGSKTTDI2-' . $randomNumber,
                    'billTo' => $request->name,
                    'billEmail' => $request->email,
                    'billPhone' => $request->notel,
                    'billSplitPayment' => 0,
                    'billSplitPaymentArgs' => '',
                    'billPaymentChannel' => '2',
                    'billContentEmail' => 'Percubaan berjaya!',
                    'billChargeToCustomer' => 1,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            Log::info('ToyyibPay response: ', $data);

            $billData = $data[0];

            if (isset($billData['BillCode'])) {

                try {
                    $transaction = Transaction::create([
                        'transaction_code' => $billData['BillCode'],
                        'transaction_amount' => $request->amount,
                        'transaction_status' => '2',
                    ]);

                    if ($transaction) {
            
                        Donation::create([
                            'donor_name' => $request->name,
                            'donor_email' => $request->email,
                            'donor_notel' => $request->notel,
                            'fund_id' => $request->fund_id,
                            'transaction_id' => $transaction->transaction_id, 
                        ]);
            
                    } else {
                        Log::error('Failed to create transaction.');
                        return back()->withErrors(['msg' => 'Failed to create transaction.']);
                    }
                    return redirect('https://dev.toyyibpay.com/' . $data[0]['BillCode']);
                } catch (Exception $e) {
                    Log::error('Exception occurred: ' . $e->getMessage());
                    return back()->withErrors(['msg' => 'Error processing payment. Please try again later.']);
                }
            } else {
                Log::error('Error initiating payment: ', $data);
                return back()->withErrors(['msg' => 'Error initiating payment.']);
            }
        } catch (Exception $e) {
            Log::error('Exception occurred: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Error initiating payment. Please try again later']);
        }
    }

    public function return(Request $request)
    {
        $billCode = $request->query('billcode');
        $statusId = $request->query('status_id');

        $client = new Client([
            'verify' => storage_path('certificates/cacert.pem'),
        ]);

        $response = $client->post('https://dev.toyyibpay.com/index.php/api/getBillTransactions', [
            'form_params' => [
                'userSecretKey' => env('TOYYIBPAY_API_KEY'),
                'billCode' => $billCode,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        $transactionData = [
            'transaction_invoiceno' => $data[0]['billpaymentInvoiceNo'],
            'transaction_status' => $statusId,
            'transaction_method' => $data[0]['billpaymentChannel'],
            'transaction_refno' => $data[0]['billExternalReferenceNo'],
            'transaction_issued_date' => date('Y-m-d H:i:s', strtotime($data[0]['billPaymentDate'])),
        ];

        $transaction = Transaction::where('transaction_code', $billCode)->first();
        $transaction->update($transactionData);
        
        if ($statusId == 1) {
            return to_route('index')->with(['message' => 'Terima kasih kerana telah membantu.', 'status' => 'success']);
        } elseif ($statusId == 3) {
            return to_route('index')->with(['message' => 'Proses pembayaran anda gagal.', 'status' => 'error']);
        } else {
            return to_route('index')->with(['message' => 'Pembayaran anda masih dalam proses.', 'status' => 'info']);
        }
    }


    public function callBack(Request $request)
    {
        $billCode = $request->query('billcode');
        $statusId = $request->query('status_id');

        $client = new Client([
            'verify' => storage_path('certificates/cacert.pem'),
        ]);

        $response = $client->post('https://dev.toyyibpay.com/index.php/api/getBillTransactions', [
            'form_params' => [
                'userSecretKey' => env('TOYYIBPAY_API_KEY'),
                'billCode' => $billCode,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        $transactionData = [
            'transaction_invoiceno' => $data[0]['billpaymentInvoiceNo'],
            'transaction_status' => $statusId,
            'transaction_method' => $data[0]['billpaymentChannel'],
            'transaction_refno' => $data[0]['billExternalReferenceNo'],
            'transaction_issued_date' => $data[0]['billPaymentDate'],
        ];

        $transaction = Transaction::where('transaction_code', $billCode)->first();
        $transaction->update($transactionData);

        if ($statusId == 1) {
            return to_route('index')->with(['message' => 'Terima kasih kerana telah membantu.', 'status' => 'success']);
        } elseif ($statusId == 3) {
            return to_route('index')->with(['message' => 'Proses pembayaran anda gagal.', 'status' => 'error']);
        } else {
            return to_route('index')->with(['message' => 'Pembayaran anda masih dalam proses.', 'status' => 'info']);
        }
    }

    
}
