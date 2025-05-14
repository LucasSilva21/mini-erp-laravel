@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1 class="mb-4">Bem-vindo ao Mini ERP</h1>
        <p class="lead">Controle simples e eficiente de produtos, pedidos, cupons e estoque.</p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-4 mb-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary w-100">Gerenciar Produtos</a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('cart.index') }}" class="btn btn-success w-100">Acessar Carrinho</a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('coupons.index') }}" class="btn btn-warning w-100">Cupons</a>
            </div>
        </div>
    </div>
@endsection
