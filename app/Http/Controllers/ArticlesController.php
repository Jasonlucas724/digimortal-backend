<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Response;
use Illuminate\Support\Facades\Validator;
use Purifier;

class ArticlesController extends Controller
{
  public function index()
  {
    $articles = Article::all();

    return Response::json($articles);
  }



    //
  public function store(Request $request)
  {
    $rules =[
      'title' => 'required',
      'body' => 'required',
      'image' => 'required'
    ];

   $validator = Validator::make(Purifier::clean($request->all()), $rules);

   if($validator ->fails())
   {
    return Response::json(["error" => "You need to fill out all fields"]);
   }


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
  //Finds a specific Article based on id
  public function update($id, Request $request)
  {
    //Saves the title.
    $article= Article::find($id);
    //Saves the title.
    $article->title = $request->input('title');
    //Saves the body.
    $article->title = $request->input('body');

    //Moves image to the server and saves the image url to the DB.
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $image->move("storage/", $imageName);
    $article->image = $request->root()."/storage/".$imageName;

    //Commits the saves to the database.
    $article->save();

    //Sends a message back to the front end.
    return Response::json(["success" => "Article Updated."]);
  }


  public function show($id)
  {
    $article = Article::find($id);

    return Response::json($article);

  }
  public function destroy($id)
  {
    $article = Article::find($id);

    $article->delete();

    return Response::json(['success' => 'Deleted Article.']);

  }


}
