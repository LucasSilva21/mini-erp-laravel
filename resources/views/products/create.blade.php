@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Novo Produto</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nome do Produto</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <h4>Variações</h4>
        <div id="variations-wrapper">
            <div class="variation-item mb-3 border p-3 rounded">
                <input type="text" name="variations[0][variation_name]" class="form-control" placeholder="Nome da variação">
                <input type="number" name="variations[0][stock]" class="form-control mb-2" placeholder="Estoque" required>
                <input type="number" step="0.01" name="variations[0][price_override]" class="form-control" placeholder="Preço (opcional)">
            </div>
        </div>

        <button type="button" class="btn btn-secondary mt-2" onclick="addVariation()">+ Adicionar Variação</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Salvar Produto</button>
        </div>
    </form>
</div>

<script>
    let index = 1;
    function addVariation() {
        const wrapper = document.getElementById('variations-wrapper');
        const html = `
            <div class="variation-item mb-3 border p-3 rounded">
                <input type="text" name="variations[${index}][name]" class="form-control mb-2" placeholder="Nome da variação" required>
                <input type="number" name="variations[${index}][stock]" class="form-control mb-2" placeholder="Estoque" required>
                <input type="number" step="0.01" name="variations[${index}][price_override]" class="form-control" placeholder="Preço (opcional)">
            </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        index++;
    }
</script>
@endsection
