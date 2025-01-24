@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create New User</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No</th>
                <th>Gender</th>
                <th>City</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile_no }}</td>
                    <td>{{ $user->gender->name ?? 'N/A' }}</td>
                    <td>{{ $user->city->name ?? 'N/A' }}</td>
                    <td>{{ $user->country_name ?? 'N/A' }}</td> 
                    <td>{{ $user->isActive ? 'Active' : 'Inactive' }}</td>
                    <td>

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn" data-id= "{{ $user->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.delete-btn', function () 
    {
        var userId = $(this).data('id');

        if (confirm('Are you sure you want to delete this user?')) 
        {
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                success: function (response) 
                {
                    alert(response.message);
                    $('tr[data-id="' + userId + '"]').remove();
                },
                error: function () {
                    alert('Error deleting user.');
                }
            });
        }
    });
</script>
