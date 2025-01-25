@extends('layouts.app')

@section('content')
<style>
    tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
<div class="container">
    <h1 class="fw-bold mb-4">Users</h1>

    <div class="mb-3">
        <label for="search" class="form-label">Search Users</label>
        <input type="text" class="form-control" id="search" placeholder="Search here...">
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create New User</a>
    <table class="table table-bordered table-striped" id="userTable">
        <thead class="table-dark">
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

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mx-1 delete-btn" data-id= "{{ $user->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            fetchData(query);
        });

        function fetchData(query = '') {
            $.ajax({
                url: "{{ route('users.index') }}", 
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#userTable tbody').html(data);
                }
            });
        }
        fetchData();

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
});
</script>
@endsection