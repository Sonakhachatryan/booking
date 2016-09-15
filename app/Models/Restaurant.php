<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ImageRestaurant;

class Restaurant extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurants';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'address',
        'latitude',
        'longitude',
        'country_id',
        'city_id',
        'phone',
        'working_hours',
        'admin_id'
    ];
   
    protected $dates = ['deleted_at'];

    /**
     * @return array
     */
}
