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
                <th>Profile Photo</th>
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
                method: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'profile_photo', name: 'profile_photo' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobile_no', name: 'mobile_no' },
                { data: 'gender', name: 'gender' },
                { data: 'state', name: 'state' },
                { data: 'city', name: 'city' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            order: [[2, 'asc']], 
            lengthChange: true, 
            pageLength: 8, 
            dom: 'lfrtip',
            language: {
                paginate: {
                    next: 'Next',
                    previous: 'Previous',
                }
            }
        });

        $(document).on('click', '.delete-btn', function () {
            var userId = $(this).data('id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/users/' + userId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        table.ajax.reload(null, false);
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