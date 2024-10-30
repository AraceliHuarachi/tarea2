<h1>Add New Client</h1>

<form action="{{ route('clients.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="text" name="email" required>
    </div>
    <div>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required>
    </div>


    <button type="submit">Add Client</button>
</form>
<a href="{{ route('clients.index') }}">Back to Clients List</a>
