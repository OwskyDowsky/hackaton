@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">🎙️ Bienvenido al CuentaCuentos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('cuentacuentos.start') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg">
            Iniciar Aventura ✨
        </button>
    </form>

    <form method="POST" action="{{ route('cuentacuentos.stop') }}" class="d-inline ms-2">
        @csrf
        <button type="submit" class="btn btn-danger btn-lg">
            Detener Narrador 🛑
        </button>
    </form>
    @php
    $avancePath = storage_path('app/avance.txt');
    $avance = file_exists($avancePath) ? file_get_contents($avancePath) : 0;
@endphp

<div class="mt-4">
    <h4>Avance actual: {{ $avance }}%</h4>
    <div class="progress" style="height: 25px;">
        <div class="progress-bar" role="progressbar" style="width: {{ $avance }}%;" aria-valuenow="{{ $avance }}" aria-valuemin="0" aria-valuemax="100">
            {{ $avance }}%
        </div>
    </div>
</div>

</div>
@endsection
