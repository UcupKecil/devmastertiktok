<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    // NOTE GET /manage/profile
    public function index()
    {
        $setting =  Setting::find(1);
        $bank = DB::table('banks')->orderBy('name', 'ASC')->get();
        $user = Auth::user();
        $userDetail = Auth::user()->detail;
      
      
        try {
            $js = 'components.scripts.BE.member.profile';

            $data = [
                'js'                    => $js,
                'title'                 => 'Profil',
                'currentUser'           => $user,
                'detailUser'           => $userDetail,
                'setting'    => $setting,
                'bank'    => $bank,
            ];

            return view('pages.BE.member.profile', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    
    public function show($id)
    {
        // SECTION ambil data tunggal
        // SECTION query
        $data   = DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->select([
                'users.name', 'users.email', 'users.username',
                'user_details.*',
            ])
            ->where('users.id', $id)
            ->first();
        // !SECTION query
        
        // !SECTION okupasi
        // NOTE kembalian
        return Response::json($data);
        // !SECTION ambil data tunggal
    }

    // NOTE GET /manage/profile/{any}
    // public function show($any)
    // {
    //     try {
    //         if (is_numeric($any)) {
    //             $data = DB::table('profiles')->where('id', $any)->first();

    //             return response()->json($data);
    //         }

    //         $data = DB::table('profiles');

    //         return DataTables::of($data)
    //             ->editColumn(
    //                 'image',
    //                 function ($row) {
    //                     $data   = [
    //                         'id'    => $row->id,
    //                         'path'  => asset('/assets/images/profiles/' . $row->image),
    //                         'name'  => $row->name
    //                     ];

    //                     return view('components.anchor.lightbox', $data);
    //                 }
    //             )
    //             ->addColumn(
    //                 'action',
    //                 function ($row) {
    //                     $data   = [
    //                         'id'    => $row->id,
    //                         'slug'  => $row->slug
    //                     ];

    //                     return view('components.buttons.BE.manage.profile', $data);
    //                 }
    //             )
    //             ->addIndexColumn()
    //             ->make(true);
    //     } catch (Exception $e) {
    //         if (env('APP_ENV') == 'local') return dd($e);

    //         return abort(500);
    //     }
    // }

    // SECTION update data
    /* -------------------------------------------------------------------------- */
    /*                                 UPDATE DATA                                */
    /* -------------------------------------------------------------------------- */
    // POST master-data/relawan/{}
    public function updateData(Request $request)
    {
        if ($request->name == null) {
            $json   = [
                'msg'       => 'Mohon masukan nama terlebih dahulu.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        $currentUser = Auth::user();
        $checkUser = DB::table('users')->where('id', $currentUser->id)->first();

        if (!$checkUser) {
            $json   = [
                'msg'       => 'Pengguna tidak ditemukan.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

         
            

           

            
        

        DB::table('users')->where('id', $currentUser->id)->update([
            'name'      => $request->name,
            
        ]);

        DB::table('user_details')->where('user_id', $currentUser->id)->update([
            'phone'      => $request->phone,
            'account_number'      => $request->account_number,
            'bank_id'      => $request->bank_id,
            
        ]);

        // NOTE kembalian
        return Response::json([
            'msg'       => 'Data Pengguna berhasil disunting',
            'status'    => true,
            'data'      => [
                'name' => $request->name,
            ],
        ]);
    }
    
    // POST master-data/relawan/{}
    public function updatePassword(Request $request)
    {

        if (strlen($request->password) < 8) {
            $json   = [
                'msg'       => 'Kata sandi minimal 8 angka.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        if ($request->old_password == null) {
            $json   = [
                'msg'       => 'Mohon masukan Kata sandi lama terlebih dahulu.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        if ($request->password == null) {
            $json   = [
                'msg'       => 'Mohon masukan Kata sandi terlebih dahulu.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        if ($request->new_password == null) {
            $json   = [
                'msg'       => 'Mohon masukan Kata sandi baru terlebih dahulu.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        if ($request->password != $request->new_password) {
            $json   = [
                'msg'       => 'Konfirmasi kata sandi tidak cocok dengan kata sandi.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        $currentUser = Auth::user();
        $checkUser = DB::table('users')->where('id', $currentUser->id)->first();

        if (!$checkUser) {
            $json   = [
                'msg'       => 'Pengguna tidak ditemukan.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        if (!Hash::check($request->old_password, $checkUser->password)) {
            $json   = [
                'msg'       => 'Kata sandi lama tidak sesuai.',
                'status'    => false,
                'data'      => [],
            ];

            return Response::json($json);
        }

        $newPassoword = Hash::make($request->password);
        DB::table('users')->where('id', $currentUser->id)->update([
            'password' => $newPassoword,
        ]);

        

        // NOTE kembalian
        return Response::json([
            'msg'       => 'Kata sandi berhasil diubah.',
            'status'    => true,
            'data'      => [],
        ]);
    }
    // !SECTION update Password
}
