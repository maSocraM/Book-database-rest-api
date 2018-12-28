<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 24/09/18
 * Time: 23:39
 * 
 * Reference: https://www.easylaravelbook.com/blog/introducing-laravel-many-to-many-relations/
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Author
 *
 * Model class to connect Eloquent ORM with authors table
 *
 * @package App
 */
class Author extends Model
{
    // Activate softdelete facility
    use SoftDeletes;

    // used by softdeletes, protect the edition by outsiders
    protected $dates = ['deleted_at'];

    // activate the pivot table author_book
    protected $hidden = ['pivot'];

    // fields that can be fillable
    protected $fillable = [
        'name',
        'last_name',
        'editorial_name',
        'link'
    ];

    /**
     * Activates the many-to-many relationship (pivot) table (author_book) with books table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books() {
        return $this->belongsToMany('App\Book')->withTimestamps();
    }
    
}