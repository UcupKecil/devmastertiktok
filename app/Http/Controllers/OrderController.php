<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function pay()
    {
        try {
            $order = DB::table('orders')->where('status', 'pending')->first();

            if (!$order) return redirect()->back();

            DB::transaction(function () use ($order) {
                DB::table('orders')->where('id', $order->id)->update([
                    'status'        => 'paid',
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);

                if ($order->referred_by) {
                    $course = DB::table('courses')->where('id', $order->course_id)->first();

                    $credit = floatval(($course->price * 33.5) / 100);

                    $changes = $credit % 1000;

                    $add = (1000 - $changes);

                    $credit += $add;

                    DB::table('point_transactions')->insert([
                        'created_at' => date('Y-m-d H:i:s'),
                        'credit'    => $credit,
                        'user_id'   => $order->referred_by,
                        'image'   => '',

                    ]);

                    $credit = DB::table('point_transactions')->where('user_id', $order->referred_by)->sum('credit');
                    $debit  = DB::table('point_transactions')->where('user_id', $order->referred_by)->sum('debit');

                    $point = ($credit - $debit);

                    DB::table('user_details')->where('user_id', $order->referred_by)->update([
                        'point' => $point
                    ]);
                }

                DB::table('course_students')->insert([
                    'course_id'     => $order->course_id,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'user_id'       => $order->user_id
                ]);
            });

            return redirect()->back();
        } catch (Exception $e) {
            dd($e);
        }
    }
}
