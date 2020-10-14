@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mx-auto" style="max-width:1200px;">
        <div class="row justify-content-center container" style="width: 650px; margin:0 auto;">
            <div class="col-md-10" style="margin-top: 60px;">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method='POST' action="{{route('store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group" style="padding: 5px">
                                <label>タイトル</label>
                                <input type="text" class="form-control" name="title" placeholder="タイトルを入力">
                            </div>
                            <div class="form-group" style="padding: 5px">
                                <label>金額</label>
                                <input type="text" class="form-control" name="fee" placeholder="金額を入力">
                            </div>
                            <div class="form-group" style="padding: 5px">
                                <label>画像のアップロード</label>
                                <br>
                                <label for="file1">本のサムネイル</label>
                                <input type="file" id="file1" name="image" class="form-control-file">
                            </div>
                            <div style="padding: 5px">
                                <input type="submit" class="btn btn-primary" value="積読を登録する">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
