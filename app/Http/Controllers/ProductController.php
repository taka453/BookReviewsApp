<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//Clientクラスを使用
use GuzzleHttp\Client;

class ProductController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $item = null;
        $data = [];

        $products = Product::where('status', 1)->where('user_id', $user_id)->whereNull('comment')->orderBy('created_at', 'DESC')->paginate(3);
        foreach($products as $product) {
            $item = $product->api_id;
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $item . '&country=JP&tbm=bks';
            $client = new Client;
            $response = $client->request("GET", $url);
            $body = $response->getBody();
            $bodyArray = json_decode($body, true);
            $item = $bodyArray['items'];
            // dd($item);
            $product['title'] = $item[0]['volumeInfo']['title'];
            $product['image'] = $item[0]['volumeInfo']['imageLinks']['thumbnail'];
            //product fee title id imageLink productにimageを追加 itemsにidで分ける productのimageLink

            // dd($products);
        }
        return view('product', compact('products'));
    }

    public function create(Request $request)
    {
        //-----API記述-----//
        $data = [];
        $items = null;

        if(!empty($request->keyword))
        {
            $title = urlencode($request->keyword);
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $title . '&country=JP&tbm=bks';
            $client = new Client;
            $response = $client->request("GET", $url);
            $body = $response->getBody();
            $bodyArray = json_decode($body, true);
            $items = $bodyArray['items'];
        }

        $data = [
            'items' => $items,
            'keyword' => $request->keyword,
        ];

        // dd($items);
        // AX63DwAAQBAJ
        return view('create', $data);
        //---------------//
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'api_id' => 'required',
            'fee' => 'required | integer | min:0',
        ]);

        $data = [
            'user_id' => \Auth::id(),
            'api_id' => $validatedData['api_id'],
            'fee' => $validatedData['fee'],
        ];

        Product::insert($data);
        return redirect('/');


    }

    public function edit(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        $item = $product->api_id;
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $item . '&country=JP&tbm=bks';
        $client = new Client;
        $response = $client->request("GET", $url);
        $body = $response->getBody();
        $bodyArray = json_decode($body, true);
        $item = $bodyArray['items'];
        $product['title'] = $item[0]['volumeInfo']['title'];
        $product['image'] = $item[0]['volumeInfo']['imageLinks']['thumbnail'];
        return view('edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'fee' => 'required | integer | min:0',
        ]);

        $product = Product::find($validatedData['id']);
        $product->fee = $validatedData['fee'];

        $product->save();
        return redirect('/');
    }
    public function editRead(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        $item = $product->api_id;
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $item . '&country=JP&tbm=bks';
        $client = new Client;
        $response = $client->request("GET", $url);
        $body = $response->getBody();
        $bodyArray = json_decode($body, true);
        $item = $bodyArray['items'];
        $product['title'] = $item[0]['volumeInfo']['title'];
        $product['image'] = $item[0]['volumeInfo']['imageLinks']['thumbnail'];
        return view('editRead', compact('product'));
    }

    public function updateRead(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'fee' => 'required | integer | min:0',
            'comment' => 'required|max: 500',
        ]);

        $product = Product::find($validatedData['id']);
        $product->fee = $validatedData['fee'];
        $product->comment = $validatedData['comment'];
        $product->save();
        return redirect('/read');
    }

    public function review(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        return view('review', compact('product'));
    }

    public function updateComment(Request $request, Product $product)
    {
        // dd($request->all());
        // throw new \Exception('test');

        $validatedData = $request->validate([
            'id' => 'required',
            'comment' => 'required|max: 500',
        ]);

        $product = Product::find($validatedData['id']);
        $product->comment = $validatedData['comment'];
        $product->save();

        return redirect('/read');
    }

    public function read()
    {
        $user_id = Auth::id();
        $products = Product::where('user_id', 1)->where('user_id', $user_id)->whereNotNull ('comment')->orderBy('updated_at', 'DESC')->paginate(3);
        foreach($products as $product) {
            $item = $product->api_id;
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $item . '&country=JP&tbm=bks';
            $client = new Client;
            $response = $client->request("GET", $url);
            $body = $response->getBody();
            $bodyArray = json_decode($body, true);
            $item = $bodyArray['items'];
            // dd($item);
            $product['title'] = $item[0]['volumeInfo']['title'];
            $product['image'] = $item[0]['volumeInfo']['imageLinks']['thumbnail'];
        }
        return view('read', compact('products'));
    }

    public function destroy(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        $product->delete();
        return redirect('/');
    }

    public function destroyRead(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        $product->delete();
        return redirect('/read');
    }

    public function show(Product $product)
    {
        $user_id = Auth::id();
        $sum = DB::table('products')->where('user_id', $user_id)->whereNull('comment')->sum('fee');
        return view('show', compact('sum'));
    }
}
