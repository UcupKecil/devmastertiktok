<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class FormController extends Controller
{
    // NOTE GET /manage/course/create
    public function courseCreateForm()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.form.manage.course.create';

            $data = [
                'backUrl'   => url('/manage/course'),
                'js'        => $js,
                'setting'    => $setting,
                'title'     => 'Tambah Course',
            ];

            return view('pages.BE.admin.form.manage.course.create', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/create
    public function benefitCreateForm()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.form.manage.benefit.create';

            $data = [
                'backUrl'   => url('/manage/benefit'),
                'js'        => $js,
                'setting'    => $setting,
                'title'     => 'Tambah Benefit',
            ];

            return view('pages.BE.admin.form.manage.benefit.create', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/qna/create
    public function qnaCreateForm()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.form.manage.qna.create';

            $data = [
                'backUrl'   => url('/manage/qna'),
                'js'        => $js,
                'setting'    => $setting,
                'title'     => 'Tambah Qna',
            ];

            return view('pages.BE.admin.form.manage.qna.create', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/create
    public function testistudentCreateForm()
    {
        $setting =  Setting::find(1);
        try {
            $js = 'components.scripts.BE.admin.form.manage.testi_student.create';

            $data = [
                'backUrl'   => url('/manage/testi_student'),
                'js'        => $js,
                'setting'    => $setting,
                'title'     => 'Tambah Benefit',
            ];

            return view('pages.BE.admin.form.manage.testi_student.create', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/edit/{id}
    public function courseEditForm($id)
    {
        try {
            $course = DB::table('courses')->where('id', $id)->first();
            $setting =  Setting::find(1);

            if (!$course) return abort(404);

            $js = 'components.scripts.BE.admin.form.manage.course.edit';

            $data = [
                'backUrl'   => url('/manage/course'),
                'course'    => $course,
                'setting'    => $setting,
                'id'        => $id,
                'js'        => $js,
                'title'     => 'Edit Course',
            ];

            return view('pages.BE.admin.form.manage.course.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/edit/{id}
    public function benefitEditForm($id)
    {
        try {
            $benefit = DB::table('benefits')->where('id', $id)->first();
            $setting =  Setting::find(1);

            if (!$benefit) return abort(404);

            $js = 'components.scripts.BE.admin.form.manage.benefit.edit';

            $data = [
                'backUrl'   => url('/manage/benefit'),
                'benefit'    => $benefit,
                'setting'    => $setting,
                'id'        => $id,
                'js'        => $js,
                'title'     => 'Edit Course',
            ];

            return view('pages.BE.admin.form.manage.benefit.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/qna/edit/{id}
    public function qnaEditForm($id)
    {
        try {
            $qna = DB::table('qnas')->where('id', $id)->first();
            $setting =  Setting::find(1);

            if (!$qna) return abort(404);

            $js = 'components.scripts.BE.admin.form.manage.qna.edit';

            $data = [
                'backUrl'   => url('/manage/qna'),
                'qna'    => $qna,
                'setting'    => $setting,
                'id'        => $id,
                'js'        => $js,
                'title'     => 'Edit Course',
            ];

            return view('pages.BE.admin.form.manage.qna.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/testi_student/edit/{id}
    public function testistudentEditForm($id)
    {
        try {
            $testi_student = DB::table('testi_students')->where('id', $id)->first();
            $setting =  Setting::find(1);

            if (!$testi_student) return abort(404);

            $js = 'components.scripts.BE.admin.form.manage.testi_student.edit';

            $data = [
                'backUrl'   => url('/manage/benefit'),
                'testi_student'    => $testi_student,
                'setting'    => $setting,
                'id'        => $id,
                'js'        => $js,
                'title'     => 'Edit Testi Student',
            ];

            return view('pages.BE.admin.form.manage.testi_student.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/create-video/{slug}
    public function courseVideoCreateForm($slug)
    {
        try {
            $course = DB::table('courses')->where('slug', $slug)->first();
            $setting =  Setting::find(1);
           

            if (!$course) return abort(404);
            $sections = DB::table('course_sections')->where('course_id', $course->id)->orderBy('order', 'asc')->get();

            $js = 'components.scripts.BE.admin.form.manage.course_video.create';

            $data = [
                'backUrl'   => url('/manage/course/videos/' . $slug),
                'course'    => $course->name,
                'js'        => $js,
                'slug'      => $slug,
                'setting'    => $setting,
                'sections'  => $sections,
                'title'     => 'Tambah Materi Kelas',
            ];

            return view('pages.BE.admin.form.manage.course_video.create', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
    // NOTE GET /manage/course/edit-video/{id}
    public function courseVideoEditForm($id)
    {
        try {
            $row = DB::table('course_videos')->where('id', $id)->first();
            $setting =  Setting::find(1);

            if (!$row) return abort(404);

            $course = DB::table('courses')->where('id', $row->course_id)->first();
            $sections = DB::table('course_sections')->where('course_id', $course->id)->orderBy('order', 'asc')->get();

            $js = 'components.scripts.BE.admin.form.manage.course_video.create';

            $data = [
                'backUrl'   => url('/manage/course/videos/' . $course->slug),
                'course'    => $course->name,
                'id'        => $id,
                'js'        => $js,
                'row'       => $row,
                'slug'      => $course->slug,
                'sections'  => $sections,
                'setting'    => $setting,
                'title'     => 'Edit Materi Kelas',
            ];

            return view('pages.BE.admin.form.manage.course_video.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }

    // NOTE GET /manage/setting/edit/{id}
    public function settingEditForm($id)
    {
        try {
            $setting = DB::table('settings')->where('id', $id)->first();

            if (!$setting) return abort(404);

            $js = 'components.scripts.BE.admin.form.manage.setting.edit';

            $data = [
                'backUrl'   => url('/manage/setting'),
                'setting'    => $setting,
                'id'        => $id,
                'js'        => $js,
                'title'     => 'Edit Setting',
            ];

            return view('pages.BE.admin.form.manage.setting.edit', $data);
        } catch (Exception $e) {
            if (env(APP_ENV) == 'local') return dd($e);

            return abort(500);
        }
    }
}
