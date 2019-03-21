<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ISBN', 'publication_year', 'publisher', 'subscription_status', 'image'
    ];

    //when you call users() from a Book object, should it return all the Users that EVER subscribed to the User
    public function users(){
        return $this->hasMany(User::class);
    }

    //a book can have many subscription
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    public function hasSubscriptions(){
        return !empty($this->subscriptions->items);
    }

    //a Book can have max 1 user subscribed to it at a time
    public function currentSubscriberID(){
        //TODO use subscription_status field in the table?
        $latest_sub = $this->subscriptions()->get()->last();
        if(is_null($latest_sub)) return null;
        return $latest_sub->user_id;
    }


    //get the authors of the book
    public function authors(){
        return $this->belongsToMany(Author::class, 'book_authors')->withTimestamps();
    }

    //get the comments of the book
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
