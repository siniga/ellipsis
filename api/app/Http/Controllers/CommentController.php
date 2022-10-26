<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        //
        $comments = Comment::join( 'users', 'users.id', 'comments.user_id' )
        ->select( 'users.name as user_name', 'comments.body' )
        ->orderBy( 'comments.id', 'desc' )
        ->get();
        return response( [ 'success'=>$comments ], 200 );
    }

    public function getBookComments($id) {
        $comments = Comment::join( 'users', 'users.id', 'comments.user_id' )
        ->select( 'users.name as user_name', 'comments.body' )
        ->orderBy( 'comments.id', 'desc' )
        ->where('comments.book_id', $id)
        ->get();
        return response( [ 'success'=>$comments ], 200 );
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreCommentRequest  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        //
        $comment = new Comment;
        $comment->user_id = $request->user_id;
        $comment->book_id = $request->book_id;
        $comment->body = $request->body;

        if ( $comment->save() ) {
            return response( [ 'success'=>$comment ], 201 );
        }
        ;
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Comment  $comment
    * @return \Illuminate\Http\Response
    */

    public function show( Comment $comment ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Comment  $comment
    * @return \Illuminate\Http\Response
    */

    public function edit( Comment $comment ) {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateCommentRequest  $request
    * @param  \App\Models\Comment  $comment
    * @return \Illuminate\Http\Response
    */

    public function update( UpdateCommentRequest $request, Comment $comment ) {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Comment  $comment
    * @return \Illuminate\Http\Response
    */

    public function destroy( $uid, $bid ) {

        $comment = Comment::where( 'user_id', $uid )->where( 'book_id', $bid )->delete();

        return $comment;
        if ( $comment ) {
            return response( [ 'success'=>'deleted' ], 201 );
        }

    }
}
