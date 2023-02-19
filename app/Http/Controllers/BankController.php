<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;


class BankController extends Controller
{
    // NOTE /master-data/bank
    public function index()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.masterData.bank';

            $data = [
                'js'    => $js,
                'title' => 'Bank',
                'setting'    => $setting,
            ];

            return view('pages.BE.admin.masterData.bank', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /master-data/bank/{id}
    public function destroy($id)
    {
        try {
            $canDelete = DB::table('user_details')->where('bank_id', $id)->count();

            if ($canDelete > 0) {
                $json   = [
                    'msg'       => 'Data tidak dapat dihapus',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($id) {
                    DB::table('banks')->where('id', $id)->delete();
                });

                $json = [
                    'msg'       => 'bank berhasil dihapus',
                    'status'    => true
                ];
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
    // NOTE GET /master-data/bank/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('banks')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('banks');

            return DataTables::of($data)
                ->addColumn(
                    'action',
                    function ($row) {
                        $canDelete = DB::table('user_details')->where('bank_id', $row->id)->count();

                        $data   = [
                            'canDelete' => $canDelete,
                            'id'        => $row->id
                        ];

                        return view('components.buttons.BE.masterData.bank', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /master-data/bank
    public function store(Request $request)
    {
        try {
            $bankisRegistered = DB::table('banks')->where('name', $request->name)->first();

            if ($request->name == null) {
                $json   = [
                    'msg'       => 'Mohon isi nama bank',
                    'status'    => false
                ];
            } elseif ($bankisRegistered) {
                $json   = [
                    'msg'       => 'Bank sudah terdaftar',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($request) {
                    DB::table('banks')->insert([
                        'created_at'    => date('Y-m-d H:i:s'),
                        'name'          => $request->name
                    ]);
                });

                $json = [
                    'msg'       => 'bank berhasil ditambahkan',
                    'status'    => true
                ];
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
    // NOTE POST /master-data/bank/{id}
    public function update(Request $request, $id)
    {
        try {
            $bankisRegistered = DB::table('banks')->where('id', $id)->first();
            $bankNameisRegistered = DB::table('banks')->where('name', $request->name)->where('id', '<>', $id)->first();

            if (!$bankisRegistered) {
                $json   = [
                    'msg'       => 'Bank tidak ditemukan',
                    'status'    => false
                ];
            } elseif ($request->name == null) {
                $json   = [
                    'msg'       => 'Mohon isi nama bank',
                    'status'    => false
                ];
            } elseif ($bankNameisRegistered) {
                $json   = [
                    'msg'       => 'Bank sudah terdaftar',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($request, $id) {
                    DB::table('banks')->where('id', $id)->update([
                        'name'          => $request->name,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                });

                $json = [
                    'msg'       => 'bank berhasil disunting',
                    'status'    => true
                ];
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
