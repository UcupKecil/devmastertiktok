<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    // NOTE GET /manage/setting
    public function index()
    {
        try {
            $js = 'components.scripts.BE.admin.manage.setting';

            $data = [
                'formUrl'   => url('/manage/setting/create'),
                'js'        => $js,
                'title'     => 'Setting',
            ];

            return view('pages.BE.admin.manage.setting', $data);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    
    // NOTE GET /manage/setting/{any}
    public function show($any)
    {
        try {
            if (is_numeric($any)) {
                $data = DB::table('settings')->where('id', $any)->first();

                return response()->json($data);
            }

            $data = DB::table('settings');

            return DataTables::of($data)
                ->editColumn(
                    'image',
                    function ($row) {
                        $data   = [
                            'id'    => $row->id,
                            'path'  => asset('/assets/images/settings/' . $row->image),
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

                        return view('components.buttons.BE.manage.setting', $data);
                    }
                )
                ->addIndexColumn()
                ->make(true);
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') return dd($e);

            return abort(500);
        }
    }
    
    // NOTE POST /manage/setting/{id}
    public function update(Request $request, $id)
    {
        try {
            $setting = DB::table('settings')->where('id', $id)->first();

            if (!$setting) return abort(404);

            $rules = [
                'name'      => 'required|unique:settings,name,' . $id,
                'email'     => 'required',
                'detail'    => 'required',
            ];

            $messages = [
                'name.required'     => 'Nama kelas wajib diisi',
                'name.unique'       => 'Nama kelas sudah terdaftar',
                'email.required'    => 'Email wajib diisi',
                'detail.required'   => 'Keterangan Footer diisi',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            DB::transaction(function () use ($request, $id, $setting) {
                if ($request->file('image') &&  $request->file('imagebanner')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/settings/' . $setting->image);
                        $pleaseRemoveBanner = base_path('public/assets/images/settings/' . $setting->imagebanner);
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings/' . $setting->image;
                        $pleaseRemoveBanner = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings/' . $setting->imagebanner;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/settings/' . $setting->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    if (file_exists($pleaseRemoveBanner)) {
                        unlink($pleaseRemoveBanner);
                    }
                    
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $extensionbanner = $request->file('imagebanner')->getClientOriginalExtension();

                    $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;
                    $imagebanner  = date('YmdHis') . '' . str_replace(' ', '', 'Banner') . '.' . $extensionbanner;

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/settings');
                        $destinationbanner  = base_path('public/assets/images/settings');
                    } else {
                        $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings';
                        $destinationbanner  = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings';
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/settings';
                    }

                    $request->file('image')->move($destination, $image);
                    $request->file('imagebanner')->move($destinationbanner, $imagebanner);

                    DB::table('settings')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'image'         => $image,
                        'imagebanner'   => $imagebanner,
                        'name'          => $request->name,
                        'email'         => str_replace(',', '', $request->email),
                        'hp' => $request->hp ? str_replace(',', '', $request->hp) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                }
                else if ($request->file('image')) {
                    if (env('APP_ENV') == 'local') {
                        $pleaseRemove = base_path('public/assets/images/settings/' . $setting->image);
                       
                    } else {
                        $pleaseRemove = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings/' . $setting->image;
                       
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/settings/' . $setting->image;
                    }

                    if (file_exists($pleaseRemove)) {
                        unlink($pleaseRemove);
                    }

                    
                    
                    $extension = $request->file('image')->getClientOriginalExtension();
                   

                    $image  = date('YmdHis') . '' . str_replace(' ', '', $request->name) . '.' . $extension;
                    

                    if (env('APP_ENV') == 'local') {
                        $destination        = base_path('public/assets/images/settings');
                        
                    } else {
                        $destination        = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings';
                        
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/settings';
                    }

                    $request->file('image')->move($destination, $image);
                    

                    DB::table('settings')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'image'         => $image,
                       
                        'name'          => $request->name,
                        'email'         => str_replace(',', '', $request->email),
                        'hp' => $request->hp ? str_replace(',', '', $request->hp) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                }
                else if (  $request->file('imagebanner')) {
                    if (env('APP_ENV') == 'local') {
                       
                        $pleaseRemoveBanner = base_path('public/assets/images/settings/' . $setting->imagebanner);
                    } else {
                       
                        $pleaseRemoveBanner = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings/' . $setting->imagebanner;
                        //$pleaseRemove = getDevelopmentPublicPath() . '/assets/images/settings/' . $setting->image;
                    }

                    

                    if (file_exists($pleaseRemoveBanner)) {
                        unlink($pleaseRemoveBanner);
                    }
                    
                    
                    $extensionbanner = $request->file('imagebanner')->getClientOriginalExtension();

                    
                    $imagebanner  = date('YmdHis') . '' . str_replace(' ', '', 'Banner') . '.' . $extensionbanner;

                    if (env('APP_ENV') == 'local') {
                       
                        $destinationbanner  = base_path('public/assets/images/settings');
                    } else {
                       
                        $destinationbanner  = '/home/masterti/subdomain/dev.mastertiktokagency.com/assets/images/settings';
                        //$destination        = getDevelopmentPublicPath() . '/assets/images/settings';
                    }

                   
                    $request->file('imagebanner')->move($destinationbanner, $imagebanner);

                    DB::table('settings')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                       
                        'imagebanner'   => $imagebanner,
                        'name'          => $request->name,
                        'email'         => str_replace(',', '', $request->email),
                        'hp' => $request->hp ? str_replace(',', '', $request->hp) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                }
                 else {
                    DB::table('settings')->where('id', $id)->update([
                        'updated_at'    => date('Y-m-d H:i:s'),
                        'detail'        => $request->detail,
                        'name'          => $request->name,
                        'email'         => str_replace(',', '', $request->email),
                        'hp' => $request->hp ? str_replace(',', '', $request->hp) : 0,
                        'slug'          => Str::slug($request->name)
                    ]);
                }
            });

            return redirect()->to('/manage/setting')->with([
                'success' => 'Setting berhasil diperbaharui'
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
