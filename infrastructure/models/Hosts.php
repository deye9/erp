<?php

namespace Infrastructure\Models;

use App\Helpers\Uuid;
use Illuminate\Database\Eloquent\Model;

class Hosts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fqdn', 'redirect_to', 'force_https', 'under_maintenance_since', 'website_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->website_id = Uuid::generate(4);
        });
    }
}
