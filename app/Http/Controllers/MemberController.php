<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    public function setAffiliate($uid)
    {
        Session::flush();

        $valid = DB::table('user_details')->where('uid', $uid)->first();

        if ($valid) Session::put('referral', $uid);

        $course = DB::table('courses')->first();

        if ($course) {
            $data = [
                'slug' => $course->slug
            ];

            return view('pages.FE.ref', $data);
        }

        return redirect()->to('/');
    }
}
