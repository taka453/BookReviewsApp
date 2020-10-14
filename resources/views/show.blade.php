@extends('layouts.app')

@section('content')

@auth
<div class="container-fluid">
    <div class="mt-5 col-md-5" style="margin: 0px auto">
        <div class="card" style="height: 60vh;">
            <div class="card-body">
                <div class="text-center" style="margin-top: 100px;">
                    <p style="font-size: 20px; font-weight: bold;">あなたの積読金額は・・・</p>
                    <p class="text-danger" style="font-size: 40px; font-weight: bold">{{ $sum }}<span style="color: black; margin-left: 20px; font-size: 20px;">円です。</span></p>
                    @if($sum >= 10000)
                        <p style="font-size: 25px; font-weight: bold;">時間を作って、<br>一冊でも解消しよう！！</p>
                    @elseif($sum >= 5000)
                        <p style="font-size: 25px; font-weight: bold;">もっと頑張ろう！！</p>
                    @elseif($sum >= 3000)
                        <p style="font-size: 25px; font-weight: bold;">積読解消まで、<br>もう少し！！</p>
                    @elseif($sum >= 2000)
                        <p style="font-size: 25px; font-weight: bold;">積読解消が見えてきました！</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

@endsection
