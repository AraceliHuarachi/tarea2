<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

</head>

<body>
    <h1>Orders</h1>

    <a href="{{ route('orders.create') }}">Place an new Order</a>
    <ul>
        @foreach ($orders as $order)
            <li>
                <strong>Order ID:</strong> {{ $order->id }}<br>
                <strong>Client:</strong> {{ $order->client->name }}
                <strong>Products:</strong>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to remove this order?')">Delete</button>
                </form>
                <ul>
                    @foreach ($order->products as $product)
                        <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach

        {{-- @foreach ($orders as $order)
            <li>

                <a href="{{ route('orders.show', $order->id) }}">
                    {{ $order->name }} - Client: {{ $order->client_id }} - Date: {{ $order->order_date }}
                </a>

                <a href="{{ route('orders.edit', $order->id) }}">Edit</a>
                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to remove this order?')">Delete</button>
                </form>
            </li>
        @endforeach --}}
    </ul>
    <a href="/"><- return to the Main Page</a>
</body>

</html>
