<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class AdminDevicesController extends Controller
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
            $searchKey = $request->query('search');
            $devices = Devices::all();
            $devices = json_decode($devices, true);
            $tmpDevices = array();

            foreach ($devices as $d) {
                $dateTime = new DateTime($d['created_at'], new DateTimeZone('UTC'));
                $dateTime->setTimezone(new DateTimeZone('Asia/Manila'));
                $formattedDate = $dateTime->format('Y-m-d h:i A');
                $d['created_at'] = $formattedDate;
                if ($searchKey) {
                    if (str_contains($searchKey, $d['room'])) {
                        array_push($tmpDevices, $d);
                    }
                } else {
                    array_push($tmpDevices, $d);
                }
            }

            return view("admin.devices", ['devices' => $tmpDevices, 'searchKey' => $searchKey]);
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
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            if ($request->btnAddDevice) {
                $queryResults = DB::table('devices')->where('ip', '=', $request->ip)->get();
                $results = json_decode($queryResults, true);
                if (count($results) > 0) {
                    session()->put('deviceExist', true);
                } else {
                    $newDevice = new Devices();
                    $newDevice->room = $request->room;
                    $newDevice->ip = $request->ip;
                    $newDevice->status = "Inactive";
                    $isSave = $newDevice->save();
                    if ($isSave) {
                        session()->put('deviceAddSuccess', true);
                    } else {
                        session()->put('deviceFailedAdd', true);
                    }
                }
                return redirect("/admin_devices");
            }
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
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            if ($request->btnUpdateDevice) {
                $queryResults = DB::table('devices')->where('ip', '=', $request->ip)->get();
                $results = json_decode($queryResults, true);
                if (count($results) > 0) {
                    $updateQuery = DB::table('devices')->where('deviceID', '=', $id)->update([
                        'room' => $request->room,
                        'ip' => $request->ip,
                    ]);
                    if ($updateQuery > 0) {
                        session()->put('successUpdateDevice', true);
                    } else {
                        session()->put('errorUpdateDevice', true);
                    }
                } else {
                    session()->put('deviceNotExist', true);
                }
            } else if ($request->btnActivateDevice) {
                $this->callApi($id, $request->ip, $request->room);
                session()->put("successActivate", true);
                sleep(3);
            }
            return redirect("/admin_devices");
        } else {
            return redirect("/");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);
            $userType = $mUser[0]['userType'];

            if ($userType != 1) {
                return redirect("/");
            }

            if ($request->btnDeleteDevice) {
                $queryResults = DB::table('devices')->where('deviceID', '=', $id)->get();
                $results = json_decode($queryResults, true);
                if (count($results) > 0) {
                    $deleteQuery = DB::table('devices')->where('deviceID', '=', $id)->delete();
                    if ($deleteQuery > 0) {
                        session()->put('successDeleteDevice', true);
                    } else {
                        session()->put('errorDeleteDevice', true);
                    }
                } else {
                    session()->put('deviceNotExist', true);
                }
                return redirect("/admin_devices");
            }
        } else {
            return redirect("/");
        }
    }

    private function callApi(string $id, string $ip, string $room): void
    {
        $client = new Client();
        $response = $client->get('http://' . $ip . ':5000/start', [
            'query' => [
                'room' => $room,
                'id' => $id
            ],
        ]);
    }
}
