@extends('layouts.app')

@section('content')
    <h1>Novo Cupom</h1>

    <form action="{{ route('coupons.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Desconto (R$)</label>
            <input type="number" name="discount" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Valor mínimo (R$)</label>
            <input type="number" name="min_value" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Data de validade</label>
            <input type="date" name="expires_at" class="form-control" required>
        </div>

        <button class="btn btn-primary">Salvar Cupom</button>
    </form>
@endsection
