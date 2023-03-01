<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class BenefitController extends Controller
{
    // NOTE GET /manage/benefit
    public function index()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.manage.benefit';

            $data = [
                'formUrl'   => url('/manage/benefit/create'),
                'js'        => $js,
                'title'     => 'Benefit',
                'setting'    => $setting,
            ];

            return view('pages.BE.admin.manage.benefit', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /manage/benefit/{id}
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
                $benefit = DB::table('benefits')->where('id', $id)->first();

                if (!$benefit) {
                    $json   = [
                        'msg'       => 'Data tidak ditemukan',
                        'status'    => false
                    ];
                } else {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/benefits/' . $benefit->image);
                    } else {
                        $pleaseRemove = '/home/masterti/public_html/assets/images/benefits/' . $benefit->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/benefits/' . $benefit->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    DB::transaction(function () use ($id) {
                        DB::table('benefits')->where('id', $id)->delete();
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
    // NOTE GET /manage/benefit/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('benefits')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('benefits');

            return DataTables::of($data)
                ->editColumn(
                    'image',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'path'  => asset('/assets/images/benefits/' . $row->image),
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

                        return view('components.buttons.BE.manage.benefit', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/benefit
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required|unique:benefits,name',
                'detail'    => 'required',
                'image'     => 'required',
            ];

            $messages = [
                'name.required'     => 'Title wajib diisi',
                'name.unique'       => 'Title sudah terdaftar',
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
                    $destination        = base_path('public/assets/images/benefits');
                } else {
                    $destination        = '/home/masterti/public_html/assets/images/benefits';
                    //$destination        = getDevelopmentPublicPath() . '/assets/images/benefits';
                }

                $request->file('image')->move($destination, $image);

                DB::table('benefits')->insert([
                    'created_at'    => date('Y-m-d H:i:s'),
                    'detail'        => $request->detail,
                    'image'         => $image,
                    'name'          => $request->name
                ]);
            });

            return redirect()->to('/manage/benefit')->with([
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
    // NOTE POST /manage/benefit/{id}
    public function update(Request $request, $id)
    {
        try {
            $benefit = DB::table('benefits')->where('id', $id)->first();

            if (!$benefit) return abort(404);

            $rules = [
              
                'name'     => 'required',
                'detail'    => 'required',
            ];

            $messages = [
                
                'name.unique'       => 'Title sudah terdaftar',
                'name.required'    => 'Title wajib diisi',
                'detail.required'   => 'Keterangan wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request, $id, $benefit) {
                if ($request->file('image')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/benefits/' . $benefit->image);
                    } else {
                        $pleaseRemove = '/home/masterti/public_html/assets/images/benefits/' . $benefit->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/benefits/' . $benefit->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();

                    $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/benefits');
                    } else {
                        $destination        = '/home/masterti/public_html/assets/images/benefits';
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/benefits';
                    }

                    $request->file('image')->move($destination, $image);

                    DB::table('benefits')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'image'         => $image,
                        'name'        => $request->name
                    ]);
                } else {
                    DB::table('benefits')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'name'          => $request->name
                       
                    ]);
                }
            });

            return redirect()->to('/manage/benefit')->with([
                'success' => 'Benefit berhasil diperbaharui'
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
