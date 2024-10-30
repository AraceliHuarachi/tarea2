<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'The client is required.',
            'products.required' => 'At least one product is required.',
            'total.required' => 'The total amount is required.',
            'products.*.id.exists' => 'The selected product does not exist.',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $productIds = array_column($this->input('products', []), 'id');

            // Verificar productos duplicados
            $duplicates = array_diff_assoc($productIds, array_unique($productIds));

            foreach ($duplicates as $index => $duplicateId) {
                $validator->errors()->add("products.$index.id", 'You cannot add the same product more than once.');
            }
            // if (count($productIds) !== count(array_unique($productIds))) {
            //     $validator->errors()->add(
            //         'products',
            //         'You cannot add the same product more than once.'
            //     );
            // }

            // Iteramos sobre cada producto para verificar el stock
            foreach ($this->input('products', []) as $index => $productData) {

                $product = Product::find($productData['id']);

                // Verificamos si la cantidad solicitada excede el stock disponible
                if ($product && $productData['quantity'] > $product->stock) {
                    $validator->errors()->add(
                        "products.{$index}.quantity",
                        "The quantity requested for {$product->name} exceeds the available stock ({$product->stock})."
                    );
                }
            }
        });
    }
}
