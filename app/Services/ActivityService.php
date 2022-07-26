<?php

namespace App\Services;

use App\Models\ActivityLogs;
use App\Models\Cases;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class ActivityService {

    public static function activityLogs($logName = '' ,$desc = '', $productId = '', $categoryId = '') {
        DB::beginTransaction();

        if(!Cache::has("session_id-" . self::get_client_ip())) {
            Cache::put("session_id-" . self::get_client_ip() , session()->getId(), 30);
        }

        return true;


        $session_id = Cache::has("session_id-" . self::get_client_ip()) ?  Cache::get('session_id-' . self::get_client_ip()) : "";
        dd($session_id);

        // dd(session()->isValidId(session()->getId()), session()->getId());
        // dd(session()->getId(), self::get_client_ip());
        $cases = Cases::where("session", $session_id)
            ->first();

        if(!$cases) {
            $cases = new Cases();
        }
        $cases->session = $session_id;
        $cases->case_name = $logName;
        $cases->ip_address = self::get_client_ip();
        $cases->location = self::getLocation();
        $cases->save();

        activity()->causedBy(Auth::user())
            ->tap(function(Activity $activity) use($desc, $logName, $productId, $categoryId, $cases) {
                $activity->case_id = $cases->id;
                $activity->description = $desc;
                $activity->log_name = $logName;
                if(!empty($productId)) {
                    $activity->product_id = $productId;
                }
                if(!empty($categoryId)) {
                    $activity->category_id = $categoryId;
                }
                $activity->save();
            });

        DB::commit();
    }

    public static function listenEvent($eventTitle = '', $postType = '', $activity = 'Visited', $productsLog = '') {

        DB::beginTransaction();

        $cases = Cases::where("session", session()->getId())
            ->first();

        if(!$cases) {
            $cases = new Cases();
        }
        $cases->session = session()->getId();
        $cases->case_name = $eventTitle;
        $cases->save();

        $activityLogs               = new ActivityLogs();
        $activityLogs->case_id = $cases->id;
        $activityLogs->title        = $eventTitle;
        $activityLogs->type         = $postType;
        $activityLogs->email        = Auth::check() ? Auth::user()->email : "";
        $activityLogs->activity     = $activity;
        $activityLogs->ip_address   = self::get_client_ip();
        $activityLogs->location     = self::getLocation();
        if(!empty($productsLog)) {
            $activityLogs->custom_logs          = $productsLog;
        }
        $activityLogs->save();

        DB::commit();

        return true;
    }

    public static function getLocation() {
        $ip       = self::get_client_ip();
        $json     = file_get_contents("http://ipinfo.io/$ip/geo");
        $json     = collect(json_decode($json, true));

        return isset($json['loc']) ? $json['loc'] : "";
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}
