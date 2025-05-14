@extends('layouts.app')

@section('content')
    <h1>Carrinho</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulário para aplicar cupom --}}
    <form action="{{ route('cart.index') }}" method="GET" class="mb-4">
        <label for="coupon_code">Cupom de Desconto</label>
        <div class="d-flex gap-2">
            <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Digite o cupom" required>
            <button class="btn btn-success">Aplicar</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $productId => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
    <p><strong>Frete:</strong> R$ {{ number_format($frete, 2, ',', '.') }}</p>

    @if(isset($desconto) && $desconto > 0)
        <p><strong>Desconto:</strong> R$ {{ number_format($desconto, 2, ',', '.') }}</p>
    @endif

    <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>

    <hr>

    <h4>Endereço de Entrega</h4>
    <div class="mb-3">
        <label>CEP</label>
        <input type="text" id="cep" class="form-control" maxlength="9" placeholder="00000-000">
    </div>
    <div class="mb-3">
        <label>Rua</label>
        <input type="text" id="rua" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label>Bairro</label>
        <input type="text" id="bairro" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label>Cidade</label>
        <input type="text" id="cidade" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label>UF</label>
        <input type="text" id="uf" class="form-control" readonly>
    </div>

    {{-- Formulário para finalizar pedido --}}
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <input type="hidden" name="cep" id="form-cep">
        <input type="hidden" name="rua" id="form-rua">
        <input type="hidden" name="bairro" id="form-bairro">
        <input type="hidden" name="cidade" id="form-cidade">
        <input type="hidden" name="uf" id="form-uf">

        <button class="btn btn-primary">Finalizar Pedido</button>
    </form>

    <script>
        document.getElementById('cep').addEventListener('blur', function () {
            let cep = this.value.replace(/\D/g, '');

            if (cep.length !== 8) return;

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado!');
                        return;
                    }

                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('uf').value = data.uf;
                })
                .catch(() => alert('Erro ao consultar o CEP.'));
        });

        // Preenche os campos ocultos antes de submeter o pedido
        document.querySelector('form[action="{{ route('orders.store') }}"]').addEventListener('submit', function () {
            document.getElementById('form-cep').value = document.getElementById('cep').value;
            document.getElementById('form-rua').value = document.getElementById('rua').value;
            document.getElementById('form-bairro').value = document.getElementById('bairro').value;
            document.getElementById('form-cidade').value = document.getElementById('cidade').value;
            document.getElementById('form-uf').value = document.getElementById('uf').value;
        });
    </script>
@endsection
