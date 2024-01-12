<?php

namespace App\Http\Controllers;

use App\Models\SUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
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
            if ($userType == 1) {
                return redirect("/admindashboard");
            }

            return view('user.account', ['account' => $mUser[0]]);
        }
        return redirect("/");
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
            if ($userType == 1) {
                return redirect("/admindashboard");
            }

            if (isset($request->btnUpdateAccount)) {

                $firstName = $request->firstName;
                $middleName = $request->middleName;
                $lastName = $request->lastName;
                $address = $request->address;
                $birthDate = $request->birthDate;
                $email = $request->email;
                $password = $request->password;
                $phoneNumber = $request->phoneNumber;
                if (strlen($phoneNumber) > 0 && strlen($phoneNumber) <= 13) {
                    if ($password) {
                        $hashPass = Hash::make($password);
                        $updateCount = DB::table('susers')->where("userID", "=", $id)->update([
                            'firstName' => $firstName,
                            'middleName' => $middleName,
                            'lastName' => $lastName,
                            'address' => $address,
                            'birthDate' => $birthDate,
                            'email' => $email,
                            'phoneNumber' => $phoneNumber,
                            'password' => $hashPass
                        ]);

                        if ($updateCount > 0) {
                            $nUser = new SUsers();
                            $mArr = array();
                            $nUser->userID = $id;
                            $nUser->firstName = $firstName;
                            $nUser->middleName = $middleName;
                            $nUser->lastName = $lastName;
                            $nUser->address = $address;
                            $nUser->birthDate = $birthDate;
                            $nUser->email = $email;
                            $nUser->password = $hashPass;
                            $nUser->phoneNumber = $phoneNumber;
                            array_push($mArr, $nUser);
                            session()->put("users", $mArr);
                            session()->put("successUpdateAccount", true);
                        } else {
                            session()->put("errorUpdateAccount", true);
                        }
                    } else {
                        $updateCount = DB::table('susers')->where("userID", "=", $id)->update([
                            'firstName' => $firstName,
                            'middleName' => $middleName,
                            'lastName' => $lastName,
                            'address' => $address,
                            'birthDate' => $birthDate,
                            'email' => $email,
                            'phoneNumber' => $phoneNumber,
                        ]);

                        if ($updateCount > 0) {
                            $nUser = new SUsers();
                            $mArr = array();
                            $nUser->userID = $id;
                            $nUser->firstName = $firstName;
                            $nUser->middleName = $middleName;
                            $nUser->lastName = $lastName;
                            $nUser->address = $address;
                            $nUser->birthDate = $birthDate;
                            $nUser->email = $email;
                            $nUser->password = $mUser[0]['password'];
                            $nUser->phoneNumber = $phoneNumber;
                            array_push($mArr, $nUser);
                            session()->put("users", $mArr);
                            session()->put("successUpdateAccount", true);
                        } else {
                            session()->put("errorUpdateAccount", true);
                        }
                    }
                } else {
                    session()->put("phoneNumberLengthErr", true);
                }
            }

            return redirect("/account");
        }
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
