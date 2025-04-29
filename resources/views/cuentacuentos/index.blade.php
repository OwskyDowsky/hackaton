@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">🎙️ Bienvenido al CuentaCuentos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('cuentacuentos.start') }}">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg">
            Iniciar Aventura ✨
        </button>
    </form>
</div>
@endsection
