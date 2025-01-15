<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Country</title>
</head>
<body>
    <h1>Create a New Country</h1>
    
    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        <label for="name">Country Name</label>
        <input type="text" name="name" required>
        <button type="submit">Create Country</button>
    </form>

</body>
</html>
