<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class TestiStudentController extends Controller
{
    // NOTE GET /manage/testi_student
    public function index()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.manage.testi_student';

            $data = [
                'formUrl'   => url('/manage/testi_student/create'),
                'js'        => $js,
                'title'     => 'Testimoni Siswa',
                'setting'    => $setting,
            ];

            return view('pages.BE.admin.manage.testi_student', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /manage/testi_student/{id}
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
                $testi_student = DB::table('testi_students')->where('id', $id)->first();

                if (!$testi_student) {
                    $json   = [
                        'msg'       => 'Data tidak ditemukan',
                        'status'    => false
                    ];
                } else {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/testi_students/' . $testi_student->image);
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/testi_students/' . $testi_student->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/testi_students/' . $testi_student->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    DB::transaction(function () use ($id) {
                        DB::table('testi_students')->where('id', $id)->delete();
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
    // NOTE GET /manage/testi_student/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('testi_students')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('testi_students');

            return DataTables::of($data)
                ->editColumn(
                    'image',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'path'  => asset('/assets/images/testi_students/' . $row->image),
                            'name'  => $row->name
                        ];

                        return view('components.anchor.lightbox', $data);
                    }
                )
                ->addColumn(
                    'action',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id
                        ];

                        return view('components.buttons.BE.manage.testi_student', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/testi_student
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required|unique:testi_students,name',
                'detail'    => 'required',
                'pekerjaan'    => 'required',
                'image'     => 'required',
            ];

            $messages = [
                'name.required'     => 'Title wajib diisi',
                'name.unique'       => 'Title sudah terdaftar',
                'pekerjaan.required'     => 'Pekerjaan wajib diisi',
                'detail.required'   => 'Keterangan wajib diisi',
                'image.required'    => 'Gambar wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request) {
                $extension = $request->file('image')->getClientOriginalExtension();

                $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                if (env('APP_ENV') == 'local') {
                    $destination        = base_path('public/assets/images/testi_students');
                } else {
                    $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/testi_students';
                    //$destination        = getDevelopmentPublicPath() . '/assets/images/testi_students';
                }

                $request->file('image')->move($destination, $image);

                DB::table('testi_students')->insert([
                    'created_at'    => date('Y-m-d H:i:s'),
                    'detail'        => $request->detail,
                    'image'         => $image,
                    'name'          => $request->name,
                    'pekerjaan'          => $request->pekerjaan
                ]);
            });

            return redirect()->to('/manage/testi_student')->with([
                'success' => 'Kelas berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') {return dd($e);} 
            else {
                return dd($e);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
    // NOTE POST /manage/testi_student/{id}
    public function update(Request $request, $id)
    {
        try {
            $testi_student = DB::table('testi_students')->where('id', $id)->first();

            if (!$testi_student) return abort(404);

            $rules = [
              
                'name'     => 'required',
                'pekerjaan'     => 'required',
                'detail'    => 'required',
            ];

            $messages = [
                
                'name.unique'       => 'Title sudah terdaftar',
                'name.required'    => 'Title wajib diisi',
                'pekerjaan.required'    => 'Pekerjaan wajib diisi',
                'detail.required'   => 'Keterangan wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request, $id, $testi_student) {
                if ($request->file('image')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/testi_students/' . $testi_student->image);
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/testi_students/' . $testi_student->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/testi_students/' . $testi_student->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();

                    $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/testi_students');
                    } else {
                        $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/testi_students';
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/testi_students';
                    }

                    $request->file('image')->move($destination, $image);

                    DB::table('testi_students')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'image'         => $image,
                        'name'        => $request->name,
                        'pekerjaan'        => $request->pekerjaan
                    ]);
                } else {
                    DB::table('testi_students')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'name'          => $request->name,
                        'pekerjaan'        => $request->pekerjaan
                       
                    ]);
                }
            });

            return redirect()->to('/manage/testi_student')->with([
                'success' => 'Testimoni Siswa berhasil diperbaharui'
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
