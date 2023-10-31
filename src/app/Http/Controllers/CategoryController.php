<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Services\Products;
use Inertia\Response;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * カテゴリー一覧を表示する
     *
     * @access public
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Category/Index', [
            'asideBrands' => Brand::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
            'asideCategories' => Category::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * カテゴリー別商品一覧を表示する
     *
     * @access public
     * @param int $category_id
     * @return Response|RedirectResponse
     */
    public function showProductsByCategory(Category $category)
    {
        $products = Product::with(['productImages', 'brand', 'category'])
            ->where('category_id', $category->id)
            ->selectRaw('*, FORMAT(price_including_tax, 0) as price_including_tax')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // 商品がなければインデックスページにリダイレクトする
        if (!$products->count()) {
            return redirect('/');
        }
        $products = new Products($products);

        return Inertia::render('Index', [
            'title' => $category->name,
            'heading' => $category->name,
            'products' => $products->getProducts(),
            'brands' => Brand::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
            'categories' => Category::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
        ]);
    }
}
