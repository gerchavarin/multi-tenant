<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $dates = ['deleted_at','created_at','updated_at'];

    protected $fillable = [
        'type',
        'mount',
        'description',
        'enterprise_id',
    ];
}
