<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $cart = session('cart', []);
    
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }
    
        $subtotal = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    
        // Frete
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal > 200) {
            $frete = 0.00;
        } else {
            $frete = 20.00;
        }
    
        $total = $subtotal + $frete;
    
        // Salvar pedido
        $order = Order::create([
            'subtotal' => $subtotal,
            'freight' => $frete,
            'total' => $total,
            'status' => 'pending',
            'address' => json_encode([
                'cep' => $request->cep,
                'rua' => $request->rua,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
            ]),
        ]);
    
        // Enviar e-mail
        Mail::to('cliente@teste.com')->send(new OrderConfirmation($order, json_decode($order->address, true)));
    
        // Limpar carrinho
        session()->forget('cart');
    
        return redirect()->route('products.index')->with('success', 'Pedido finalizado com sucesso!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
