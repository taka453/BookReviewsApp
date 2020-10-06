@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
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
                <form method='POST' action="{{route('update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>タイトル</label>
                                <input type="text" class="form-control" value="{{ $product->title }}" name="title">
                            </div>
                            <div class="form-group">
                                <label>金額</label>
                                <input type="text" class="form-control" value="{{ $product->fee }}" name="fee">
                            </div>
                            <div class="form-group">
                                <label for="file1">再度画像を選択してください</label>
                                <input type="file" id="file1" name="image" class="form-control-file">
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="submit" class="btn btn-primary" value="更新する">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
