<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    /**
     * @OA\Get(
     ** path="/api/categories",
     *   tags={"Categories"},
     *   summary="Все категории",
     *   operationId="category.index",
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/

    public function index(Request $request)
    {
        $categories = Category::get()->toTree();
        return response()->json(['data'=>$categories]);
    }

    /**
     * @OA\Get(
     ** path="/api/category/{slug}",
     *   tags={"Categories"},
     *   summary="Определенная категория",
     *   operationId="category.show",
     *   @OA\Parameter(
     *      name="slug",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not Found",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if(empty($category)) {
            return response()->json('Not Found', 404);
        }
        
        $category = Category::descendantsAndSelf($category->id)->toTree()->first();
        return response()->json(['data'=>$category]);
    }
}
