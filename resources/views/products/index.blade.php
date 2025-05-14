@extends('layouts.app')

@section('content')
    <h1>Produtos</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Variações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                    <td>
                        @foreach ($product->variations as $variation)
                            <div>
                                {{ $variation->variation_name }}
                                ({{ $variation->stock }} em estoque)
                                @if($variation->price_override)
                                    - R$ {{ number_format($variation->price_override, 2, ',', '.') }}
                                @endif
                            </div>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                        <form action="{{ route('cart.add', $product) }}" method="POST" style="display:inline-flex; gap: 4px;">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" style="width: 60px;" class="form-control form-control-sm">
                            <button class="btn btn-sm btn-success">Comprar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Novo Produto</a>
@endsection
