<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class LikeController extends Controller
{
    /**
     * 「いいね」を保存、削除する
     * 
     * @access public
     * @param  Request $request
     * @param  Product $product
     * @return JsonResponse
     */
    public function switch(Request $request, Product $product): JsonResponse
    {
        $user = $request->user();
        $fetchedProduct = $user->likes()->find($product->id);

        if ($fetchedProduct) {
            $user->likes()->detach($product->id);
            return response()->json(['likesNumber' => $product->likes()->count()]);
        }

        $user->likes()->attach($product->id);
        return response()->json(['likesNumber' => $product->likes()->count()], Response::HTTP_CREATED);
    }
}
