<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
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
            'asideBrands' => Brand::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
            'asideCategories' => Category::orderByRaw('`order` IS NULL ASC')->orderBy('order')->limit(3)->get(),
            'brands' => Brand::orderBy('katakana')->get(),
        ]);
    }
}
