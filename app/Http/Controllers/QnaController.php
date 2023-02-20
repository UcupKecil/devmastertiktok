<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class QnaController extends Controller
{
    // NOTE GET /manage/qna
    public function index()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.manage.qna';

            $data = [
                'formUrl'   => url('/manage/qna/create'),
                'js'        => $js,
                'title'     => 'Qna',
                'setting'    => $setting,
            ];

            return view('pages.BE.admin.manage.qna', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /manage/qna/{id}
    public function destroy($id)
    {
        try {
            $canDelete = 0;

            if ($canDelete > 0) {
                $json   = [
                    'msg'       => 'Data tidak dapat dihapus',
                    'status'    => false
                ];
            } else {
                $qna = DB::table('qnas')->where('id', $id)->first();

                if (!$qna) {
                    $json   = [
                        'msg'       => 'Data tidak ditemukan',
                        'status'    => false
                    ];
                } else {
                    

                    DB::transaction(function () use ($id) {
                        DB::table('qnas')->where('id', $id)->delete();
                    });

                    $json = [
                        'msg'       => 'kelas berhasil dihapus',
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
    // NOTE GET /manage/qna/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('qnas')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('qnas');

            return DataTables::of($data)
                
                ->addColumn(
                    'action',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id
                        ];

                        return view('components.buttons.BE.manage.qna', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/qna
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required|unique:qnas,name',
                'detail_pertanyaan'    => 'required',
                'detail_jawaban'    => 'required',
                
            ];

            $messages = [
                'name.required'     => 'Title wajib diisi',
                'name.unique'       => 'Title sudah terdaftar',
                'detail_pertanyaan.required'   => 'Pertanyaan wajib diisi',
                'detail_jawaban.required'   => 'Jawaban wajib diisi',
             
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request) {
                

                

        

                DB::table('qnas')->insert([
                    'created_at'    => date('Y-m-d H:i:s'),
                    'detail_pertanyaan'        => $request->detail_pertanyaan,
                    'detail_jawaban'        => $request->detail_jawaban,
                    'name'          => $request->name
                ]);
            });

            return redirect()->to('/manage/qna')->with([
                'success' => 'Qna berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') {return dd($e);} 
            else {
                return dd($e);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
    // NOTE POST /manage/qna/{id}
    public function update(Request $request, $id)
    {
        try {
            $qna = DB::table('qnas')->where('id', $id)->first();

            if (!$qna) return abort(404);

            $rules = [
              
                'name'     => 'required',
                'detail_pertanyaan'    => 'required',
                'detail_jawaban'    => 'required',
            ];

            $messages = [
                
                'name.unique'       => 'Title sudah terdaftar',
                'name.required'    => 'Title wajib diisi',
                'detail_pertanyaan.required'   => 'Pertanyaan wajib diisi',
                'detail_jawaban.required'   => 'Jawaban wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request, $id, $qna) {
                 
                    DB::table('qnas')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail_pertanyaan'        => $request->detail_pertanyaan,
                        'detail_jawaban'        => $request->detail_jawaban,
                        'name'          => $request->name
                       
                    ]);
                
            });

            return redirect()->to('/manage/qna')->with([
                'success' => 'Qna berhasil diperbaharui'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') {return dd($e);}
            else {
                return dd($e);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
}
