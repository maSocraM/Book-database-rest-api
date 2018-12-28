<?php
/**
 * Created by PhpStorm.
 * User: marcos
 * Date: 24/09/18
 * Time: 23:39
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Book
 *
 * Model class to connect Eloquent ORM with books table
 *
 * @package App
 */
class Book extends Model
{

    // Activate softdelete facility
    use SoftDeletes;

    // used by softdeletes, protect the edition by outsiders
    protected $dates = ['deleted_at'];

    // activate the pivot table author_book
    protected $hidden = ['pivot'];

    // fields that can be fillable
    protected $fillable = [
        'title',
        'publish_date',
        'isbn',
        'isbn_thirteen',
        'description',
        'image',
        'highlight'
    ];

    /**
     * Activates the many-to-many relationship (pivot) table (author_book) with authors table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author')->withTimestamps();
    }
}