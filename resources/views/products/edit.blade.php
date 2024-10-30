<h1>Edit Product</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- Método PUT para actualizar --}}

    <div>
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="{{ $product->name }}" required>
    </div>

    <div>
        <label for="category">Seleccione una categoría:</label>
        <select id="category" name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="{{ $product->price }}" required>
    </div>

    <div>
        <label for="stock">Stock:</label>
        <input type="number" step="1" name="stock" value="{{ $product->stock }}" required>
    </div>

    <button type="submit">Update Product</button>
</form>

<a href="{{ route('products.index') }}">Back to Product List</a>
