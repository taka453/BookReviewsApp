@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
        <h1 class='pagetitle text-center'>本を登録</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center container">
            <div class="col-md-10">
                <h1>本を検索してください</h1>
                <form action="/create" method="get">
                    書籍名:<input type="text" name="keyword" size="50" value="{{ $keyword }}">&nbsp;<input type="submit" value="検索">
                </form>
                <br>
                <form method='POST' action="{{route('store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            @foreach((array) $items as $item)
                            <div class="form-group">
                                <label>タイトル</label>
                                <input type="text" class="form-control" name="title" value="{{ $item['volumeInfo']['title'] }}" placeholder="タイトルを入力">
                            </div>
                            <div class="form-group">
                                <label>金額</label>
                                <input type="text" class="form-control" name="fee" placeholder="金額を入力">
                            </div>
                            <div class="form-group">
                                <img src="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}">
                                <label for="file1">本のサムネイル</label>
                                <input type="file" id="file1" name="image" class="form-control-file" value="{{ $item['volumeInfo']['imageLinks']['thumbnail']}}">
                            </div>
                            <input type="submit" class="btn btn-primary" value="積読を登録する">
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection
