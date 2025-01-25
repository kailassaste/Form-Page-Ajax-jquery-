@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->mobile_no }}</td>
        <td>{{ $user->gender->name ?? 'N/A' }}</td>
        <td>{{ $user->city->name ?? 'N/A' }}</td>
        <td>{{ $user->city->state->country->name ?? 'N/A' }}</td> 
        <td>{{ $user->isActive ? 'Active' : 'Inactive' }}</td>
        <td>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
