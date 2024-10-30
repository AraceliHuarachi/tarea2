<h1>Place a new Order</h1>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf`

    <div>
        <label for="client">Client:</label>
        <select id="client" name="client_id">
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="order_date">Order_date:</label>
        <input type="date" name="order_date" value="{{ old('order_date') }}" required>
        @error('order_date')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>


    <h3>Products</h3>
    <div id="product-list">
        @for ($i = 0; $i < 4; $i++)
            <div class="product-item">
                <select name="products[{{ $i }}][id]" required onchange="updateTotal()">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old("products.{$i}.id") == $product->id ? 'selected' : '' }}
                            data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error("products.{$i}.id")
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <input type="number" name="products[{{ $i }}][quantity]" min="1"
                    placeholder="Quantity" value="{{ old("products.{$i}.quantity") }}" required
                    oninput="updateTotal()">

                @error("products.{$i}.quantity")
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        @endfor

    </div>


    <h4>Total Amount: <span id="total_amount_display">0.00</span></h4>
    <input type="hidden" id="total" name="total" value="{{ old('total') }}" required>
    @error('total')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <button type="submit">Save Order</button>
</form>


<script>
    function updateTotal() {
        let total = 0;
        const productItems = document.querySelectorAll('.product-item');

        productItems.forEach(item => {
            const quantity = item.querySelector('input[name*="[quantity]"]').value;
            const productId = item.querySelector('select[name*="[id]"]').value;
            const productPrice = parseFloat(item.querySelector(`option[value="${productId}"]`).getAttribute(
                'data-price'));

            if (quantity && productPrice) {
                total += quantity * productPrice;
            }
        });

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('total_amount_display').textContent = total.toFixed(2);
    }
</script>

<a href="{{ route('orders.index') }}">Back to Orders</a>
