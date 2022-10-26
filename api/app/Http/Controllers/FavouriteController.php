<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $favourites = Favourite::get();
        return $favourites;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFavouriteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $favourite = new Favourite;
        $favourite->user_id = $request->user_id;
        $favourite->book_id = $request->book_id;
        
        if($favourite->save()){
            return response(["success"=>$favourite], 201);
        };
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $bid)
    {
        //
        $favourite = Favourite::where('user_id', $uid)->where('book_id', $bid);
        if($favourite->delete()){
            return response(["success"=>$favourite], 201);
        }
    }
}
