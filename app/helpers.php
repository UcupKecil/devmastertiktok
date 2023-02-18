<?php
// NOTE generate uid

use Illuminate\Support\Facades\DB;

// NOTE generate random phone number
function generatePhoneNumber()
{
    $x = '0123456789';

    $phone = '08' . substr(str_shuffle(str_repeat($x, ceil(11 / strlen($x)))), 1, 11);

    $validate = DB::table('user_details')->where('phone', $phone)->count();

    if ($validate > 0) {
        return generatePhoneNumber();
    }

    return $phone;
}
// NOTE generate random string
function generateRandomString($int)
{
    $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($x, ceil($int / strlen($x)))), 1, $int);
}
// NOTE generate uid
function generateUid()
{
    $uid = generateRandomString(6);

    $validate = DB::table('user_details')->where('uid', $uid);

    if ($validate->count() > 0) {
        return generateCode();
    }

    return $uid;
}
// NOTE string duration
function getDurationString($int)
{
    $hours = floor($int / 3600);
    $minutes = floor(($int / 60) % 60);

    if ($hours == 0) {
        $duration = $minutes . 'm';
    } else {
        $duration = $hours . "h " . $minutes . 'm';

        if (strlen($hours) == 0) {
            $duration = "0" . $hours . "h " . $minutes . 'm';
        }
    }

    return $duration;
}
// NOTE path production
function getProductionPublicPath()
{
    return '/home/stbwebid/public_html/survey';
}
// NOTE routing
function includeRouteFiles($folder)
{
    $directory = $folder;
    $handle = opendir($directory);
    $directory_list = [$directory];

    while (false !== ($filename = readdir($handle))) {
        if ($filename != '.' && $filename != '..' && is_dir($directory . $filename)) {
            array_push($directory_list, $directory . $filename . '/');
        }
    }

    foreach ($directory_list as $directory) {
        foreach (glob($directory . '*.php') as $filename) {
            require $filename;
        }
    }
}
