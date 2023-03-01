<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Setting;

class ReferralController extends Controller
{
    // NOTE GET /manage/refferal
    public function index()
    {
        $setting =  Setting::find(1);
       
        $data = [
            'js'        => 'components.scripts.BE.admin.manage.referral',
            'title'     => 'referral',
            'setting'    => $setting,
        ];

        return view('pages.BE.admin.manage.referral', $data);
    }
    // NOTE GET /manage/refferal
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('users')
                    ->join('user_details', 'user_details.user_id', '=', 'users.id')
                    ->join('banks', 'user_details.bank_id', '=', 'banks.id')
                ->select([
                    'users.*', 'user_details.point','user_details.account_number',
                    'banks.name as nama_bank'
                ])
                    ->where('users.id', $any)
                    ->first();

                $data->point = 'Rp. ' . number_format($data->point);

                return response()->json($data);
            }

            $data = DB::table('users')
                ->join('user_details', 'user_details.user_id', '=', 'users.id')
                ->select([
                    'users.*', 'user_details.point'
                ])
                ->orderBy('name', 'asc');

            return DataTables::of($data)
                ->editColumn(
                    'point',
                    function ($row) {
                        return number_format($row->point);
                    }
                )
                
                ->addColumn(
                    'action',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'point' => $row->point,
                        ];

                        return view('components.buttons.BE.manage.referral', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/refferal/{id}
    public function transfer(Request $request, $id)
    {
       

       

        try {
            $user = DB::table('users')
                ->join('user_details', 'user_details.user_id', '=', 'users.id')
                ->join('banks', 'user_details.bank_id', '=', 'banks.id')
                ->select([
                    'users.*', 'user_details.point','user_details.account_number',
                    'banks.name as nama_bank'
                ])
                ->where('users.id', $id)
                ->first();

            if (!$user) {
                $json   = [
                    'msg'       => 'User tidak ditemukan',
                    'status'    => false
                ];
            }elseif (!$request->image) {
                $json   = [
                    'msg'       => 'Mohon masukan bukti transfer',
                    'status'    => false
                ];
            }  elseif (!$request->debit) {
                $json   = [
                    'msg'       => 'Mohon masukan nominal transfer',
                    'status'    => false
                ];
            } else {
                $debit = str_replace(',', '', $request->debit);

                if ($user->point < $debit) {
                    $json   = [
                        'msg'       => 'Nominal transfer lebih besar dari saldo member',
                        'status'    => false
                    ];
                } else {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    //dd($extension);
                    $image  = date('YmdHis') . '' . str_replace(' ', '', $debit) . '.' . $extension;
                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/referral');
                    } else {
                        $destination        = '/home/masterti/public_html/assets/images/referral';
                    }
                    $request->file('image')->move($destination, $image);
                    DB::transaction(function () use ($debit, $id,$image) {

                        

                        DB::table('point_transactions')->insert([
                            'created_at'    => date('Y-m-d H:i:s'),
                            'debit'         => $debit,
                            'user_id'       => $id,
                            'image'         => $image,
                        ]);

                        $credit = DB::table('point_transactions')->where('user_id', $id)->sum('credit');
                        $debit  = DB::table('point_transactions')->where('user_id', $id)->sum('debit');

                        $point = ($credit - $debit);

                        DB::table('user_details')->where('user_id', $id)->update([
                            'point' => $point
                        ]);
                    });

                    $json = [
                        'msg'       => 'Data berhasil direkam',
                        'status'    => true
                    ];
                }
            }
        } catch (Exception $e) {
            $json   = [
                'line'      => $e->getLine(),
                'message'   => $e->getMessage(),
                'msg'       => 'Error',
                'status'    => false
            ];
        }

        return response()->json($json);
    }
}
