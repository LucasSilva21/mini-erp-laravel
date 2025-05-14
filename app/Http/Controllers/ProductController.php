<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variations')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'variations.*.variation_name' => 'required|string|max:255',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.price_override' => 'nullable|numeric',
        ]);
    
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);
    
        if ($request->has('variations')) {
            foreach ($request->variations as $variation) {
                $product->variations()->create([
                    'variation_name' => $variation['variation_name'],
                    'stock' => $variation['stock'],
                    'price_override' => $variation['price_override'] ?? null,
                ]);
            }
        }
            
        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('variations'); // carrega as variações
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'variations.*.id' => 'nullable|exists:product_variations,id',
            'variations.*.variation_name' => 'required|string|max:255',
            'variations.*.stock' => 'required|integer|min:0',
            'variations.*.price_override' => 'nullable|numeric',
        ]);
    
        // Atualiza o produto
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
    
        // Atualiza cada variação com try/catch para capturar o erro
        foreach ($request->variations as $variationData) {
            try {
                if (!empty($variationData['id'])) {
                    $variation = $product->variations()->where('id', $variationData['id'])->first();
                    if ($variation) {
                        unset($variationData['id']);
                        $variation->update($variationData);
                    }
                }
            } catch (\Exception $e) {
                dd('Erro ao atualizar variação:', $e->getMessage(), $variationData);
            }
        }
    
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }
    
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
