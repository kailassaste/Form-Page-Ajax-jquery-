@extends('layouts.app')

@section('content')
<style>
    .bold-label {
        font-weight: bold;
        font-size: 1.2rem;
    }
    .create-user-btn {
        float: right;
    }
    tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>

<div class="container mt-5">

    <h1 class="fw-bold mb-4">Users List</h1>

    <a href="{{ route('users.create') }}" class="btn btn-success create-user-btn mb-3">Create New User</a>

    <table class="table table-bordered table-striped" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No</th>
                <th>Gender</th>
                <th>State</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() 
    {
        var table = $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('users.index') }}", 
                data: function(d) {
                    d.search = $('input[type="search"]').val();
                },
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1 + meta.settings._iDisplayStart;
                    },
                    searchable: false,
                    orderable: false
                },
                { data: 'name' },
                { data: 'email' },
                { data: 'mobile_no' },
                { data: 'gender.name', defaultContent: 'N/A' },
                { data: 'city.state.name', defaultContent: 'N/A' },
                { data: 'city.name', defaultContent: 'N/A' },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <a href="/users/${data}/edit" class="btn btn-warning btn-sm mx-1">Edit</a>
                            <form action="/users/${data}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1 delete-btn" data-id="${data}">Delete</button>
                            </form>
                        `;
                    }
                }
            ],
            lengthChange: true, 
            pageLength: 4, 
            dom: 'lfrtip',  
        });

        $(document).on('click', '.delete-btn', function () {
            var userId = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/users/' + userId,
                    type: 'DELETE',
                    success: function(response) {
                        alert(response.message);
                        table.ajax.reload();
                    },
                    error: function() {
                        alert('Error deleting user.');
                    }
                });
            }
        });
    });
</script>
@endsection