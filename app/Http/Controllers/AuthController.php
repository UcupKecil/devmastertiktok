<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //NOTE POST /auth/login
    public function login(Request $request)
    {
        try {
            $rules = [
                'email'     => 'required|email|exists:users,email',
                'password'  => 'required|min:8'
            ];

            $messages = [
                'email.required'    => 'Email wajib diisi',
                'email.email'       => 'Email tidak valid',
                'email.exists'      => 'Email tidak terdaftar',
                'password.required' => 'Password wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->has('remember')) {
                $remember = true;
            } else {
                $remember = false;
            }

            $data = [
                'email'     => $request->email,
                'password'  => $request->password,
            ];

            Auth::attempt($data, $remember);

            if (Auth::check()) {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->withInput()->withErrors(['error' => 'Password salah!']);
            }
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    //NOTE GET /auth/logout
    function logout()
    {
        Auth::logout();

        Session::flush();

        return redirect()->to('/auth/login');
    }
    // NOTE GET /auth/register/{slug}
    public function setCourse($slug)
    {
        $valid = DB::table('courses')->where('slug', $slug)->first();

        if ($valid) Session::put('course', $valid->id);

        return redirect('/auth/register');
    }
    //NOTE POST /auth/register
    public function register(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|min:8',
                'phone'     => 'required|unique:user_details,phone',
                'channel'   => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama wajib diisi',
                'email.required'    => 'Email wajib diisi',
                'email.email'       => 'Email tidak valid',
                'email.unique'      => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min'      => 'Password harus mengandung lebih dari 8 karakter',
                'phone.required'    => 'Nomor telepon wajib diisi',
                'phone.unique'      => 'Nomor telepon sudah terdaftar',
                'channel.required'  => 'Metode pembayaran wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            $url = DB::transaction(function () use ($request) {
                $course = DB::table('courses')->where('id', Session::get('course'))->first();

                $referred_by = Session::get('referral') ?? null;

                if ($referred_by) {
                    $referred_by = DB::table('user_details')
                        ->where('uid', $referred_by)
                        ->first()
                        ->user_id;
                }

                $data   = [
                    'email'         => $request->email,
                    'name'          => $request->name,
                    'password'      => Hash::make($request->password)
                ];

                $user   = User::create($data);

                $user->syncRoles('Member');

                DB::table('user_details')->insert([
                    'created_at'    => date('Y-m-d H:i:s'),
                    'phone'         => $request->phone,
                    'uid'           => generateUid(),
                    'user_id'       => $user->id,
                ]);

                $client             = new Client();

                if (env('APP_ENV') == 'local') {
                    $url    = 'https://tripay.co.id/api-sandbox/transaction/create';
                    $authorization = 'Bearer DEV-7xaQXEMtSUc5OzLFSfyJWeZfxCPUhM0VoR5HKhvT';
                    $signature = hash_hmac('sha256', 'T19660' . null . intval($course->price), 'Et5y4-nDMd3-LpHCM-KWvPQ-aqqWV');
                } else {
                    $url    = 'https://tripay.co.id/api/transaction/create';
                    $authorization = 'Bearer eAc71WSvQAc1L2b62vtQNKVzTvlMSosvJf0BPuY5';
                    $signature = hash_hmac('sha256', 'T19686' . null . intval($course->price), 'ASMIM-xFYzi-F7U9V-Q8XJf-CsKGG');
                }

                $course = DB::table('courses')->where('id', Session::get('course'))->first();

                $order_items[0] = [
                    'sku'       => null,
                    'name'      => $course->name,
                    'price'     => intval($course->price),
                    'quantity'  => 1,
                ];

                $response           = $client->request('POST', $url, [
                    'headers'       => [
                        'Authorization'     => $authorization
                    ],
                    'form_params'   => [
                        'method'            => $request->channel,
                        'merchant_ref'      => null,
                        'amount'            => intval($course->price),
                        'customer_name'     => $request->name,
                        'customer_email'    => $request->email,
                        'customer_phone'    => $request->phone,
                        'order_items'       => $order_items,
                        'callback_url'      => url('/api/gateway-tripay'),
                        'return_url'        => url('/'),
                        'expired_time'      => (time() + (24 * 60 * 60)),
                        'signature'         => $signature
                    ]
                ]);

                $data               = json_decode($response->getBody(), true);

                $checkout_url       = $data['data']['checkout_url'];
                $reference          = $data['data']['reference'];

                $total      = intval($course->price) + intval($request->biaya_adm);

                DB::table('orders')->insert([
                    'biaya_adm'     => $request->biaya_adm,
                    'channel'       => $request->channel,
                    'course_id'     => Session::get('course'),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'referred_by'   => $referred_by,
                    'user_id'       => $user->id,
                    'sub_total'     => $course->price,
                    'reference'     => $reference,
                    'total'         => $total,
                ]);

                return $data['data']['checkout_url'];
            });

            Session::flush();

            $data = [
                'email'     => $request->email,
                'password'  => $request->password,
            ];

            Auth::attempt($data);

            if (Auth::check()) {
                return redirect()->to($url);
            } else {
                return redirect()->back()->withInput()->withErrors(['error' => 'Password salah!']);
            }
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
}
