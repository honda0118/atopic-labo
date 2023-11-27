<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Collections\Products;

class SearchController extends Controller
{
    /**
     * キーワード別商品一覧を表示する
     *
     * @access public
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = Product::with(['productImages', 'brand', 'category'])
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->keyword($request->keyword)
            ->selectRaw('products.*, FORMAT(products.price_including_tax, 0) as price_including_tax')
            ->orderBy('products.id', 'desc')
            ->paginate(10);

        $products = new Products($products);

        return Inertia::render('Index', [
            'brands' => Brand::orderBy('view_count', 'desc')->limit(3)->get(),
            'categories' => Category::orderBy('view_count', 'desc')->limit(3)->get(),
            'heading' => $request->keyword,
            'products' => $products->getProducts()->appends(['keyword' => $request->keyword]),
            'title' => $request->keyword . 'の商品検索結果',
        ]);
    }
}
