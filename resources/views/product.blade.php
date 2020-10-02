@extends('layouts.app')

@section('content')

@section('css')
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
@endsection

@auth
<div class="container-fluid mt-3">
    <div class="mx-auto" style="max-width: 1200px">
        @foreach($products as $product)
            @if(Auth::id() === $product->user_id)
            @if($product->comment === null)
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin: 0 auto">
                    <div class="card mb">
                        <div class="card-body d-flex flex-row flex-wrap">
                            <div class="left mr-4">
                                @if(!empty($product->image))
                                    <div class="image-wrapper"><img class="book-image" src="{{ asset('storage/'. $product->image) }}"></div>
                                @else
                                    <div class="image-wrapper"><img class="book-image" src="{{ asset('images/dummy.png') }}"></div>
                                @endif
                            </div>
                            <div class="right">
                                <h3 class="">{{ $product->title }}</h3>
                                <p class="fee">
                                    {{ $product->fee }}円
                                </p>
                                <a class="status btn btn-danger" href="{{ route('review' , ['product' => $product]) }}">未読了</a>
                            </div>

                            <!-- dropdown -->
                            <div class="ml-auto card-text">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <button type="button" class="btn btn-white m-0 p-2">
                                            <img src="images/dropdown.jpeg" alt="">
                                        </button>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('edit', ['product' => $product]) }}">
                                            <i class="fas fa-pen mr-1"></i>積読を更新する
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $product->id }}">
                                            <i class="fas fa-trash-alt mr-1"></i>積読を削除する
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- dropdown -->
                            <!---modal--->
                            <div id="modal-delete-{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                                <span aria-hidden="true">
                                                    <span aria-hidden="true">&times;<span>
                                                </span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('destroy', ['product' => $product]) }}">
                                            @csrf
                                            <div class="modal-body">
                                                {{ $product->title }}を削除します。よろしいですか？
                                            </div>
                                            <div class="modal-footer jusify-content-between">
                                                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                                                <button type="submit" class="btn btn-danger">削除する</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!---modal--->
                        </div>
                    </div>
                </div>
                @endif
            @endif
        @endforeach
    </div>
</div>
<div class="text-center" style="width: 200px; margin: 50px auto;">
    {{ $products->links() }}
</div>
@endauth

@guest
    <div class="wrapper text-center">
        <img class="book_top" src="{{ asset('images/book_top.jpg') }}" style="width: 100%; height: 800px; object-fit: cover">
    </div>
@endguest

@endsection
