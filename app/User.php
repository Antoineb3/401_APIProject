<?php

namespace App;

use App\Subscription;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'role', 'birthday', 'education_field', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //when you call books() from a User object, it returns all the Book of the User (subscribed to)
    public function books(){
        return $this->hasMany(Book::class);
    }

    //a user can have many subscription
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    //TODO: may want another function to return all the books that the user has EVER subscribed to?

     //get the comments that the user has made
     public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(){
      return $this->role=='Admin';
    }

    public function isSubscriber(){
      return $this->role=='Subscriber';
    }

    // has the user ever subscribed to book
    public function hasEverSubscribed($book_id)
    {
        $Subscribed = $this->subscriptions()->where('book_id', '=', $book_id)->get();
        return !($Subscribed->isEmpty());
    }

    //is the user currently subscribed to the book
    public function isCurrentSubscriber($book_id)
    {
        $book = Book::findOrFail($book_id);
        return ($this->id == $book->subscription_status);
    }

    public function otherSubscriberExists($book_id){
      $book = Book::findOrFail($book_id);
      return !(empty($book->subscription_status));
    }

  }
