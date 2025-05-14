@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Produto</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="number" name="price" value="{{ $product->price }}" step="0.01" class="form-control">
        </div>

        <h4>Variações</h4>
        @foreach ($product->variations as $i => $variation)
            <div class="variation-item border p-3 mb-3">
                <input type="hidden" name="variations[{{ $i }}][id]" value="{{ $variation->id }}">
                <input type="text" name="variations[{{ $i }}][variation_name]" class="form-control mb-2" value="{{ $variation->variation_name }}" placeholder="Nome da variação">
                <input type="number" name="variations[{{ $i }}][stock]" class="form-control mb-2" value="{{ $variation->stock }}" placeholder="Estoque">
                <input type="number" step="0.01" name="variations[{{ $i }}][price_override]" class="form-control" value="{{ $variation->price_override }}" placeholder="Preço (opcional)">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
    </form>
</div>
@endsection
