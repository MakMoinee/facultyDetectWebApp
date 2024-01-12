<?php

namespace App\Http\Controllers;

use App\Services\LocalMysql\LocalMysqlRepository;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    protected $db;
    public function __construct(LocalMysqlRepository $repo)
    {
        $this->db = $repo;
    }

    public function index()
    {
        $data = $this->db->findAllWithWhere2("susers", "userType", "=", 1);

        if (count($data) == 0) {
            $this->db->createDefaultAdmin();
        }

        if (session()->exists("users")) {
            $mUser = session()->pull("users");
            session()->put("users", $mUser);

            $userType = $mUser[0]['userType'];
            if ($userType == 1) {
                return redirect("/admindashboard");
            }

            return redirect("/userdashboard");
        }
        return view('welcome');
    }
}
