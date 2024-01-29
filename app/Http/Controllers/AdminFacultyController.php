<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Results;
use App\Models\Sonogram;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminFacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }
            $queryResult = DB::table("faculty")->get();
            $faculty = json_decode($queryResult, true);

            $devices = Devices::all();
            $devices = json_decode($devices, true);
            return view("admin.faculty", ['faculty' => $faculty, 'devices' => $devices]);
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
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }
            if (isset($request->btnAcceptSonogram)) {
                $affectedRows = DB::table("faculty")
                    ->where("facultyID", $id)
                    ->update([
                        "status" => "Successful",
                        "remarks" => "See Results",
                        "approver" => $request->vet
                    ]);
                if ($affectedRows > 0) {
                    session()->put("successUpdate", true);
                    $queryResult = DB::table("sonograms")->where('facultyID', $id)->get();
                    $data = json_decode($queryResult, true);

                    $this->callApi($id, $data[0]['imagePath']);

                    // $generatedResult = $this->getDetails(rand(1, 3));
                    // $generatedResult->facultyID = $id;
                    // $isSave = $generatedResult->save();
                    // if ($isSave) {
                    //     session()->put("successUpdate", true);
                    //     $this->callApi($id);
                    // } else {
                    //     $affectedRows = DB::table("sonograms")
                    //         ->where("facultyID", $id)
                    //         ->update([
                    //             "status" => "In Progress",
                    //             "remarks" => ""
                    //         ]);
                    //     session()->put("errorcUpdate", true);
                    // }
                } else {
                    session()->put("errorcUpdate", true);
                }
            }
            return redirect("/adminsono");
        } else {
            return redirect("/");
        }
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

            if (isset($request->btnDeclineSonogram)) {
                $affectedRows = DB::table("faculty")
                    ->where("facultyID", $id)
                    ->update([
                        "status" => "Decline",
                        "remarks" => $request->remarks
                    ]);

                if ($affectedRows > 0) {
                    session()->put("successDecline", true);
                } else {
                    session()->put("errorcDecline", true);
                }
            } else if (isset($request->btnDeleteSonogram)) {

                $queryResult = DB::table('results')->where('facultyID', $id)->get();
                $data = json_decode($queryResult, true);
                foreach ($data as $d) {
                    try {
                        $dPath = $d['imagePath'];
                        if ($dPath) {
                            $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $dPath;
                            File::delete($destinationPath);
                        }
                    } catch (Exception $e1) {
                    }

                    $isDelete = DB::table('results')->where('facultyID', '=', $id)->delete();
                }

                try {
                    $originalDirectoryPath = $request->origImagePath;
                    if ($originalDirectoryPath) {
                        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $originalDirectoryPath;
                        File::delete($destinationPath);
                    }
                } catch (Exception $e1) {
                }


                try {
                    $origModelPath = $request->origModelPath;
                    if ($origModelPath) {
                        $destinationPath2 = $_SERVER['DOCUMENT_ROOT'] . $origModelPath;
                        File::delete($destinationPath2);
                    }
                } catch (Exception $e1) {
                }


                $isDelete = DB::table('faculty')->where('facultyID', '=', $id)->delete();
                if ($isDelete) {
                    session()->put("successAdminDeleteSonogram", true);
                } else {
                    session()->put("errorAdminDeleteSonogram", true);
                }
            }

            return redirect("/adminsono");
        } else {
            return redirect("/");
        }
    }


    private function getDetails(int $randomNum): Results
    {
        $newResults = new Results();

        $list = $this->getListOfDetails();
        $newResults = $list[$randomNum - 1];
        return $newResults;
    }

    private function getListOfDetails(): Collection
    {
        $result = collect();
        $arr = array();

        $newResult = new Results();
        $newResult->age = "1-2 years old";
        $newResult->pregnancyStage = "Pre-pregnancy";
        $newResult->numberOfFetus = "Singleton (One Fetus)";
        $newResult->healthStatus = "Excellent";
        array_push($arr, $newResult);

        $newResult = new Results();
        $newResult->age = "3-4 years old";
        $newResult->pregnancyStage = "Early pregnancy (1-4 weeks)";
        $newResult->numberOfFetus = "Two-Four Fetuses";
        $newResult->healthStatus = "Good";
        array_push($arr, $newResult);

        $newResult = new Results();
        $newResult->age = "5-6 years old";
        $newResult->pregnancyStage = "Mid-pregnancy (4-6 weeks)";
        $newResult->numberOfFetus = "Five or More Fetuses";
        $newResult->healthStatus = "Fair";
        array_push($arr, $newResult);

        $result = collect($arr);

        return $result;
    }

    private function callApi(string $id, string $imagePath): void
    {
        $client = new Client();
        $response = $client->post('http://localhost:5000/detect', [
            'multipart' => [
                [
                    'name' => 'id',
                    'contents' => $id
                ],
                [
                    'name' => 'image_url',
                    'contents' => $imagePath
                ],
                [
                    'name' => 'storagePath',
                    'contents' => $_SERVER['DOCUMENT_ROOT'] . "/public" . '/storage/results'
                ]
            ]
        ]);

        // var_dump($response->getBody()->getContents());
    }
}
