@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')
<h2 class="mb-4">Pusat Bantuan</h2>

<div class="accordion" id="faq">

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#item1">
                Cara menggunakan aplikasi?
            </button>
        </h2>
        <div id="item1" class="accordion-collapse collapse show">
            <div class="accordion-body">
                Pilih menu di atas untuk mulai menggunakan fitur aplikasi.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#item2">
                Bagaimana cara menghubungi support?
            </button>
        </h2>
        <div id="item2" class="accordion-collapse collapse">
            <div class="accordion-body">
                Kamu bisa menghubungi kami melalui halaman kontak.
            </div>
        </div>
    </div>

</div>
@endsection