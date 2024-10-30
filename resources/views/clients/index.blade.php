<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>clients</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a una hoja de estilos CSS -->
</head>

<body>
    <h1>Clients</h1>
    <a href="{{ route('clients.create') }}">Add New Client</a>
    <ul>
        @foreach ($clients as $client)
            <li>
                {{ $client->name }} -- {{ $client->email }} -- {{ $client->phone_number }} --
                <a href="{{ route('clients.edit', $client->id) }}">Edit</a>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to remove this client?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
    <a href="/"><- return to the Main Page</a>
</body>

</html>
