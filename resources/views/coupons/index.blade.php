@extends('layouts.app')

@section('content')
    <h1>Cupons</h1>
    <a href="{{ route('coupons.create') }}" class="btn btn-primary mb-3">Novo Cupom</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Desconto</th>
                <th>Valor mínimo</th>
                <th>Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->code }}</td>
                    <td>R$ {{ number_format($coupon->discount, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($coupon->min_value, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('coupons.edit', $coupon) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('coupons.destroy', $coupon) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir cupom?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
