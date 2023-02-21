<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;


class StaticPageController extends Controller
{
    // NOTE GET /
    public function index()
    {
        $courses = DB::table('courses')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
        $testi_students = DB::table('testi_students')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
        $testi_alumnus = DB::table('testi_alumnus')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
        $benefits = DB::table('benefits')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
        $qnas = DB::table('qnas')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
        $setting =  Setting::find(1);
            
        $data = [
            'courses'   => $courses,
            'testi_students'   => $testi_students,
            'testi_alumnus'   => $testi_alumnus,
            'benefits'   => $benefits,
            'qnas'   => $qnas,
            'setting'   => $setting,
            'title'     => 'Home'
        ];

        return view('pages.FE.index', $data);
    }
    // NOTE GET /mycourse/{slug}
    public function classroom($slug)
    {
        $course = DB::table('courses')->where('slug', $slug)->first();
        $setting =  Setting::find(1);

        if (!$course) return abort(404);

        $valid = DB::table('course_students')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$valid) return abort(403);

        $videos = DB::table('course_videos')->where('course_id', $course->id)->orderBy('id')->get();

        if (!$valid->last_video) {
            DB::table('course_students')->where('id', $valid->id)->update([
                'last_video' => $videos[0]->id
            ]);
        }

        $valid = DB::table('course_students')
            ->where('user_id', auth()->user()->id)
            ->where('course_id', $course->id)
            ->first();

        $onDisplay = DB::table('course_videos')->where('id', $valid->last_video)->first();

        $data = [
            'course'    => $course,
            'js'        => 'components.scripts.BE.member.course',
            'onDisplay' => $onDisplay,
            'title'     => $course->name,
            'valid'     => $valid,
            'videos'    => $videos,
            'setting'   => $setting,
        ];

        return view('pages.BE.member.course', $data);
    }
    // NOTE GET /course/{slug}
    public function course($slug)
    {
        $course = DB::table('courses')
            ->where('slug', $slug)
            ->first();
        $setting =  Setting::find(1);

        if (!$slug) return abort(404);

        $videos = DB::table('course_videos')
            ->where('course_id', $course->id)
            ->get();

        $data = [
            'course'    => $course,
            'setting'    => $setting,
            'title'     => $course->name,
            'videos'    => $videos,
        ];

        return view('pages.FE.course.single', $data);
    }
    // NOTE GET /dashboard
    public function dashboard()
    {
        $setting =  Setting::find(1);
        $unpaidOrder = DB::table('orders')
            ->join('courses', 'courses.id', '=', 'orders.course_id')
            ->select([
                'orders.*', 'courses.name'
            ])
            ->where('orders.status', '<>', 'paid')
            ->where('orders.user_id', auth()->user()->id)
            ->get();

        $courses = null;

        if (Auth::user()->getRoleNames()[0] == 'Member') {
            $courses = DB::table('course_students')
                ->join('courses', 'courses.id', '=', 'course_students.course_id')
                ->select([
                    'courses.*'
                ])
                ->where('course_students.user_id', auth()->user()->id)
                ->orderBy('course_students.id', 'desc')
                ->get();
        }

        $user = DB::table('user_details')->where('user_id', Auth::user()->id)->first();

        $js = 'components.scripts.BE.' . strtolower(Auth::user()->getRoleNames()[0]) . '.dashboard';

        $data = [
            'courses'       => $courses,
            'js'            => $js,
            'title'         => 'Dashboard',
            'unpaidOrder'   => $unpaidOrder,
            'user'          => $user,
            'setting'    => $setting,
        ];

        return view('pages.BE.' . strtolower(Auth::user()->getRoleNames()[0]) . '.dashboard', $data);
    }
    // NOTE GET /auth/login
    public function login()
    {
        $setting =  Setting::find(1);
        $data = [
            'title' => 'Login',
            'setting'    => $setting,
        ];

        return view('pages.FE.auth.login', $data);
    }
    // NOTE GET /auth/register
    public function register()
    {
        if (!Session::get('course')) return redirect()->back();
        $setting =  Setting::find(1);
        $course = DB::table('courses')->where('id', Session::get('course'))->first();

        if (!$course) return redirect()->back();

        $data = [
            'title'     => 'Register',
            'course'    => $course,
            'setting'    => $setting,
            'js'        => 'components.scripts.FE.auth.register'
        ];

        return view('pages.FE.auth.register', $data);
    }
}
