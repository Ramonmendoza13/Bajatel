@extends('plantilla')

@section('title', 'Test JSON')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">JSON recibido</h2>
    <pre class="bg-light p-3 border rounded" style="font-size:1rem;">{{ json_encode($jsonTarifa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection