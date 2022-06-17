<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/articles",
     *   tags={"Articles"},
     *   summary="Все статьи",
     *   operationId="artice.index",
     *   @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="sort_by",
     *      description="name.desc",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/

    public function index(Request $request)
    {
        $articles = new Article;

        if($request->get('sort_by')) {
            $arr = explode('.', $request->get('sort_by'));
            $articles = $articles->orderBy($arr[0], $arr[1]);
        }

        $articles = $articles->paginate(10);
        return response()->json(['data'=>$articles]);
    }

    /**
     * @OA\Get(
     *  path="/api/articles/search",
     *  tags={"Articles"},
     *  summary="Поиск по статьям",
     *  operationId="article.search",
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="category_id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *  ),
     *   @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *  ),
     *  @OA\Parameter(
     *      name="sort_by",
     *      description="name.desc",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Nor Found",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     *  )
     * )
    **/

    public function search(Request $request)
    {
        $articles = new Article;

        if($request->category_id) {
            $category = Category::find($request->category_id);
            $articles = $category->articles();
        }

        if($request->name) {
            $articles = $articles->whereFullText('name', $request->name);
        }

        if($request->user_id) {
            $articles = $articles->where('user_id', $request->user_id);
        }

        if($request->get('sort_by')) {
            $arr = explode('.', $request->get('sort_by'));
            $articles = $articles->orderBy($arr[0], $arr[1]);
        }

        $articles = $articles->paginate(10);

        if(count($articles)==0) {
            return response()->json('Not Found', 404);
        }

        return response()->json(['data'=>$articles]);
    }

    /**
     * @OA\Get(
     *  path="/api/article/{slug}",
     *  tags={"Articles"},
     *  summary="Определенная статья",
     *  operationId="article.show",
     *  @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Nor Found",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     *  )
     * )
    **/

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        
        if(empty($article)) {
            return response()->json('Not Found', 404);
        }
        return response()->json(['data'=>$article]);
    }
}
