<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    // NOTE GET /manage/course
    public function index()
    {
        try {
            $js = 'components.scripts.BE.admin.manage.course';

            $data = [
                'formUrl'   => url('/manage/course/create'),
                'js'        => $js,
                'title'     => 'Course',
            ];

            return view('pages.BE.admin.manage.course', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /manage/course/{id}
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
                $course = DB::table('courses')->where('id', $id)->first();

                if (!$course) {
                    $json   = [
                        'msg'       => 'Data tidak ditemukan',
                        'status'    => false
                    ];
                } else {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/courses/' . $course->image);
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/courses/' . $course->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/courses/' . $course->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    DB::transaction(function () use ($id) {
                        DB::table('courses')->where('id', $id)->delete();
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
    // NOTE GET /manage/course/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('courses')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('courses');

            return DataTables::of($data)
                ->editColumn(
                    'image',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'path'  => asset('/assets/images/courses/' . $row->image),
                            'name'  => $row->name
                        ];

                        return view('components.anchor.lightbox', $data);
                    }
                )
                ->addColumn(
                    'action',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'slug'  => $row->slug
                        ];

                        return view('components.buttons.BE.manage.course', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/course
    public function store(Request $request)
    {
        try {
            $rules = [
                'name'      => 'required|unique:courses,name',
                'price'     => 'required',
                'detail'    => 'required',
                'image'     => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama kelas wajib diisi',
                'name.unique'       => 'Nama kelas sudah terdaftar',
                'price.required'    => 'Harga kelas wajib diisi',
                'detail.required'   => 'Keterangan kelas wajib diisi',
                'image.required'    => 'Gambar kelas wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request) {
                $extension = $request->file('image')->getClientOriginalExtension();

                $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                if (env('APP_ENV') == 'local') {
                    $destination        = base_path('public/assets/images/courses');
                } else {
                    $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/courses';
                    //$destination        = getDevelopmentPublicPath() . '/assets/images/courses';
                }

                $request->file('image')->move($destination, $image);

                DB::table('courses')->insert([
                    'created_at'    => date('Y-m-d H:i:s'),
                    'crossed_price' => $request->crossed_price ? str_replace(',', '', $request->crossed_price) : 0,
                    'detail'        => $request->detail,
                    'image'         => $image,
                    'name'          => $request->name,
                    'price'         => str_replace(',', '', $request->price),
                    'slug'          => Str::slug($request->name)
                ]);
            });

            return redirect()->to('/manage/course')->with([
                'success' => 'Kelas berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
    // NOTE POST /manage/course/{id}
    public function update(Request $request, $id)
    {
        try {
            $course = DB::table('courses')->where('id', $id)->first();

            if (!$course) return abort(404);

            $rules = [
                'name'      => 'required|unique:courses,name,' . $id,
                'price'     => 'required',
                'detail'    => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama kelas wajib diisi',
                'name.unique'       => 'Nama kelas sudah terdaftar',
                'price.required'    => 'Harga kelas wajib diisi',
                'detail.required'   => 'Keterangan kelas wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request, $id, $course) {
                if ($request->file('image')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/courses/' . $course->image);
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/courses/' . $course->image;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/courses/' . $course->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('image')->getClientOriginalExtension();

                    $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/courses');
                    } else {
                        $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/courses';
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/courses';
                    }

                    $request->file('image')->move($destination, $image);

                    DB::table('courses')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'image'         => $image,
                        'name'          => $request->name,
                        'price'         => str_replace(',', '', $request->price),
                        'crossed_price' => $request->crossed_price ? str_replace(',', '', $request->crossed_price) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                } else {
                    DB::table('courses')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'name'          => $request->name,
                        'price'         => str_replace(',', '', $request->price),
                        'crossed_price' => $request->crossed_price ? str_replace(',', '', $request->crossed_price) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                }
            });

            return redirect()->to('/manage/course')->with([
                'success' => 'Kelas berhasil diperbaharui'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
}
