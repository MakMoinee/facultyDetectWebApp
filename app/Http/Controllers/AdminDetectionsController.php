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
            $queryResult = DB::table("vwresults")->where('name','<>','unknown')->orderBy('detectedDate', 'desc')->get();
            $detections = json_decode($queryResult, true);
            return view("admin.detections", ['detections' => $detections, 'searchKey' => '']);
        } else {
            return redirect("/");
        }
    }
}
