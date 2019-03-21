<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      // 'book_id', 'user_id'
    ]; // TODO book_id and user_id should not be fillable right?


    public function user(){
      return $this->belongsTo(User::class);
    }

    public function book(){
      return $this->belongsTo(Book::class);
    }
}
