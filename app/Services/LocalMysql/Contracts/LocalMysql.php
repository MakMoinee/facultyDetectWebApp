<?php

namespace App\Services\LocalMysql\Contracts;

interface LocalMysql
{

    /**
     * @param tableName - target table name
     * @param data - array values 
     */
    public function create(string $tableName, array $data, LocalMysqlListener $listener): void;

    public function findAll(string $tableName, LocalMysqlListener $listener);
}
