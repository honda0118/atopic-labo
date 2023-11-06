<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HTTP_Response;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * 初期化
     * 
     * ポリシーを使用してアクセスを制御する
     * 
     * @access public
     */
    public function __construct()
    {
        $this->authorizeResource(Favorite::class, 'favorite');
    }

    /**
     * お気に入りを保存、削除する
     * 
     * @access public
     * @param  Request $request
     * @param  Product $product
     * @return JsonResponse
     */
    public function switch(Request $request, Product $product): JsonResponse
    {
        $user = $request->user();
        $fetchedProduct = $user->favorites()->find($product->id);

        if (is_null($fetchedProduct)) {
            $user->favorites()->attach($product->id);
            return response()->json('', HTTP_Response::HTTP_CREATED);
        }

        $user->favorites()->detach($product->id);
        return response()->json('', HTTP_Response::HTTP_NO_CONTENT);
    }
}
