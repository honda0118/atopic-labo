<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Review;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewController extends Controller
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
        $this->authorizeResource(Review::class, 'review');
    }

    /**
     * クチコミ一覧を表示する
     *
     * @access public
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products = $request->user()
            ->reviews()
            ->with(['productImages', 'brand'])
            ->get();

        return Inertia::render('Review/Index', ['products' => $products]);
    }

    /**
     * クチコミ投稿フォームを表示する
     *
     * @access public
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Review/Create', [
            'product' => Product::findOrFail($request->product_id)
        ]);
    }

    /**
     * クチコミを保存する
     *
     * @access public
     * @param  ReviewStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ReviewStoreRequest $request): RedirectResponse
    {
        // 商品が削除されている場合がある
        Product::findOrFail($request->product_id);

        $request->user()
            ->reviews()
            ->attach($request->product_id, ['text' => $request->text, 'score' => $request->score]);

        return redirect(route('products.show', ['product' => $request->product_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * クチコミ編集フォームを表示する
     *
     * @access public
     * @param  Request $request
     * @param  Review $review
     * @return Response
     */
    public function edit(Request $request, Review $review): Response
    {
        return Inertia::render('Review/Edit', [
            'product' => $request->user()->reviews()->find($review->product_id),
        ]);
    }

    /**
     * クチコミを更新する
     * 
     * @access public
     * @param  ReviewUpdateRequest $request
     * @param  Review $review
     * @return RedirectResponse
     */
    public function update(ReviewUpdateRequest $request, Review $review): RedirectResponse
    {
        $request->user()->reviews()->updateExistingPivot($review->product_id, ['text' => $request->text, 'score' => $request->score]);

        return redirect(RouteServiceProvider::HOME)
            ->with('message', 'クチコミを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
