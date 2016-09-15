<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageRestaurant extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'image_restaurant';

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
    protected $fillable = ['image_id','restaurant_id'];
}
