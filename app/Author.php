<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    protected $table = 'authors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    //get the author's books
    public function books(){
        return $this->belongsToMany(Book::class, 'book_authors')->withTimestamps();
    }
}
