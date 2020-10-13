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

        $items = null;

        $data = [];
        $products = Product::where('status', 1)->where('user_id', $user_id)->whereNull('comment')->orderBy('created_at', 'DESC')->paginate(3);
        foreach($products as $product) {
            $item = $product->api_id;
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $item . '&country=JP&tbm=bks';
            $client = new Client;
            $response = $client->request("GET", $url);
            $body = $response->getBody();
            $bodyArray = json_decode($body, true);
            $items = $bodyArray['items'];
        }

        $data = [
            'products' => $products,
            'items' => $items,
        ];

        return view('product',
        [
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        //-----API記述-----//
        $data = [];
        $items = null;

        if(!empty($request->keyword))
        {
            $title = urlencode($request->keyword);
            $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $title . '&maxResults=1&country=JP&tbm=bks';
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
            'fee' => 'required',
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
        return view('edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'title' => 'required|max: 255',
            'fee' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

            $product = Product::find($validatedData['id']);
            $product->title = $validatedData['title'];
            $product->fee = $validatedData['fee'];

            if($request->hasFile($validatedData['image'])) {
                Storage::delete('/public/' . $product->image);
                $path = $request->file('image')->store('images', ['disk' => 'public']);
                $product->save($path);
            }

            $product->save();

            return redirect('/');
    }
    public function editRead(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        return view('editRead', compact('product'));
    }

    public function updateRead(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'title' => 'required|max: 255',
            'fee' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'comment' => 'required|max: 500',
        ]);

            // $path = $request->file('image')->store('images', ['disk' => 'public']);

            $product = Product::find($validatedData['id']);
            $product->title = $validatedData['title'];
            $product->fee = $validatedData['fee'];
            $product->comment = $validatedData['comment'];

            if($request->hasFile($validatedData['image'])) {
                Storage::delete('/public/' . $product->image);
                $path = $request->file('image')->store('images', ['disk' => 'public']);
                $product->save($path);
            }

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
        return view('read', compact('products'));
    }

    public function destroy(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        Storage::delete('/public/' . $product->image);
        $product->delete();
        return redirect('/');
    }

    public function destroyRead(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        Storage::delete('/public/' . $product->image);
        $product->delete();
        return redirect('/read');
    }

    public function show(Product $product)
    {
        $user_id = Auth::id();
        $sum = Product::all()->where('user_id', $user_id)->whereNull('comment')->sum('fee');
        return view('show', compact('sum'));
    }
}
