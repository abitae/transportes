<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class ServiceTableSunat
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function getAll()
    {
        return DB::table($this->table)->get();
    }

    public function findById($index, $value)
    {
        return DB::table($this->table)->where($index, $value)->first();
    }

}
