@extends('layouts.app')

@section('title', 'Katalog')

@section('content')
<h2 class="mb-4">Katalog Produk</h2>

<div class="row">
    @for($i = 1; $i <= 6; $i++)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">

            <img src="https://via.placeholder.com/300x200" class="card-img-top">

            <div class="card-body">
                <h5 class="card-title">Produk {{ $i }}</h5>
                <p class="card-text">Deskripsi produk {{ $i }}</p>
            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary btn-sm">Detail</button>
            </div>

        </div>
    </div>
    @endfor
</div>
@endsection