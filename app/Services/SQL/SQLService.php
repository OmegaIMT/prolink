<?php

namespace App\Services\SQL;

use Illuminate\Support\Facades\DB;

class SQLService
{
    public function execute(string $module, string $method, array $params = [])
    {
        $path = resource_path("sql/{$module}/{$method}.sql");

        if (!file_exists($path)) {
            throw new \Exception("SQL não encontrado: {$module}/{$method}.sql");
        }

        $sql = file_get_contents($path);

        return DB::select($sql, $params);
    }
}