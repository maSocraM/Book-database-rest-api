<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 23/09/18
 * Time: 03:04
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Publisher
 *
 * Model class to connect Eloquent ORM with publishers table
 *
 * @package App
 */
class Publisher extends Model
{

    // Activate softdelete facility
    use SoftDeletes;

    // used by softdeletes, protect the edition by outsiders
    protected $dates = ['deleted_at'];

    // fields that can be fillable
    protected $fillable = [
      'name'
    ];

}