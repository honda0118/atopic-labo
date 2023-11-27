<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Collections\Products;

class IndexController extends Controller
{
    /**
     * 新着商品一覧を表示する
     *
     * @access public
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = Product::with(['productImages', 'brand', 'category', 'reviews'])
            ->selectRaw('*, FORMAT(price_including_tax, 0) as price_including_tax')
            ->orderBy('id', 'desc')
            ->paginate(10);

        $products = new Products($products);

        // インデックスページのみ、メインビジュアルを表示する
        $isIndexPage = false;
        if (is_null($request->page)) {
            $isIndexPage = true;
        }

        return Inertia::render('Index', [
            'isIndexPage' => $isIndexPage,
            'brands' => Brand::orderBy('view_count', 'desc')->limit(3)->get(),
            'categories' => Category::orderBy('view_count', 'desc')->limit(3)->get(),
            'heading' => '新着商品',
            'products' => $products->getProducts(),
            'title' => '敏感肌、アトピー肌向け商品クチコミサイト',
        ]);
    }
}
