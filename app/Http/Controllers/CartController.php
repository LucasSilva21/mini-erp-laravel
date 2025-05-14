<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);
    
        // Se já existe, soma a quantidade
        if (isset($cart[$product->id])) {
            $existingQuantity = isset($cart[$product->id]['quantity']) ? $cart[$product->id]['quantity'] : 0;
            $cart[$product->id]['quantity'] = $existingQuantity + $quantity;
        } else {
            // Se não existe, cria o item
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }
    
        session(['cart' => $cart]);
    
        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho.');
    }    

    public function index(Request $request)
    {
        $cart = session('cart', []);
    
        $subtotal = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

    
        // Lógica de frete
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal > 200) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }
    
        $desconto = 0.00;
        $total = $subtotal + $frete;
    
        // Lógica do cupom
        if ($request->has('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
    
            if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_value) {
                $desconto = $coupon->discount;
                $total -= $desconto;
            } else {
                return redirect()->route('cart.index')->with('error', 'Cupom inválido ou não aplicável.');
            }
        }
    
        return view('cart.index', compact('cart', 'subtotal', 'frete', 'desconto', 'total'));
    }    

    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho.');
    }

}

