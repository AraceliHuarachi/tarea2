 <h1>Products list</h1>
 <a href="{{ route('products.create') }}">Add New Product</a>
 <ul>
     @foreach ($products as $product)
         <li>
             {{ $product->name }} - Category: {{ $product->category_id }} - Price: ${{ $product->price }} - Stock:
             {{ $product->stock }}
             <a href="{{ route('products.edit', $product->id) }}">Edit</a>
             <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                 @csrf
                 @method('DELETE')
                 <button type="submit"
                     onclick="return confirm('Are you sure you want to remove this product?')">Delete</button>
             </form>
         </li>
     @endforeach
 </ul>
 <a href="/"><- return to the Main Page</a>
