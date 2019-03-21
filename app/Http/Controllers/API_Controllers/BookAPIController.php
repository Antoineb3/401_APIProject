<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Resources\BookResource;

class BookAPIController extends Controller
{
    public function __construct()
    {
        //TODO: this is not doing anything?
      $this->middleware('auth:api')->except(['index', 'show', 'showImg', 'showISBN']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::orderby('id')->get());
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function showImg(Book $book) {
        return response($book->image, 200); //must return a response(), not just a string
    }

    public function showISBN($isbn) {
        $book = Book::where('ISBN', $isbn)->first();
        if ($book == null) {
            abort(404);
        }
        return new BookResource($book); //converts to JSON
    }
}
