@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
        <div class="row justify-content-center container">
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
                <div class="text-center" style="background-color: white; margin: 10px auto 0; padding: 20px 0; border: 1px solid #ddd; border-radius: 6px;">
                    <h1>本を検索してください</h1>
                    <form action="/create" method="get">
                        <p style="margin: 5px;">書籍名:</span><input type="text" name="keyword" size="50" value="{{ $keyword }}">&nbsp;<input type="submit" value="検索"></p>
                    </form>
                </div>
                <br>
                <form method='POST' action="{{route('store')}}" enctype="multipart/form-data">
                    @csrf
                    @foreach((array) $items as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>タイトル</label>
                                <input type="text" class="form-control" name="title" value="{{ $item['volumeInfo']['title'] }}" placeholder="タイトルを入力">
                            </div>
                            <div class="form-group">
                                <label>金額</label>
                                <input type="text" class="form-control" name="fee" placeholder="金額を入力">
                            </div>
                            <div class="form-group">
                                <label>本の画像</label>
                                <br>
                                <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}">
                                <br>
                                <label for="file1">本のサムネイル</label>
                                <input type="file" id="file1" name="image" class="form-control-file" src="{{ $item['volumeInfo']['imageLinks']['thumbnail']">
                            </div>
                            <input type="submit" class="btn btn-primary" value="積読を登録する">
                        </div>
                    </div>
                    @endforeach
                </form>
            </div>
    </div>
</div>
@endsection
