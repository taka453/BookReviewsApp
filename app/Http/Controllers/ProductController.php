<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', 1)->orderBy('created_at', 'DESC')->paginate(3);
        return view('product', compact('products'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|max: 255',
            'fee' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('images', ['disk' => 'public']);

            $data = [
                'user_id' => \Auth::id(),
                'title' => $validatedData['title'],
                'fee' => $validatedData['fee'],
                'image' => $path
            ];
        } else {
            $data = ['user_id' => \Auth::id(),
            'title' => $validatedData['title'],
            'fee' => $validatedData['fee']];
        }

        Product::insert($data);

        return redirect('/');
    }

    public function edit(Product $product)
    {
        return view('edit', ['product' => $product]);
    }

    public function review(Request $request, Product $product)
    {
        $products = $request->query('product');
        $product = Product::find($products);
        return view('review', compact('product'));
    }

    public function update(Request $request, Product $product)
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
        $products = Product::where('user_id', 1)->orderBy('created_at', 'DESC')->paginate(3);
        return view('read', compact('products'));
    }
}
