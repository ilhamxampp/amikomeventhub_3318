@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body text-center">

                <img src="https://via.placeholder.com/100" class="rounded-circle mb-3">

                <h4>John Doe</h4>
                <p class="text-muted">john@example.com</p>

                <hr>

                <p><strong>Role:</strong> User</p>
                <p><strong>Bergabung:</strong> 2025</p>

                <button class="btn btn-warning btn-sm">Edit Profil</button>

            </div>
        </div>
    </div>
</div>
@endsection