<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Setting;

class ReferralDetailController extends Controller
{
    // NOTE GET /manage/course/videos/{slug}
    public function index($id)
    {
        try {
            $setting =  Setting::find(1);
            $point_transaction = DB::table('point_transactions')->where('user_id', $id)->first();

            if (!$point_transaction) return abort(404);

            $js = 'components.scripts.BE.admin.manage.referral_detail';
            

            $data = [
                'point_transaction'    => $point_transaction->user_id,
                'formUrl'   => url('/manage/referral/create-detail/' . $id),
                'js'        => $js,
                'id'      => $id,
                'setting'    => $setting,
                'title'     => 'Detail Referral',
            ];

            return view('pages.BE.admin.manage.referral_detail', $data);
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

        $data = DB::table('referral_details')->where('id', $id)->first();

        return response()->json($data);
    }
    // NOTE DELETE /manage/course/videos/{slug}/{id}
    public function destroy($slug, $id)
    {
        try {
            $canDelete = 0;

            $course = DB::table('courses')->where('slug', $slug)->first();

            $oldData = DB::table('referral_details')->where('id', $id)->first();

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
                }

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }

                if (env('APP_ENV') == 'local') {
                    $pleaseRemove = base_path('public/assets/videos/courses/' . $course->id . '/' . $oldData->video);
                } else {
                    $pleaseRemove = '/home/masterti/public_html/assets/videos/courses/' . $course->id . '/' . $oldData->video;
                }

                if (file_exists($pleaseRemove)) {
                    unlink($pleaseRemove);
                }

                DB::transaction(function () use ($id, $course) {
                    DB::table('referral_details')->where('id', $id)->delete();

                    $videos = DB::table('referral_details')->where('course_id', $course->id)->get();

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
    public function show($id, $any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('referral_details')->where('id', $any)->first();

                return response()->json($data);
            }

            $point_transaction = DB::table('point_transactions')->where('user_id', $id)->first();

            $data = DB::table('point_transaction')
                ->join('course_sections', 'course_sections.id', '=', 'referral_details.section_id')
                ->select([
                    'referral_details.*', 'course_sections.name as section'
                ])
                ->where('referral_details.course_id', $course->id);

            return DataTables::of($data)
                ->addColumn(
                    'action',
                    function ($row) use ($slug) {
                        $data   = [
                            'slug'  => $slug,
                            'id'    => $row->id
                        ];

                        return view('components.buttons.BE.manage.referral_detail', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
   
    
}
