@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mx-auto" style="max-width:1200px;">
        <div class="row justify-content-center container" style="width: 650px; margin:0 auto;">
            <div class="col-md-10" style="margin-top: 5px;">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div style="background-color: white; margin: 0 auto; padding: 20px 0; border: 1px solid #ddd; border-radius: 6px;">
                    <div class="text-center">
                        <form action="/create" method="get">
                            <p style="margin: 5px;">書籍名:</span><input type="text" name="keyword" size="50" value="{{ $keyword }}">&nbsp;<input type="submit" value="検索"></p>
                        </form>
                    </div>
                    <div style="margin-left: 60px;">
                        @if($items === null)
                            <p>書籍名を入力してください</p>
                        @else(count($items) > 0)
                    </div>
                </div>
                <br>
                <form method='POST' action="{{route('store')}}" enctype="multipart/form-data">
                    @csrf
                    @foreach((array) $items as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>タイトル</label>
                                <br>
                                {{ $item['volumeInfo']['title'] }}
                            </div>
                            <div class="form-group">
                                <label>金額</label>
                                <input type="text" class="form-control" name="fee" placeholder="金額を入力">
                            </div>
                            <div class="form-group">
                                <label>本の画像</label>
                                <br>
                                <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}">
                            </div>
                            <input type="hidden" name="api_id" value="{{ $item['id'] }}">
                            <input type="submit" class="btn btn-primary" value="積読を登録する">
                        </div>
                    </div>
                    @endforeach
                </form>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
