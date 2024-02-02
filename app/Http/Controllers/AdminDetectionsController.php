<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDetectionsController extends Controller
{
    public function index(Request $request)
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }
            $searchKey = $request->query('search');
            $queryResult = DB::table("vwresults")->where('name','<>','unknown')->get();
            $detections = json_decode($queryResult, true);
            $tmpDetection = array();
            foreach($detections as $d){
                $dateTime = new DateTime($d['detectedDate'], new DateTimeZone('UTC'));
                $dateTime->setTimezone(new DateTimeZone('Asia/Manila'));
                $formattedDate = $dateTime->format('Y-m-d h:i A');
                $d['detectedDate'] = $formattedDate;
                if ($searchKey) {
                    if (str_contains($searchKey, $d['room'])) {
                        array_push($tmpDetection, $d);
                    }
                } else {
                    array_push($tmpDetection, $d);
                }
            }
            return view("admin.detections", ['detections' => $tmpDetection, 'searchKey' => '']);
        } else {
            return redirect("/");
        }
    }
}
