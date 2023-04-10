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

    public static function getContact($arrayData) : ?string
    {
        if ($arrayData !== null) {

            if (is_string($arrayData) == true) {

                $arrayData = json_decode($arrayData, true);
            }

            if (!empty($arrayData['formatted'])) {

                return $arrayData['formatted'];
            } elseif (!empty($arrayData['value']))
                return $arrayData['value'];
        }
        return null;
    }
}
