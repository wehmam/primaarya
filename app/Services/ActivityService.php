<?php 

namespace App\Services;

use App\Models\ActivityLogs;
use App\Models\Cases;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityService {

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