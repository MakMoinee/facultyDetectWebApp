<?php

namespace App\Services\LocalMysql;

use App\Models\SUsers;
use App\Services\LocalMysql\Contracts\LocalMysql;
use App\Services\LocalMysql\Contracts\LocalMysqlListener;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LocalMysqlRepository implements LocalMysql
{
    public function create(string $tableName, array $data, LocalMysqlListener $listener): void
    {
    }

    public function findAll(string $tableName, LocalMysqlListener $listener): void
    {
        try {
            $result = DB::table($tableName)->get();
            $data = json_decode($result, true);
            $listener->onSuccessUsers($data);
        } catch (Exception $e) {
            $listener->onError($e);
        }
    }

    public function findAllWithWhere(string $tableName, string $whereColumn, string $whereOperator, string $whereValue, LocalMysqlListener $listener)
    {
        try {
            $result = DB::table($tableName)->where($whereColumn, $whereOperator, $whereValue)->get();
            $data = json_decode($result, true);
            return $listener->onSuccessUsers($data);
        } catch (Exception $e) {
            $listener->onError($e);
        }
    }

    public function findAllWithWhere2(string $tableName, string $whereColumn, string $whereOperator, string $whereValue): array
    {
        $result = array();
        try {
            $queryResult = DB::table($tableName)->where($whereColumn, $whereOperator, $whereValue)->get();
            $result = json_decode($queryResult, true);
            return $result;
        } catch (Exception $e) {
            return $result;
        }
    }

    public function createDefaultAdmin()
    {
        try {
            $newUser = new SUsers();
            $newUser->firstname = "Administrator";
            $newUser->middlename = "X";
            $newUser->lastname = "Administrator";
            $newUser->email = "admin@default.com";
            $newUser->password = Hash::make("adminpass");
            $newUser->address = "default";
            $newUser->birthDate = "1998-01-01";
            $newUser->phoneNumber = "";
            $newUser->userType = 1;
            $isSave = $newUser->save();
        } catch (Exception $e) {
            dd($e);
        }
    }
}
