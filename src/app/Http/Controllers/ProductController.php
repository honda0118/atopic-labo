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
            'brands' => Brand::orderBy('name_katakana')->get(),
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
     * 商品編集フォームを表示する
     *
     * @access public
     * @param  Product $product
     * @return Response
     */
    public function edit(Product $product): Response
    {
        $product->productImages;

        return Inertia::render('Product/Edit', [
            'product' => $product,
            'brands' => Brand::orderBy('name_katakana')->get(),
            'categories' => Category::all()
        ]);
    }

    /**
     * 商品を更新する
     *
     * @access public
     * @param  ProductUpdateRequest $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        DB::transaction(function () use ($request, $product) {
            $product->fill([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price_including_tax' => $request->price_including_tax,
                'released_at' => $request->released_at,
            ])->save();

            $imagesToSave = [];

            if ($request->image1) {
                if (isset($product->productImages[0])) {
                    $product->productImages[0]->delete();
                    StorageService::delete(StorageService::PRODUCT_DIRECTORY, $product->productImages[0]->image);
                }
                $imagesToSave[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image1)];
            }

            if ($request->image2) {
                if (isset($product->productImages[1])) {
                    $product->productImages[1]->delete();
                    StorageService::delete(StorageService::PRODUCT_DIRECTORY, $product->productImages[1]->image);
                }
                $imagesToSave[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image2)];
            }

            if ($request->image3) {
                if (isset($product->productImages[2])) {
                    $product->productImages[2]->delete();
                    StorageService::delete(StorageService::PRODUCT_DIRECTORY, $product->productImages[2]->image);
                }
                $imagesToSave[] = ['image' => StorageService::putFile(StorageService::PRODUCT_DIRECTORY, $request->image3)];
            }

            if (!empty($imagesToSave)) {
                $product->productImages()->createMany($imagesToSave);
            }
        });

        return redirect(RouteServiceProvider::HOME)
            ->with('message', '商品を更新しました');
    }

    /**
     * 商品を削除する
     *
     * @access public
     * @param  Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $productImages = $product->productImages;

        // 商品を削除後に商品画像を削除する
        $product->delete();

        foreach ($productImages as $productImage) {
            StorageService::delete(StorageService::PRODUCT_DIRECTORY, $productImage->image);
        }
        return back();
    }
}
