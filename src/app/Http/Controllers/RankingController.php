<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Services\Products;
use Inertia\Response;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * ランキングを表示する
     *
     * @access public
     * @return Response|RedirectResponse
     */
    public function index()
    {
        $products = Product::with(['productImages', 'brand', 'reviews', 'category'])
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id')
            ->selectRaw('products.*, avg(reviews.score) as avg_score, FORMAT(products.price_including_tax, 0) as price_including_tax')
            ->orderBy('avg_score', 'desc')
            ->limit(10)
            ->get();

        // 商品がなければインデックスページにリダイレクトする
        if (!$products->count()) {
            return redirect('/');
        }
        $products = new Products($products);

        return Inertia::render('Ranking/Index', [
            'brands' => Brand::orderBy('view_count', 'desc')->limit(3)->get(),
            'categories' => Category::orderBy('view_count', 'desc')->limit(3)->get(),
            'heading' => 'クチコミランキング',
            'products' => $products->getProducts(),
            'title' => 'クチコミランキング',
        ]);
    }
}
