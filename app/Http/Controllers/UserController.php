<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @OA\Get(
     ** path="/api/users",
     *   tags={"Users"},
     *   summary="Все пользователи",
     *   operationId="user.index",
     *   @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="sort_by",
     *      description="fio.desc",
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
        $users = new User;

        if($request->get('sort_by')) {
            $arr = explode('.', $request->get('sort_by'));
            $users = $users->orderBy($arr[0], $arr[1]);
        }

        $users = $users->paginate(5);
        return response()->json(['data'=>$users]);
    }

    /**
     * @OA\Get(
     ** path="/api/users/search",
     *   tags={"Users"},
     *   summary="Поиск пользователей",
     *   operationId="user.search",
     *   @OA\Parameter(
     *      name="query",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="integer",
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="sort_by",
     *      description="fio.desc",
     *      in="query",
     *      required=false,
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
     *)
     **/

    public function search(Request $request)
    {
        $query = $request->get('query');
        $users = new User;

        if($request->get('sort_by')) {
            $arr = explode('.', $request->get('sort_by'));
            $users = $users->orderBy($arr[0], $arr[1]);
        }

        $users = $users->where('FIO','LIKE', "%".$query."%")->paginate(5);
        return response()->json(['data'=>$users]);
    }

    /**
     * @OA\Get(
     ** path="/api/user/{slug}",
     *   tags={"Users"},
     *   summary="Определенный пользователь",
     *   operationId="user.show",
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
     *)
     **/

    public function show($slug)
    {
        $user = User::where('slug', $slug)->first();
        
        if(empty($user)) {
            return response()->json('Not Found', 404);
        }
        return response()->json(['data'=>$user]);
    }
}
