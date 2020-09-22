@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-center">お疲れ様でした!!</h1>

        <div class="row justify-content-center container">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ route('read') }}">
                @csrf
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group">
                            <textarea name="comment" id="" cols="100" rows="10" placeholder="ここに感想を記入してください"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="感想を登録する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
