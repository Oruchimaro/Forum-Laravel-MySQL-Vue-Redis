<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorite;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }


  public function store(Reply $reply)
  {
    //favorite method is on Reply model
    return $reply->favorite();
  }
}
