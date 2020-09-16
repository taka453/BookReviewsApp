<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\create;
use App\review;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('product_id', 1)->orderBy('created_at', 'DESC')->paginate(3);
        return view('product', compact('products'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $post = $request->all();

        $validatedData = $request->validate([
            'title' => 'required|max: 255',
            'fee' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')) {
            $request->file('image')->store('/public/images');
            $data = ['product_id' => \Auth::id(), 'title' => $post['title'], 'fee' => $post['fee'], 'image' => $request->file('image')->hashName()];
        } else {
            $data = ['product_id' => \Auth::id(), 'title' => $post['title'], 'fee' => $post['fee']];
        }

        Product::insert($data);

        return redirect('/');
    }

    public function review()
    {
        return view('review');
    }
}
