<div class="container">
    <h1>Order Details</h1>

    <div class="order-info">
        <h3>Order ID: {{ $order->id }}</h3>
        <p><strong>Client Name:</strong> {{ $order->client->name }}</p> <!-- Cambiado a client->name -->
        <p><strong>Order Date:</strong> {{ $order->order_date->format('d-m-Y') }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
    </div>

    <h3>Products in this Order:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price at Purchase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>${{ number_format($product->pivot->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to Orders</a>
</div>
