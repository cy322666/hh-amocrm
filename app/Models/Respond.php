<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'title',
        'area',
        'age',
        'gender',
        'phone',
        'email',
        'lead_id',
        'contact_id',
    ];

    const STATUS_CREATE = 0;
    const STATUS_WAIT = 1;
    const STATUS_SEND = 2;
    const STATUS_FAIL = 3;

    public static function getContactEmail($arrayData) : ?string
    {
        if (!empty($arrayData[0]) && $arrayData[0]['type']['name'] !== "Мобильный телефон") {

            return $arrayData[0]['value'];
        }
        if (!empty($arrayData[1]) && $arrayData[1]['type']['name'] !== "Мобильный телефон") {

            return $arrayData[1]['value'];
        }
    }

    public static function getContactPhone($arrayData) : ?string
    {
        if (!empty($arrayData[0]) && $arrayData[0]['type']['name'] == "Мобильный телефон") {

            return $arrayData[0]['value'];
        }
        if (!empty($arrayData[1]) && $arrayData[1]['type']['name'] == "Мобильный телефон") {

            return $arrayData[1]['value'];
        }
    }
}
