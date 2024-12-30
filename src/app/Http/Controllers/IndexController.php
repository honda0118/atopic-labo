<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Collections\Products;
use GuzzleHttp\Client;

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
        /*
        $client = new Client([
            'base_uri' => 'http://zipcloud.ibsnet.co.jp/api/',
        ]);

        $method = 'GET';
        $uri = 'search?zipcode=131-0045';   // スカイツリーの郵便番号
        $options = [];
        $response = $client->request($method, $uri, $options);

        $list = json_decode($response->getBody()->getContents(), true);
        */

        AZURE_CLIENT_ID = your-azure-client-id;
        AZURE_CLIENT_SECRET=your-azure-client-secret;
        AZURE_TENANT_ID=your-tenant-id AZURE_OAUTH_ENDPOINT= "https://login.microsoftonline.com/YOUR_TENANT_ID/oauth2/v2.0/token";
        $client = new Client();
        $response = $client->post(env('AZURE_OAUTH_ENDPOINT'), ['form_params' => ['grant_type' => 'client_credentials', 'client_id' => env('AZURE_CLIENT_ID'), 'client_secret' => env('AZURE_CLIENT_SECRET'), 'scope' => 'https://graph.microsoft.com/.default',],]);
        $body = json_decode((string) $response->getBody(), true);


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
