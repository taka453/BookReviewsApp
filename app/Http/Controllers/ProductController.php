<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Read;
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

    public function review()
    {
        $products = Product::where('user_id', 1)->first();
        return view('review', compact('products'));
    }

    public function read(Request $request)
    {
        // dd($request->all());
        // throw new \Exception('test');
        $validatedData = $request->validate([
            'comment' => 'required|max: 500',
        ]);
        $data = ['comment' => $validatedData['comment']];

        Product::update($data);

        $products = Product::where('user_id', 1)->orderBy('created_at', 'DESC')->paginate(3);
        return view('read', compact('products'));
    }
}
