@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="mx-auto" style="max: 1200px">
        <h1 style="color: #555555; text-align: center; font-size: 1.2em; padding: 24px 0px; font-weight: bold; padding: 24px 0px;">
        @foreach($products as $product)
        <div class="col-xs-6 col-sm-6 col-md-6" style="margin: 0 auto">
            <div class="card mb">
                <div class="card-body d-flex flex-row flex-wrap">
                    <div class="left">
                        @if(!empty($product->image))
                            <div class="image-wrapper"><img class="book-image" src="{{ asset('storage/'.$product->image) }}"></div>
                        @else
                            <div class="image-wrapper"><img class="book-image" src="{{ asset('images/dummy.png') }}"></div>
                        @endif
                    </div>
                    <div class="right">
                        <h3 class="">{{ $product->title }}</h3>
                        <p class="price">
                            {{ $product->fee }}円
                        </p>
                        <p class="comment">
                            {{ $product->comment }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
