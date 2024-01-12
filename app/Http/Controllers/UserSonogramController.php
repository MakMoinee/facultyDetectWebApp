<?php

namespace App\Http\Controllers;

use App\Models\Sonogram;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserSonogramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userID = $mUser[0]['userID'];
            $queryResult = DB::table("sonograms")->where("userID", $userID)->get();
            $sonograms = json_decode($queryResult,true);
            return view("user.sonogram", ['sonograms' => $sonograms]);
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
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userID = $mUser[0]['userID'];

            $files = $request->file("files");
            $fileName = "";
            $petName = $request->petName;

            if ($files) {
                $mimeType = $files->getMimeType();
                if ($mimeType == "image/png" || $mimeType == "image/jpg" || $mimeType == "image/JPG" || $mimeType == "image/JPEG" || $mimeType == "image/jpeg" || $mimeType == "image/PNG") {
                    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/data/sonograms';
                    $fileName = strtotime(now()) . "." . $files->getClientOriginalExtension();
                    $isFile = $files->move($destinationPath,  $fileName);
                    chmod($destinationPath, 0755);

                    if ($fileName != "") {
                        $fileName = "/data/sonograms/" . $fileName;
                        $sonogram = new Sonogram();
                        $sonogram->petName = $petName;
                        $sonogram->userID = $userID;
                        $sonogram->imagePath = $fileName;
                        $sonogram->status = "In Progress";
                        $isSave = $sonogram->save();
                        if ($isSave) {
                            session()->put("successAddSonogram", true);
                        } else {
                            session()->put("errorAddSonogram", true);
                        }
                    } else {
                        session()->put("errorAddSonogram", true);
                    }
                } else {
                    session()->put("errorMimeTypeInvalid", true);
                }
            } else {
                session()->put("errorFileEmpty", true);
            }

            return redirect("/sonogram");
        } else {
            return redirect("/");
        }
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

            if (isset($request->btnDeleteSonogram)) {
                try {
                    $originalDirectoryPath = $request->origImagePath;
                    if ($originalDirectoryPath) {
                        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $originalDirectoryPath;
                        File::delete($destinationPath);
                    }
                } catch (Exception $e1) {
                }

                $isDelete = DB::table('sonograms')->where('sonogramID', '=', $id)->delete();
                if ($isDelete) {
                    session()->put("successDeleteSonogram", true);
                } else {
                    session()->put("errorDeleteSonogram", true);
                }
            }

            return redirect("/sonogram");
        } else {
            return redirect("/");
        }
    }
}
