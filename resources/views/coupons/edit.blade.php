@extends('layouts.app')

@section('content')
    <h1>Editar Cupom</h1>

    <form action="{{ route('coupons.update', $coupon) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="code" class="form-control" value="{{ $coupon->code }}" required>
        </div>
        <div class="mb-3">
            <label>Desconto (R$)</label>
            <input type="number" name="discount" class="form-control" step="0.01" value="{{ $coupon->discount }}" required>
        </div>
        <div class="mb-3">
            <label>Valor mínimo (R$)</label>
            <input type="number" name="min_value" class="form-control" step="0.01" value="{{ $coupon->min_value }}" required>
        </div>
        <div class="mb-3">
            <label>Data de validade</label>
            <input type="date" name="expires_at" class="form-control" value="{{ $coupon->expires_at->format('Y-m-d') }}" required>
        </div>

        <button class="btn btn-primary">Atualizar Cupom</button>
    </form>
@endsection
