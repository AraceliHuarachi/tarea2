<h1>Add New Product</h1>

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
    </div>
    <div>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>
    </div>
    <div>
        <label for="category">Category:</label>
        <select id="category" name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit">Add Product</button>
</form>
<a href="{{ route('products.index') }}">Back to Product List</a>
