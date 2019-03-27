<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;

// The following two import are the exact imports needed for the show() method, please do not change
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;


class BookController extends Controller
{

    public function __construct()
    {
      $this->middleware('user', ['only'=>'create']);
      $this->middleware('admin', ['only'=>'store', 'only'=>'edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Create GET request to use books api
        $request = Request::create('/api/books', 'GET');

        // dispatch request to API
        $response = Route::dispatch($request);

        //decode the response json into arrays (true argument)
        $data = json_decode($response->content(), true);
        
        return view('books.index')->with('books', $data['data']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Http\Requests\BookRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        //and puts the user's ID in it ?

        //new book row
        $book  = new Book();
        $book->name = $request->input('name');
        $book->ISBN = $request->input('ISBN');
        $book->publication_year = $request->input('publication_year');
        $book->publisher = $request->input('publisher');
        $book->image = $request->input('image');
        $book->save();

        //new author row(s)
        $authNames = $request->input('author'); // can be one or many, comma seperated
        $bookTemp = Book::where('ISBN', $request->input('ISBN'))->first();


        $auths = explode(", " , $authNames); //handles multiple auths, or just 1 auth

        foreach($auths as $name) {
            //if author isn't already in table
            if (Author::where('name', 'ILIKE', $name)->exists() != 1) {
                $author = new Author();
                $author->name = $name;
                $author->save();
                //attach new author
                $bookTemp->authors()->attach($author->id);
            }
            else { //attach for many to many with exisitng
                 $authTemp = Author::where('name', $name)->first();
                 $bookTemp->authors()->attach($authTemp->id);
            }
        }
        // Auth::user()->books()->save($book);


        // Book::create($request->all()); //adds row to DB //gets everything on POST (from the books/create page)
        return redirect('books');
    }


    //go to an book from the URL=: /book/{id}
    public function show($id)
    {
      if(!ctype_digit($id)){ // string consists of all digs, thus is an int
        abort(404);
      }

      $request_bookByID = Request::create('/api/books/'.$id, 'GET');
      $response_bookJSON = Route::dispatch($request_bookByID);
      $book_json = json_decode($response_bookJSON->content(), true);

      if($book_json == null) {
        abort(404);
      }
      // Create new book from json decode arrays
      $book = new Book();
      $book->forceFill($book_json['data']);


      // Get associated authors for this book

      $request_bookAuthors = Request::create('/api/books/findauthors/'.$id, 'GET');
      $response_authorsJSON = Route::dispatch($request_bookAuthors);

      $book_authors = json_decode($response_authorsJSON->content());

      // create authors name array for show.blade

      $auth_names = [];
      foreach($book_authors as $author) {
        array_push($auth_names, $author->name);
      }
      return view('books.show')->with('book', $book)->with('book_authors', $auth_names);
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param string id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        //TODO need consistent use of choosing ', ' or ','
        $authString = implode(', ', $book->authors()->pluck('name')->toArray());
        return view('books.edit', compact('book', 'authString')); // compact() replaces with()
    }

    /**
     * Update the specified resource in storage
     */
    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update([
            'name' => $request->input('name'),
            'publication_year' => $request->input('publication_year'),
            'publisher' => $request->input('publisher'),
            'image' => $request->input('image'),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


        $authNames = $request->input('author');
        $bookTemp = Book::where('ISBN', $request->input('ISBN'))->first();
        //if multiple authors
        $auths = explode(", ", $authNames);
        $auths_to_add = [];
        foreach($auths as $name) {
            //if author isn't already in table, need new one
            if (Author::where('name', 'ILIKE', $name)->exists() != 1) {
                $author = new Author();
                $author->name = $name;
                $author->save();
                //attach new one, but sync to remove and setup anew
                array_push($auths_to_add, $author->id);
                // $bookTemp->authors()->sync($author->id);
            }
            else { //attach for many to many with exisitng if not already attatched
                $authTemp = Author::where('name', 'ILIKE', $name)->first();
                //if(!in_array($authTemp->id, $book->authors()->pluck('id')->toArray())) {
                    //$bookTemp->authors()->sync($authTemp->id);
                array_push($auths_to_add, $authTemp->id);
                //}
            }
        }
        $bookTemp->authors()->sync($auths_to_add);


        return redirect('books');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book =Book::findOrFail($id);
        if($book->authors->count() == 1) { //if author only had one book, delete author too
            $book->authors()->delete();
        }
        $book->delete();
        return redirect('books')->with('message', 'Book Deleted.');;
    }

    //For subscriber type users to subscribe to a book
    public function subscribe($book_id){
      $book = Book::findOrFail($book_id);
      if(empty($book->subscription_status)){
        $book->update([
            'subscription_status' => Auth::user()->id,
        ]);
        if(!(Subscription::where([['book_id','=',$book_id],['user_id','=',Auth::user()->id]])->exists())){
          $subscription = new Subscription();
          $subscription->book_id = $book_id;
          $subscription->user_id = Auth::user()->id;
          $subscription->save();
        }
        return redirect()->route('books.show',$book_id);
      }
      else{
        //TODO return error
      }
    }

    //For subscriber type users to unbscribe from a book
    public function unsubscribe($book_id){
      $book = Book::findOrFail($book_id);
      $book->update([
          'subscription_status' => null,
      ]);
      return redirect()->route('books.show',$book_id);

    }

    public function showImg($id) {

      if(!ctype_digit($id)){ // string consists of all digs, thus is an int
          abort(404);
      }

      $request_image = Request::create('/api/books/'.$id.'/image', 'GET');
      $response_image = Route::dispatch($request_image);

        return view('books.image')->with('image_src',$response_image->content());
    }

    public function showISBN($isbn) {

       if(!ctype_digit($isbn)){ // string consists of all digs, thus is an int
          abort(404);
       }
      $request_bookByISBN = Request::create('/api/books/isbn/'.$isbn, 'GET');

      $response_bookJSON = Route::dispatch($request_bookByISBN);
      // dd($response_bookJSON);
      $book_json = json_decode($response_bookJSON->content(), true);

      if($book_json == null) {
        abort(404);
      }
      // dd($book_json);
      // Create new book from json decode arrays
      $book = new Book();
      $book->forceFill($book_json['data']);


      // Get associated authors for this book

      $request_bookAuthors = Request::create('/api/books/findauthors/'.$book->id, 'GET');
      $response_authorsJSON = Route::dispatch($request_bookAuthors);

      $book_authors = json_decode($response_authorsJSON->content());

      // create authors name array for show.blade

      $auth_names = [];
      foreach($book_authors as $author) {
        array_push($auth_names, $author->name);
      }
      return view('books.show')->with('book', $book)->with('book_authors', $auth_names);
    }
}
