@extends('layouts.app')

@section('content')

@auth
<div class="container-fluid">
    <div class="mt-5 col-md-5" style="margin: 0 auto">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <p style="font-size: 20px; font-weight: bold;">あなたの積読金額は・・・</p>
                    <p class="text-danger" style="font-size: 40px; font-weight: bold">{{ $sum }}<span style="color: black; margin-left: 20px; font-size: 20px;">円です。</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

@endsection
