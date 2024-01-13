<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\Sonogram;
use App\Models\SUsers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);

            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            $allUsers = new SUsers();
            $allUsers = SUsers::where('userType', '<>', '1')->get();

            $search = $request->query("search");
            $newUsers = array();
            if (isset($search)) {
                foreach ($allUsers as $a) {
                    if (str_contains($a['firstName'], $search)) {
                        array_push($newUsers, $a);
                    }
                }
            } else {
                $search = "";
            }



            return view("admin.account", [
                'accounts' => (count($newUsers) > 0 || $search != "" ? $newUsers : $allUsers),
                'searchKey' => $search
            ]);
        } else {
            return redirect("/");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);

            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            if (isset($request->btnDeleteAccount)) {
                $sonogram = Sonogram::where('userID', '=', $id)->get();
                if ($sonogram) {
                    foreach ($sonogram as $s) {
                        try {
                            $dPath = $s['imagePath'];
                            if ($dPath) {
                                $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $dPath;
                                File::delete($destinationPath);
                            }
                        } catch (Exception $e1) {
                        }

                        $results = Results::where('facultyID', '=', $s['facultyID'])->get();

                        foreach ($results as $r) {
                            try {
                                $dPath = $r['imagePath'];
                                if ($dPath) {
                                    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $dPath;
                                    File::delete($destinationPath);
                                }
                            } catch (Exception $e1) {
                            }
                            $isDeleteResult = DB::table("results")->where('facultyID', '=', $s['facultyID'])->delete();
                        }
                        $isDeleteResult = DB::table("sonograms")->where('facultyID', '=', $s['facultyID'])->delete();
                    }
                }

                $isDelete = DB::table("susers")->where('userID', '=', $id)->delete();
                if ($isDelete) {
                    session()->put("successDeleteAcc", true);
                } else {
                    session()->put("errorDeleteAcc", true);
                }
                return redirect('/adminaccount');
            } else {
                return redirect("/");
            }
        } else {
            return redirect("/");
        }
    }
}
