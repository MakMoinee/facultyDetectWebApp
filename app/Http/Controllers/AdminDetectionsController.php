<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDetectionsController extends Controller
{
    public function index()
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            $queryResult = DB::table("vwresults")->where('name','<>','unknown')->get();
            $detections = json_decode($queryResult, true);
            return view("admin.detections", ['detections' => $detections, 'searchKey' => '']);
        } else {
            return redirect("/");
        }
    }
}
