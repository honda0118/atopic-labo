<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Services\StorageService;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * 初期化
     * 
     * ポリシーでアクセスを制御する
     * 
     * @access public
     */
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * 投稿商品一覧を表示する
     *
     * @access public
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = Product::with(['productImages', 'brand', 'category'])
            ->where('user_id', $request->user()->id)
            ->selectRaw('*, FORMAT(price_including_tax, 0) as price_including_tax')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Product/Index', ['products' => $products]);
    }

    /**
     * 商品投稿フォームを表示する
     *
     * @access public
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Product/Create', [
            'brands' => Brand::orderBy('katakana')->get(),
            'categories' => Category::all()
        ]);
    }

    /**
     * 商品を保存する
     *
     * @access public
     * @param  ProductStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price_including_tax' => $request->price_including_tax,
                'released_at' => $request->released_at,
                'user_id' => $request->user()->id
            ]);

            // 商品画像は必ず1枚ある
            $images = [];
            $images[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image1)];

            if ($request->image2) {
                $images[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image2)];
            }

            if ($request->image3) {
                $images[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image3)];
            }
            $product->productImages()->createMany($images);
            $request->user()->reviews()->attach($product->id, ['text' => $request->text, 'score' => $request->score]);
        });

        return redirect(RouteServiceProvider::HOME)
            ->with('message', '商品を投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductUpdateRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
