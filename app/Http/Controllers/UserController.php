<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Book;
use App\Subscription;

class UserController extends Controller
{

    public function __construct()
    {
      $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderby('id')->get();     //get all users
        return view('users.index')->with('users', $users);
    }

    public function show($id)
    {
        if(!ctype_digit($id)){ // string consists of all digs, thus is an int
            abort(404);
        }

        $user = User::findOrFail($id);
        $current_subscribed_books = [];
          //want to change here: only show list of books that are currently subscribed so not subscribed table
        foreach($user->subscriptions as $subscription) {
            $book = Book::where('id', $subscription->book_id)->get()->first();
            if($user->isCurrentSubscriber($book->id)) {
                array_push($current_subscribed_books, $book);
            }
        }
        return view('users.show', compact('user', 'current_subscribed_books'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param string id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$user = User::findOrFail($id);
        $available_books = [];
        $available_books = Book::whereNull('subscription_status')->orWhere('subscription_status', $id)->orderby('id')->get();
        $current_subscribed_book_ids = [];
        foreach($user->subscriptions as $subscription) {
            $book = Book::where('id', $subscription->book_id)->get()->first();
            if($user->isCurrentSubscriber($book->id)) {
                array_push($current_subscribed_book_ids, $book->id);
            }
        }
    	return view('users.edit', compact('user', 'available_books', 'current_subscribed_book_ids'));

    }

    /**
     * Update the specified resource in storage
     */
    public function update(UserRequest $request, $id)
    {
    	 $user = User::findOrFail($id);
    	 $user->update([
            'role' => $request->input('role'),
            'birthday' => $request->input('birthday'),
            'education_field' => $request->input('education_field'),

            'updated_at' => \Carbon\Carbon::now(),
        ]);

         //returns array of book_ids that are checked off
        $subscriptions =  $request->input('subscriptions');

        //subcribes or unsubscribes user from books based on checkbox values
        $books = Book::whereNull('subscription_status')->orWhere('subscription_status', $id)->get();
        foreach($books as $book){
          if(empty($book->subscription_status) &&  in_array($book->id, $subscriptions)){
            $book->update(['subscription_status' => $id]);
            if(!(Subscription::where([['book_id','=',$book->id],['user_id','=',$id]])->exists())){
              $subscription = new Subscription();
              $subscription->book_id = $book->id;
              $subscription->user_id = $id;
              $subscription->save();
            }
          }
          elseif((!empty($book->subscription_status)) && (!in_array($book->id, $subscriptions))){
              $book->update(['subscription_status' => null]);
          }
        }

        return redirect('users');
    }

}
