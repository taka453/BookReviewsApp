@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="">
        <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-center">お疲れ様でした!!</h1>

        <div class="row justify-content-center container">
        <div class="col-md-10">
            <form method="POST" action="{{route('review')}}">
                @csrf
                <div class="card">
                    <div class="card-body text-center">
                        <div class="form-group">
                            <textarea name="review" id="" cols="100" rows="10" placeholder="ここに感想を記入してください"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="感想を登録する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
