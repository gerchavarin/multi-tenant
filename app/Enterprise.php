<?php

namespace App;

use App\Record;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'rfc',
        'description',
        'user_id',
    ];

    public function records() {
        return $this->hasMany(Record::class);
    }
}
