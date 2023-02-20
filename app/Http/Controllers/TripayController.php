<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripayController extends Controller
{
    // NOTE GET /tripay/fee/{payment}/{total}
    public function adminFee($payment, $total)
    {
        if (env('APP_ENV') == 'local') {
            $url    = 'https://tripay.co.id/api-sandbox/merchant/payment-channel?code=' . $payment;
            $authorization = 'Bearer DEV-7xaQXEMtSUc5OzLFSfyJWeZfxCPUhM0VoR5HKhvT';
        } else {

            $url    = 'https://tripay.co.id/api-sandbox/merchant/payment-channel?code=' . $payment;
            $authorization = 'Bearer DEV-7xaQXEMtSUc5OzLFSfyJWeZfxCPUhM0VoR5HKhvT';
            // $url    = 'https://tripay.co.id/api/merchant/payment-channel?code=' . $code;
            // $authorization = 'Bearer eAc71WSvQAc1L2b62vtQNKVzTvlMSosvJf0BPuY5';
        }

        $client = new Client();

        $response   = $client->request('GET', $url, [
            'headers'   => [
                'Authorization' => $authorization
            ]
        ]);

        $data   = json_decode($response->getBody(), true);

        $flat_merchant      = $data['data'][0]['fee_merchant']['flat'];
        $percent_merchant   = $data['data'][0]['fee_merchant']['percent'];

        $flat       = $data['data'][0]['fee_customer']['flat'];
        $percent    = $data['data'][0]['fee_customer']['percent'];

        if ($percent > 0) {
            $phase1 = floatval($total);
            $phase2 = (($phase1 * ($percent / 100) + $flat));
            $phase3 = ceil($phase2);

            $fee    = intval($phase3);
        } else {
            $fee    = $flat;
        }

        $grandTotal = ($total + $fee);

        $json   = [
            'fee'   => $fee,
            'total' => $grandTotal,
        ];

        return response()->json($json);
    }
    // NOTE POST /api/gateway-tripay
    public function callback(Request $request)
    {
        $paid_at    = $request->paid_at;
        $reference  = $request->reference;
        $status     = $request->status;

        $order = DB::table('orders')->where('reference', $reference)->first();

        if ($status == 'PAID') {
            if ($order) {
                DB::table('orders')->where('reference', $reference)->update([
                    'status'        => 'paid',
                    'updated_at'    => date('Y-m-d H:i:s', strtotime($paid_at))
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
                        'user_id'   => $order->referred_by
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

                echo json_encode([
                    'status'    => 'paid',
                    'success'   => true
                ]);
            }

            echo json_encode([
                'status'    => null,
                'success'   => false
            ]);
        } elseif ($status == 'EXPIRED') {
            if ($order) {
                DB::table('orders')->where('reference', $reference)->update([
                    'status'        => 'expired',
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);

                echo json_encode([
                    'status'    => 'expired',
                    'success'   => true
                ]);
            }

            echo json_encode([
                'status'    => null,
                'success'   => false
            ]);
        } else {
            echo json_encode([
                'status'    => null,
                'success'   => true
            ]);
        }
    }
    // NOTE GET /tripay/instruction/{refData}
    public static function instruction($refData)
    {
        $ref    = $refData;

        if (env('APP_ENV') == 'local') {
            $url    = 'https://tripay.co.id/api-sandbox/transaction/detail?reference=' . $ref;
            $authorization = 'Bearer DEV-7xaQXEMtSUc5OzLFSfyJWeZfxCPUhM0VoR5HKhvT';
        } else {
            $url    = 'https://tripay.co.id/api-sandbox/transaction/detail?reference=' . $ref;
            $authorization = 'Bearer DEV-7xaQXEMtSUc5OzLFSfyJWeZfxCPUhM0VoR5HKhvT';
            // $url    = 'https://tripay.co.id/api/transaction/detail?reference=' . $ref;
            // $authorization = 'Bearer eAc71WSvQAc1L2b62vtQNKVzTvlMSosvJf0BPuY5';
        }

        $client = new Client();

        $response   = $client->request('GET', $url, [
            'headers'   => [
                'Authorization' => $authorization
            ]
        ]);

        $data   = json_decode($response->getBody(), true);


        $checkout_url = $data['data']['checkout_url'];

        return redirect()->to($checkout_url);
    }
}
