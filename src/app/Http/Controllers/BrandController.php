<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\Products;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * ブランド一覧を表示する
     *
     * @access public
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Brand/Index', [
            'asideBrands' => Brand::orderBy('view_count', 'desc')->limit(3)->get(),
            'asideCategories' => Category::orderBy('view_count', 'desc')->limit(3)->get(),
            'brands' => Brand::orderBy('name_katakana')->get(),
        ]);
    }

    /**
     * ブランド別商品一覧を表示する
     *
     * @access public
     * @param  int $category_id
     * @return Response|RedirectResponse
     */
    public function showProductsByBrand(Brand $brand)
    {
        DB::transaction(function () use ($brand) {
            $newBrand = Brand::lockForUpdate()->find($brand->id);
            $newBrand->view_count++;
            $newBrand->save();
        });

        $products = Product::with(['productImages', 'brand', 'category'])
            ->where('brand_id', $brand->id)
            ->selectRaw('*, FORMAT(price_including_tax, 0) as price_including_tax')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // 商品がなければインデックスページにリダイレクトする
        if (!$products->count()) {
            return redirect('/');
        }
        $products = new Products($products);

        return Inertia::render('Index', [
            'title' => $brand->name,
            'heading' => $brand->name,
            'products' => $products->getProducts(),
            'brands' => Brand::orderBy('view_count', 'desc')->limit(3)->get(),
            'categories' => Category::orderBy('view_count', 'desc')->limit(3)->get(),
        ]);
    }
}
