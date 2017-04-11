<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Response;

class ArticlesController extends Controller
{
  public function index()
  {


  }
    //
  public function store(Request $request)
  {
    $article = new Article;
    $article->title = $request->input('title');
    $article->body = $request->input('body');


    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $article->image = $request->root()."/storage/".$imageName;

    $article->save();



    return Response::json(["success" => "You did it."]);




  }
  public function update($id, Request $request)
  {

  }
  public function show($id)
  {

  }
  public function destroy($id)
  {

  }


}
