<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $products = Product::where('status', 1)->where('user_id', $user_id)->whereNull('comment')->orderBy('created_at', 'DESC')->paginate(3);
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

            // $path = $request->file('image')->store('images', ['disk' => 'public']);

            $product = Product::find($validatedData['id']);
            $product->title = $validatedData['title'];
            $product->fee = $validatedData['fee'];

            if($request->hasFile($validatedData['image'])) {
                Storage::delete('public/images/' . $product->image);
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
                Storage::delete('public/images/' . $product->image);
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
        $products = Product::where('user_id', 1)->where('user_id', $user_id)->whereNotNull ('comment')->orderBy('created_at', 'DESC')->paginate(3);
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
