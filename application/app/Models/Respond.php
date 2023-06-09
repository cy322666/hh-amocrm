<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Respond extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'status',
        'webhook_id',
        'resume_id',
        'vacancy_id',
        'vacancy_name',
        'name',
        'app_id',
        'title',
        'area',
        'age',
        'gender',
        'phone',
        'email',
        'lead_id',
        'contact_id',
        'manager_id',
    ];

    const STATUS_CREATE = 0;
    const STATUS_WAIT = 1;
    const STATUS_SEND = 2;
    const STATUS_FAIL = 3;

    public static function getContactEmail($arrayData) : ?string
    {
        if (!empty($arrayData[0]) && $arrayData[0]['type']['name'] == "Эл. почта") {

//            Log::info(__METHOD__, $arrayData[0]);

            return $arrayData[0]['value'];
        }
        if (!empty($arrayData[1]) && $arrayData[1]['type']['name'] == "Эл. почта") {

//            Log::info(__METHOD__, $arrayData[1]);

            return $arrayData[1]['value'];
        }
        return null;
    }

    public static function getContactPhone($arrayData) : ?string
    {
        if (!empty($arrayData[0]) && $arrayData[0]['type']['name'] !== "Эл. почта") {

            if ($arrayData[0]['value'] !== null) {

                return $arrayData[0]['value']['country'].$arrayData[0]['value']['city'].$arrayData[0]['value']['number'];
            }
        }
        if (!empty($arrayData[1]) && $arrayData[1]['type']['name'] !== "Эл. почта") {

//            Log::info(__METHOD__, $arrayData[1]);

            return $arrayData[1]['value']['country'].$arrayData[1]['value']['city'].$arrayData[1]['value']['number'];
        }
        return null;
    }
}
