<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Business;

class AuthController extends Controller {
    //

    public function register( Request $request ) {
        $fields = $request->validate( [
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'name' => 'required:string',
        ] );

        $user = User::create( [
            'email'=>$fields[ 'email' ],
            'password'=>bcrypt( $fields[ 'password' ] ),
            'name' => $fields[ 'name' ],
        ] );

        $this->attachUserToRole( $user->id, $request->role_id );

        $token = $user->createToken( 'elipsis' )->plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response( $response, 201 );
    }

    public function updateUserDetails( Request $request ) {
        $fields = $request->validate( [
            'fullname'=>'required',
            'url'=> 'required',
        ] );

        $user = User::findOrFail( auth()->user()->id );
        $user->fullname = $request->fullname;
        $user->phone = $request->phone;
        $user->url = $request->url;

        if ( $user->save() ) {
            return $response = [
                'user' => $user
            ];
        }

    }

    public function login( Request $request ) {

        //if email is set allow user to login with email
        //otherwise allow user to login with phone number
        if ( isset( $request->email ) ) {
            $fields = $request->validate( [
                'email'=>'required|string',
                'password'=>'required|string'
            ] );

            //check email
            $user = User::where( 'email', $fields[ 'email' ] )
            ->first();
        } else {
            $fields = $request->validate( [
                'phone'=>'required|string',
                'password'=>'required|string'
            ] );

            //check email
            $user = User::where( 'phone', $fields[ 'phone' ] )
            ->first();

        }

        //check password
        if ( !$user || !Hash::check( $fields[ 'password' ], $user->password ) ) {

            return response( [
                'message' => 'Invalid credentials',
            ], 401 );
        }

        $token = $user->createToken( 'ellipsisToken' )->plainTextToken;

        //get user role
        $user = User::join( 'user_roles', 'users.id', 'user_roles.user_id' )
        ->join( 'roles', 'roles.id', 'user_roles.role_id' )
        ->select('users.id','users.name','users.email','roles.name as role', 'roles.id as role_id')
        ->where( 'users.id', $user->id )
        ->first();

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response( $response, 201 );
    }

    public function logout( User $user ) {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function attachUserToRole( $uid, $rid ) {

        $user = User::findOrFail( $uid );

        $user->roles()->syncWithoutDetaching( $rid );

    }
}
