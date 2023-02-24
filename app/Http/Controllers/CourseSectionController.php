<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class CourseSectionController extends Controller
{
    // NOTE GET /manage/course/sections/{slug}
    public function index($slug)
    {
        try {
            $setting =  Setting::find(1);
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) return abort(404);

            $js = 'components.scripts.BE.admin.manage.course_section';

            $data = [
                'course'    => $course->name,
                'js'        => $js,
                'slug'      => $slug,
                'setting'    => $setting,
                'title'     => 'Section',
            ];

            return view('pages.BE.admin.manage.course_section', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE DELETE /manage/course/sections/{slug}/{id}
    public function destroy($slug, $id)
    {
        try {

            $course = DB::table('courses')->where('slug', $slug)->first();

            $oldData = DB::table('course_sections')->where('id', $id)->first();

            $canDelete = DB::table('course_videos')->where('section_id', $id)->count();

            if ($canDelete > 0) {
                $json   = [
                    'msg'       => 'Data tidak dapat dihapus',
                    'status'    => false
                ];
            } elseif (!$course) {
                $json   = [
                    'msg'       => 'Data tidak ditemukan',
                    'status'    => false
                ];
            } elseif ($oldData->course_id !== $course->id) {
                $json   = [
                    'msg'       => 'Data tidak ditemukan',
                    'status'    => false
                ];
            } elseif (!$course) {
                $json   = [
                    'msg'       => 'Data tidak ditemukan',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($id, $course) {
                    DB::table('course_sections')->where('id', $id)->delete();

                    $query = DB::table('course_sections')->where('course_id', $course->id)->orderBy('order', 'asc')->get();

                    for ($i = 0; $i < count($query); $i++) {
                        DB::table('course_sections')->where('id', $query[$i]->id)->update([
                            'order' => ($i + 1)
                        ]);
                    }
                });

                $json = [
                    'msg'       => 'materi berhasil dihapus',
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
    // NOTE GET /manage/course/sections/{slug}/{any}
    public function show($slug, $any)
    {
        try {
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (is_numeric($any)) {
                $data = DB::table('course_sections')->where('id', $any)->first();

                $data->orderTotal = DB::table('course_sections')
                    ->where('course_id', $course->id)
                    ->count();

                return response()->json($data);
            }

            $data = DB::table('course_sections')
                ->where('course_id', $course->id)
                ->orderBy('order', 'asc');

            return DataTables::of($data)
                ->addColumn(
                    'action',
                    function ($row) use ($slug) {
                        $data   = [
                            'id'    => $row->id
                        ];

                        return view('components.buttons.BE.manage.course_section', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/course/sections/{slug}
    public function store($slug, Request $request)
    {
        try {
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) {
                return response()->json([
                    'msg'       => 'Kelas tidak terdaftar',
                    'status'    => false
                ]);
            }

            $sectionisRegistered = DB::table('course_sections')
                ->where('course_id', $course->id)
                ->where('name', $request->name)
                ->first();

            if ($request->name == null) {
                $json   = [
                    'msg'       => 'Mohon isi nama section',
                    'status'    => false
                ];
            } elseif ($sectionisRegistered) {
                $json   = [
                    'msg'       => 'Section sudah terdaftar',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($request, $course) {
                    $order = DB::table('course_sections')
                        ->where('course_id', $course->id)
                        ->count();

                    DB::table('course_sections')->insert([
                        'course_id'     => $course->id,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'name'          => $request->name,
                        'order'         => ($order + 1)
                    ]);
                });

                $json = [
                    'msg'       => 'section berhasil ditambahkan',
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
    // NOTE POST /manage/course/sections/{slug}/{id}
    public function update($slug, $id, Request $request)
    {
        try {
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) {
                return response()->json([
                    'msg'       => 'Kelas tidak terdaftar',
                    'status'    => false
                ]);
            }

            $sectionisRegistered = DB::table('course_sections')
                ->where('course_id', $course->id)
                ->where('id', '<>', $id)
                ->where('name', $request->name)
                ->first();

            if ($request->name == null) {
                $json   = [
                    'msg'       => 'Mohon isi nama section',
                    'status'    => false
                ];
            } elseif ($request->order == null) {
                $json   = [
                    'msg'       => 'Mohon isi urutan',
                    'status'    => false
                ];
            } elseif ($sectionisRegistered) {
                $json   = [
                    'msg'       => 'Section sudah terdaftar',
                    'status'    => false
                ];
            } else {
                DB::transaction(function () use ($request, $id) {
                    $oldData = DB::table('course_sections')
                        ->where('id', $id)
                        ->first();

                    DB::table('course_sections')->where('id', $id)->update([
                        'name'          => $request->name,
                        'order'         => $request->order,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);

                    if ($request->order < $oldData->order) {
                        $adjustOrderOldStatus = DB::table('course_sections')
                            ->where('id', '<>', $id)
                            ->where('order', '<', $oldData->order)
                            ->orderBy('order', 'ASC')
                            ->get();

                        if ($adjustOrderOldStatus) {
                            foreach ($adjustOrderOldStatus as $row) {
                                DB::table('course_sections')->where('id', $row->id)->update([
                                    'order' => ($row->order + 1)
                                ]);
                            }

                            $prev = DB::table('course_sections')
                                ->where('id', '<>', $id)
                                ->where('order', $request->order)
                                ->first();

                            if ($prev) {
                                DB::table('course_sections')
                                    ->where('id', '<>', $id)
                                    ->where('order', $request->order)
                                    ->update([
                                        'order' => ($prev->order - 1)
                                    ]);
                            }
                        }
                    } else {
                        $adjustOrderOldStatus = DB::table('course_sections')
                            ->where('id', '<>', $id)
                            ->where('order', '>', $oldData->order)
                            ->orderBy('order', 'ASC')
                            ->get();

                        if ($adjustOrderOldStatus) {
                            foreach ($adjustOrderOldStatus as $row) {
                                DB::table('course_sections')->where('id', $row->id)->update([
                                    'order' => ($row->order - 1)
                                ]);
                            }

                            $prev = DB::table('course_sections')
                                ->where('id', '<>', $id)
                                ->where('order', $request->order)
                                ->first();

                            if ($prev) {
                                DB::table('course_sections')
                                    ->where('id', '<>', $id)
                                    ->where('order', $request->order)
                                    ->update([
                                        'order' => ($prev->order + 1)
                                    ]);
                            }
                        }
                    }
                });

                $json = [
                    'msg'       => 'section berhasil diperbarui',
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
