@extends('layouts.app')

@section('content')

@auth
    <div class="container-fluid">
        <div class="mt-5 col-md-5" style="margin: 0 auto">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <p style="font-size: 20px; font-weight: bold;">あなたの登録した積読金額の合計は</p>
                        <p class="text-danger" style="font-size: 20px; font-weight: bold">{{ $products }}</p>
                        <p style="font-size: 20px; font-weight: bold;">円です。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endauth

@endsection
