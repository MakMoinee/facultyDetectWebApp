<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserFacultyController extends Controller
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
            $queryResult = DB::table("vwresults")->get();
            $detections = json_decode($queryResult, true);
            return view("user.faculty", ['detections' => $detections]);
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
        // dd($request);
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userID = $mUser[0]['userID'];
            $userType = $mUser[0]['userType'];

            $files = $request->file("files");
            $fileName = "";
            $facultyName = $request->facultyName;

            $ptFile = $request->file("pt");
            $ptFileName = "";

            if ($files && $ptFile) {
                $mimeType = $files->getMimeType();
                $ptMimeType = $ptFile->getMimeType();
                if (
                    $mimeType == "image/png" ||
                    $mimeType == "image/jpg" ||
                    $mimeType == "image/JPG" ||
                    $mimeType == "image/JPEG" ||
                    $mimeType == "image/jpeg" ||
                    $mimeType == "image/PNG" &&
                    $ptMimeType == "application/octet-stream"
                ) {
                    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/data/faculty';
                    $fileName = strtotime(now()) . "." . $files->getClientOriginalExtension();
                    $isFile = $files->move($destinationPath,  $fileName);
                    chmod($destinationPath, 0755);

                    if ($fileName != "") {

                        $destinationPath2 = $_SERVER['DOCUMENT_ROOT'] . '/data/weights';
                        $ptFileName = strtotime(now()) . "." . $ptFile->getClientOriginalExtension();
                        $isFile2 = $ptFile->move($destinationPath2,  $ptFileName);
                        chmod($destinationPath2, 0755);

                        if ($isFile2) {
                            $fileName = "/data/faculty/" . $fileName;
                            $sonogram = new Faculty();
                            $sonogram->facultyName = $facultyName;
                            $sonogram->imagePath = $fileName;
                            $sonogram->status = "";
                            $sonogram->modelPath = "/data/weights/" . $ptFileName;
                            $isSave = $sonogram->save();
                            if ($isSave) {
                                session()->put("successAddFaculty", true);
                            } else {
                                session()->put("errorAddFaculty", true);
                            }
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
            if ($userType == 1) {
                return redirect("/adminsono");
            }
            return redirect("/faculty");
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

                $isDelete = DB::table('sonograms')->where('facultyID', '=', $id)->delete();
                if ($isDelete) {
                    session()->put("successDeleteSonogram", true);
                } else {
                    session()->put("errorDeleteSonogram", true);
                }
            }

            return redirect("/faculty");
        } else {
            return redirect("/");
        }
    }
}
