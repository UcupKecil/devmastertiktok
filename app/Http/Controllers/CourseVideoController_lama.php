<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class CourseVideoController extends Controller
{
    // NOTE GET /manage/course/videos/{slug}
    public function index($slug)
    {
        $setting =  Setting::find(1);
        try {
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) return abort(404);

            $js = 'components.scripts.BE.admin.manage.course_video';

            $data = [
                'course'    => $course->name,
                'formUrl'   => url('/manage/course/create-video/' . $slug),
                'js'        => $js,
                'slug'      => $slug,
                'setting'    => $setting,
                'title'     => 'Materi',
            ];

            return view('pages.BE.admin.manage.course_video', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /mycourse/change-video/{class_id}/{id}
    public function changeVideo($class_id, $id)
    {
        DB::table('course_students')->where('id', $class_id)->update([
            'last_video' => $id
        ]);

        $data = DB::table('course_videos')->where('id', $id)->first();

        return response()->json($data);
    }
    // NOTE DELETE /manage/course/videos/{slug}/{id}
    public function destroy($slug, $id)
    {
        try {
            $canDelete = 0;

            $course = DB::table('courses')->where('slug', $slug)->first();

            $oldData = DB::table('course_videos')->where('id', $id)->first();

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
                if (env('APP_ENV') == 'local') {
                    $pleaseRemove = base_path('public/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster);
                } else {
                    $pleaseRemove = '/home/masterti/public_html/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster;
                    //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster;
                }

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }

                if (env('APP_ENV') == 'local') {
                    $pleaseRemove = base_path('public/assets/videos/courses/' . $course->id . '/' . $oldData->video);
                } else {
                    $pleaseRemove = '/home/masterti/public_html/assets/videos/courses/' . $course->id . '/' . $oldData->video;
                    //$pleaseRemove = getDevelopmentPublicPath() . '/assets/videos/courses/' . $course->id . '/' . $oldData->video;
                }

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }

                DB::transaction(function () use ($id, $course) {
                    DB::table('course_videos')->where('id', $id)->delete();

                    $videos = DB::table('course_videos')->where('course_id', $course->id)->get();

                    $duration = 0;

                    if (count($videos) > 0) {
                        foreach ($videos as $row) {
                            $duration += intval($row->seconds);
                        }
                    }

                    DB::table('courses')->where('id', $course->id)->update([
                        'duration'      => $duration,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);
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
    // NOTE GET /manage/course/videos/{slug}/{any}
    public function show($slug, $any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('course_videos')->where('id', $any)->first();

                return response()->json($data);
            }

            $course = DB::table('courses')->where('slug', $slug)->first();

            $data = DB::table('course_videos')->where('course_id', $course->id);

            return DataTables::of($data)
                ->addColumn(
                    'action',
                    function ($row) use ($slug) {
                        $data   = [
                            'slug'  => $slug,
                            'id'    => $row->id
                        ];

                        return view('components.buttons.BE.manage.course_video', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE POST /manage/course/videos/{slug}
    public function store(Request $request, $slug)
    {
        ini_set('max_execution_time', -1);

        try {
            
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) return abort(404);

            $rules = [
                'name'      => 'required',
                'detail'    => 'required',
                'video'     => 'required',
                'poster'     => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama materi wajib diisi',
                'detail.required'   => 'Keterangan materi wajib diisi',
                'video.required'    => 'Video materi wajib diisi',
                'poster.required'   => 'Gambar materi wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            $validExtension = [
                'mp4', 'mkv', '3gp'
            ];

            $extension  = $request->file('video')->getClientOriginalExtension();

            if (!in_array($extension, $validExtension)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Extensi file video tidak valid']);
            }

            DB::transaction(function () use ($course, $request) {
                $extension = $request->file('poster')->getClientOriginalExtension();

                $poster  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                if (env('APP_ENV') == 'local') {
                    $destination        = base_path('public/assets/images/courses/video/poster/' . $course->id);
                } else {
                    $destination        = '/home/masterti/public_html/assets/images/courses/video/poster/' . $course->id;
                    //$destination        = getDevelopmentPublicPath() . '/assets/images/courses/video/poster/' . $course->id;
                }

                $request->file('poster')->move($destination, $poster);

                $extension = $request->file('video')->getClientOriginalExtension();

                $video  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                if (env('APP_ENV') == 'local') {
                    $destination        = base_path('public/assets/videos/courses/' . $course->id);
                } else {
                    $destination        = '/home/masterti/public_html/assets/videos/courses/' . $course->id;
                    //$destination        = getDevelopmentPublicPath() . '/assets/videos/courses/' . $course->id;
                }

                $request->file('video')->move($destination, $video);

                $hours = floor($request->seconds / 3600);
                $minutes = floor(($request->seconds / 60) % 60);
                $seconds = $request->seconds % 60;

                if ($hours == 0) {
                    $duration = "$minutes:$seconds";
                } else {
                    $duration = "$hours:$minutes:$seconds";

                    if (strlen($hours) == 0) {
                        $duration = "0" . $hours . ':' . $minutes . ':' . $seconds;
                    }
                }

                DB::table('course_videos')->insert([
                    'course_id'     => $course->id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'detail'        => $request->detail,
                    'duration'      => $duration,
                    'name'          => $request->name,
                    'poster'        => $poster,
                    'seconds'       => $request->seconds,
                    'video'         => $video,
                ]);

                $videos = DB::table('course_videos')->where('course_id', $course->id)->get();

                $duration = 0;

                foreach ($videos as $row) {
                    $duration += intval($row->seconds);
                }

                DB::table('courses')->where('id', $course->id)->update([
                    'duration'      => $duration,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            });

            return redirect()->to('/manage/course/videos/' . $slug)->with([
                'success' => 'Materi kelas berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local'){return dd($e);} 
            else {
                return dd($e);
            }


            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
    // NOTE POST /manage/course/videos/{slug}
    public function update(Request $request, $slug, $id)
    {
        ini_set('max_execution_time', -1);

        try {
            $course = DB::table('courses')->where('slug', $slug)->first();

            if (!$course) return abort(404);

            $oldData = DB::table('course_videos')->where('id', $id)->first();

            if (!$oldData) return abort(404);

            if ($oldData->course_id !== $course->id) return abort(400);

            $rules = [
                'name'      => 'required',
                'detail'    => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama materi wajib diisi',
                'detail.required'   => 'Keterangan materi wajib diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->file('video')) {
                $validExtension = [
                    'mp4', 'mkv', '3gp'
                ];

                $extension  = $request->file('video')->getClientOriginalExtension();

                if (!in_array($extension, $validExtension)) {
                    return redirect()->back()->withInput()->withErrors(['error' => 'Extensi file video tidak valid']);
                }
            }

            DB::transaction(function () use ($course, $oldData, $request, $id) {
                if ($request->file('poster')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster);
                    } else {
                        $pleaseRemove = '/home/masterti/public_html/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/courses/video/poster/' . $course->id . '/' . $oldData->poster;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('poster')->getClientOriginalExtension();

                    $poster  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/courses/video/poster/' . $course->id);
                    } else {
                        $destination        = '/home/masterti/public_html/assets/images/courses/video/poster/' . $course->id;
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/courses/video/poster/' . $course->id;
                    }

                    $request->file('poster')->move($destination, $poster);

                    DB::table('course_videos')->where('id', $id)->update([
                        'poster'    => $poster
                    ]);
                }

                if ($request->file('video')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/videos/courses/' . $course->id . '/' . $oldData->video);
                    } else {
                        $pleaseRemove = '/home/masterti/public_html/assets/videos/courses/' . $course->id . '/' . $oldData->video;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/videos/courses/' . $course->id . '/' . $oldData->video;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    $extension = $request->file('video')->getClientOriginalExtension();

                    $video  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/videos/courses/' . $course->id);
                    } else {
                        $path = '/home/mvlrzxvo/subdomain/api.tepat.co.id/photo-paymentmethod/';
                        $destination        = '/home/masterti/public_html/assets/videos/courses/' . $course->id;
                        //$destination        = getDevelopmentPublicPath() . '/assets/videos/courses/' . $course->id;
                    }

                    $request->file('video')->move($destination, $video);

                    DB::table('course_videos')->where('id', $id)->update([
                        'video'    => $video
                    ]);
                }

                $hours = floor($request->seconds / 3600);
                $minutes = floor(($request->seconds / 60) % 60);
                $seconds = $request->seconds % 60;

                if ($hours == 0) {
                    $duration = "$minutes:$seconds";
                } else {
                    $duration = "$hours:$minutes:$seconds";

                    if (strlen($hours) == 0) {
                        $duration = "0" . $hours . ':' . $minutes . ':' . $seconds;
                    }
                }

                DB::table('course_videos')->where('id', $id)->update([
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'detail'        => $request->detail,
                    'duration'      => $duration,
                    'name'          => $request->name,
                    'seconds'       => $request->seconds,
                ]);

                $videos = DB::table('course_videos')->where('course_id', $course->id)->get();

                $duration = 0;

                foreach ($videos as $row) {
                    $duration += intval($row->seconds);
                }

                DB::table('courses')->where('id', $course->id)->update([
                    'duration'      => $duration,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            });

            return redirect()->to('/manage/course/videos/' . $slug)->with([
                'success' => 'Materi kelas berhasil diperbaharui'
            ]);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local'){return dd($e);} 
            else {
                return dd($e);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan teknis']);
        }
    }
}
