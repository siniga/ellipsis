<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class UserController extends Controller {
    //

    public function index() {
        $users = User::with('roles')->get();
        return response( [ 'success'=>$users ], 200 );
    }

    public function getUserFavouriteBooks($uid){
        $user = User::
        join( 'favourites', 'users.id', 'favourites.user_id' )
        ->join('books','books.id','favourites.book_id')
        // ->select('books.title','books.author','comments.coment')
        ->where( 'users.id', $uid )
        ->get();

        $user->map(function($val, $key){
            $val->time_ago = Carbon::parse($val->created_at)->diffForhumans();

        });

        
        return response( [ 'success'=>$user ], 200 );
    }

    public function isMarkedFavourite( $uid, $bid ) {

        $users = User::join( 'favourites', 'users.id', 'favourites.user_id' )
        ->join('books','books.id','favourites.book_id')
        ->where( 'users.id', $uid )
        ->where( 'books.id', $bid )
        ->exists();

        
        return response( [ 'success'=>$users ], 200 );
    }

    public function getUserLike($uid, $bid){
        $users = User::join( 'likes', 'users.id', 'likes.user_id' )
        ->join('books','books.id','likes.book_id')
        ->where( 'users.id', $uid )
        ->where( 'books.id', $bid )
        ->exists();

        
        return response( [ 'success'=>$users ], 200 );
    }

    public function searchAmbassador( Request $request ) {

        $search = $request->input( 'search' );

        $user = User::query()
        ->join( 'teams', 'teams.id', 'users.team_id' )
        ->select( 'users.name', 'users.email', 'users.phone', 'teams.name as team' )
        ->where( 'users.name', 'LIKE', "%{$search}%" )
        ->orWhere( 'users.phone', 'LIKE', "%{$search}%" )
        ->get();

        return $user;
    }

    public function store( Request $request ) {

        $fields = $request->validate( [
            'name'=>'required|string',
            'email'=>'required|string',
        ] );

        //if edit user flag is true edit user esle create
        if ( $request->edit ) {
            $user = User::findOrFail( $request->id );
            $user->name  = $request->name;
            $user->email = $request->email;

            $this->attachUserToRole( $user->id, $request->role_id );

            if ( $user->save() ) {
                return response( [ 'success'=>$user ], 201 );
            }
        }

        if ( User::where( 'email', '=', $request->email )->exists() ) {
            return response( [ 'error'=>'Email exist, try a different one!' ], 409 );
        }
        //generate random password
        //TODO:send this password to users email for invitation
        $randomNum =  rand( 0, 900000 );

        $user = User::create( [
            'email'=>$fields[ 'email' ],
            'password'=>bcrypt( $randomNum ),
            'name'=>$fields[ 'name' ],
        ] );

        $this->attachUserToRole( $user->id, $request->role_id );

        return response( $user, 200 );

    }

    public function update(Request $request){
        $user = User::findOrFail($request->id);
        $user->email  =  $request->email;
        $user->name = $request->name;
        if($user->save()){
            return response( [ 'success'=>$user ], 201 );
        }
    }
    public function destroy( $uid, $rid ) {

        $user = $this->dettachFromRole( $uid, $rid );
        if ( $user->delete() ) {

            return response( $user, 200 );
        }
    }

    public function dettachFromRole( $uid, $rid ) {

        $user = User::findOrFail( $uid );
        $user->roles()->detach( $rid );

        return $user;
    }

    public function attachUserToRole( $uid, $rid ) {

        $user = User::findOrFail( $uid );

        $user->roles()->syncWithoutDetaching( $rid );

    }
}
