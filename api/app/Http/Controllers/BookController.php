<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Favourite;
use App\Models\Like;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        //
        $books = Book::withCount('likes')->withCount('comments')->with('favourites')
           ->orderBy('id','desc')
            ->paginate(10);

        $books->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->created_at)->diffForhumans();

        });

        return response( [ 'success'=>$books ], 200 );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreBookRequest  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {

        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre_id = $request->genre_id;

        if ( $book->save() ) {
            return response( [ 'success'=>$book ], 201 );
        }
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateBookRequest  $request
    * @param  \App\Models\Book  $book
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request ) {
        //
        $book = Book::findOrFail( $request->id );
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre_id = $request->genre_id;

        if ( $book->save() ) {
            return response( [ 'success'=>$book ], 201 );
        }

    }

    public function show( $id) {
       $book = Book::findOrFail($id);
       return response( [ 'success'=>$book ], 200 );
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Book  $book
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        //

        $this->deleteBookComments( $id );
        $this->deleteBookFavourites( $id );
        $this->deleteBookLikes( $id );

        //delete the book
        $book = Book::findOrFail( $id );
        if ( $book->delete() ) {

            return response( [ 'success'=>$book ], 200 );
        }
    }

    public function deleteBookComments( $id ) {
        //delete all comments belong to the deleted book
        $comments = Comment::where( 'user_id', $id )->delete();

        return 1;
    }

    public function deleteBookFavourites( $id ) {
        //delete all favourites belong to the deleted book
        $comments = Favourite::where( 'user_id', $id )->delete();

        return 1;
    }

    public function deleteBookLikes( $id ) {
        //delete all likes belong to the deleted book
        $comments = Like::where( 'user_id', $id )->delete();

        return 1;
    }

}
