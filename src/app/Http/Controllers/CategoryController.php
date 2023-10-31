<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
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
}
