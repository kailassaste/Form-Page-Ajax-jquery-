@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile_no">Mobile No</label>
            <input type="text" id="mobile_no" name="mobile_no" class="form-control" value="{{ old('mobile_no', $user->mobile_no) }}">
            @error('mobile_no')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gender_id">Gender</label>
            <select name="gender_id" id="gender_id" class="form-control">
                <option value="">Select Gender</option>
            </select>
            <input type="hidden" name="selected_gender_id" id="selected_gender_id" value="{{ old('gender_id', $user->gender_id) }}">
            @error('gender_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="country_id">Country</label>
            <select name="country_id" id="country_id" class="form-control">
                <option value="">Select Country</option>
            </select>
            <input type="hidden" name="selected_country_id" id="selected_country_id" value="{{ old('country_id', $user->country_id) }}">
            @error('country_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="state_id">State</label>
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Select State</option>
            </select>
            <input type="hidden" name="selected_state_id" id="selected_state_id" value="{{ old('state_id', $user->state_id) }}">
            @error('state_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="city_id">City</label>
            <select name="city_id" id="city_id" class="form-control">
                <option value="">Select City</option>
           </select>
           <input type="hidden" name="selected_city_id" id="selected_city_id" value="{{ old('city_id', $user->city_id) }}">
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

<script>
    $(document).ready(function() 
    {
        console.log('hii');
        $.ajax({
            url: '/genders',
            type: 'GET',
            success: function(data) 
            {
                $('#gender_id').empty();

                $('#gender_id').append('<option value="">Select Gender</option>');

                $.each(data.genders, function(index, gender) 
                {
                    $('#gender_id').append('<option value="'+gender.id+'">'+gender.name+'</option>');
                });
            }
        });

        $.ajax({
            url: '/countries',
            type: 'GET',
            success: function(data) 
            {
                $('#country_id').empty().append('<option value="">Select Country</option>');

                $.each(data.countries, function(index, country) 
                {
                    $('#country_id').append('<option value="'+country.id+'">'+country.name+'</option>');
                });
            }
        });

        $('select[id="country_id"]').change(function() 
        {
            var selectedValue = $(this).val();
            var id = $(this).attr('id');      // --country_id
            
            if (selectedValue) 
            {
                $.ajax({
                    url: '/states/' + selectedValue,
                    type: 'GET',
                    success: function(data) 
                    {
                        $('#state_id').empty().append('<option value="">Select State</option>');

                        $.each(data.states, function(index, state) 
                        {
                            $('#state_id').append('<option value="'+state.id+'">'+state.name+'</option>');
                        });
                    }
                });
            }
        });

        $('select[id="state_id"]').change(function() 
        {
            var selectedValue = $(this).val();
            var id = $(this).attr('id');    // --state_id

            if (selectedValue) 
            {
                $.ajax({
                    url: '/cities/' + selectedValue,
                    type: 'GET',
                    success: function(data) 
                    {
                        $('#city_id').empty().append('<option value="">Select City</option>');
                        $.each(data.cities, function(index, city) 
                        {
                            $('#city_id').append('<option value="'+city.id+'">'+city.name+'</option>');
                        });
                    }
                });
            }
        });

        $('select[id$="_id"]').change(function() 
        {
            var selectedValue = $(this).val();
            var id = $(this).attr('id');

            if (id === 'country_id') 
            {
                $('#selected_country_id').val(selectedValue);
            } 
            else if (id === 'state_id') 
            {
                $('#selected_state_id').val(selectedValue);
            } 
            else if (id === 'city_id')
            {
                $('#selected_city_id').val(selectedValue);
            }
        });
    });
</script>

