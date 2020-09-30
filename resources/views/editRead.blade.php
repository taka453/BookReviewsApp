@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
        <h1 class='pagetitle text-center'>本を更新</h1>

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
            <form method='POST' action="{{route('updateRead')}}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>タイトル</label>
                            <input type="text" class="form-control" name="title" placeholder="タイトルを入力">
                        </div>
                        <div class="form-group">
                            <label>金額</label>
                            <input type="text" class="form-control" name="fee" placeholder="金額を入力">
                        </div>
                        <div class="form-group">
                            <label for="file1">本のサムネイル</label>
                            <input type="file" id="file1" name="image" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <textarea name="comment" id="" cols="100" rows="10" placeholder="ここに感想を記入してください"></textarea>
                        </div>
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="submit" class="btn btn-primary" value="更新する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
