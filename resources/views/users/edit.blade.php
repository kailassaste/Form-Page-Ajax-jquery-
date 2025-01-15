@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile_no">Mobile No</label>
            <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="{{ old('mobile_no', $user->mobile_no) }}" required>
            @error('mobile_no')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gender_id">Gender</label>
            <select name="gender_id" id="gender_id" class="form-control" required>
                <option value="">Select Gender</option>
                @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}" {{ old('gender_id', $user->gender_id) == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                @endforeach
            </select>
            @error('gender_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password (Leave blank to keep current password)</label>
            <input type="password" id="password" name="password" class="form-control">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="profile_photo">Profile Photo (Optional)</label>
            <input type="file" name="profile_photo" class="form-control" accept=".jpg,.png">
            @error('profile_photo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
