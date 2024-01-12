<?php

namespace App\Http\Controllers;

use App\Models\SUsers;
use App\Services\LocalMysql\Contracts\LocalMysqlListener;
use App\Services\LocalMysql\LocalMysqlRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


    protected $db;
    protected $dbListener;

    public function __construct(LocalMysqlRepository $repo)
    {
        $this->db = $repo;
        $this->dbListener = new LoginDBListener();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        if ($request->btnLogin) {
            $email = $request->email;
            $password = $request->password;

            $queryResult = DB::table('susers')->where(['email' => $email])->get();
            $data = json_decode($queryResult, true);
            $users = array();
            $userType = 0;

            foreach ($data as $d) {
                if (password_verify($password, $d['password'])) {
                    $userType = $d['userType'];
                    array_push($users, $d);
                    break;
                }
            }

            if (count($users) > 0) {
                if ($userType == 1) {
                    session()->put("users", $users);
                    session()->put("successLogin", true);
                    return redirect("/admindashboard");
                } else {
                    session()->put("users", $users);
                    session()->put("successLogin", true);
                    return redirect("/userdashboard");
                }
            } else {
                session()->put("errorLogin", true);
                return redirect("/");
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function signup(Request $request)
    {
        if (isset($request->btnSignup)) {

            $firstName = $request->firstName;
            $middleName = $request->middleName;
            $lastName = $request->lastName;
            $email = $request->email;
            $password = $request->password;
            $birthDate = $request->birthDate;
            $address = $request->address;
            $phoneNumber = $request->phoneNumber;
            $this->dbListener->setUser($firstName, $middleName, $lastName, $address, $email, $password, $birthDate, $phoneNumber);
            $this->db->findAllWithWhere('susers', 'email', '=', $email, $this->dbListener);
            return redirect("/");
        } else {
            return redirect("/");
        }
    }
}

class LoginDBListener implements LocalMysqlListener
{
    protected array $usersData;
    protected SUsers $user;

    public function __construct()
    {
        $this->usersData = array();
        $this->user = new SUsers();
    }

    public function setUser(
        string $firstName,
        string $middleName,
        string $lastName,
        string $address,
        string $email,
        string $password,
        string $birthDate,
        string $phoneNumber
    ): void {
        $this->user->firstName = $firstName;
        $this->user->middleName = $middleName;
        $this->user->lastName = $lastName;
        $this->user->address = $address;
        $this->user->email = $email;
        $hashPass = Hash::make($password);
        $this->user->password = $hashPass;
        $this->user->birthDate = $birthDate;
        $this->user->userType = 2;
        $this->user->phoneNumber = $phoneNumber;
    }

    public function onSuccess(): void
    {
    }
    public function onError(Exception $e): void
    {
        dd($e);
        session()->put("errorAddUserSpecific", true);
    }
    public function onSuccessUsers(array $data)
    {
        if (count($data) > 0) {
            session()->put("existEmail", true);
        } else {
            $isSave = $this->user->save();

            if ($isSave) {
                // $currentUser = DB::table("susers")->where('email', '=', $this->user->email)->get();
                // $resUser = json_decode($currentUser, true);
                session()->put("successAddUser", true);
                // $mUser = $resUser[0];
                // session()->put('users', $mUser);
            } else {
                session()->put("errorAddUser", true);
            }
        }
    }
}
