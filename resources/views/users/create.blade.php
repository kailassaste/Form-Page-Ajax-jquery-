@extends('layouts.app')

@section('content')
<style>
    .bold-label {
        font-weight: bold;
        font-size: 1.2rem;
        }
    .back-button {
        position: absolute;
        top: 10px;
        right: 20px;
        z-index: 20px;
        }
    .form-container {
        position: relative;
        padding-top: 40px; 
        }
</style>

<div class="container my-5">
    <div class="card p-4 shadow-lg" style="max-width: 800px; background-color: #f8f9fa;">
        <h2 class="text-center text-primary mb-4 fw-bold" style="font-family: 'Arial', sans-serif;">Create User Account</h2>
        
        <a href="{{ route('users.index') }}" class="btn btn-secondary back-button">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form id="userForm" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label bold-label" >Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" >
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label bold-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mobile_no" class="form-label bold-label">Mobile No</label>
                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter your mobile number" >
                @error('mobile_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender_id" class="form-label bold-label">Gender</label>
                <select class="form-select" name="gender_id" id="gender_id" style="height: 50px;">
                    <option value="" disabled selected>Select Gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
                @error('gender_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="country_id" class="form-label bold-label">Country</label>
                <select class="form-select" id="country_id" name="country_id" >
                    <option value="">Select Country</option>
                </select>
                @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="state_id" class="form-label bold-label">State</label>
                <select class="form-select" name="state_id" id="state_id" >
                    <option value="">Select State</option>
                </select>
                @error('state_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="city_id" class="form-label bold-label">City</label>
                <select class="form-select" name="city_id" id="city_id">
                    <option value="">Select City</option>
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profile_photo" class="form-label bold-label">Profile Photo</label>
                <input type="file" class="form-control" name="profile_photo" id="profile_photo">
                @error('profile_photo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff; border-color: #007bff; font-weight: bold; padding: 10px;">Submit</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function()
    {
        $('#gender_id').select2();
        $('#country_id').select2();
        $('#state_id').select2();
        $('#city_id').select2();
        
        getCountryData(); 

        $(document).on('change','#country_id',function() 
        {
        var countryId = $(this).val();

        if(countryId) 
        {
            $.ajax({
                url: "{{ url('/states') }}/" + countryId,
                type: 'GET',
                success: function(data) 
                {
                    $('#state_id').empty();
                    $('#state_id').append('<option value="">Select State</option>');

                    if (data.states.length > 0) 
                    {
                    $.each(data.states, function(index, state) 
                    {
                        $('#state_id').append('<option value="'+state.id+'">'+state.name+'</option>');
                    });
                } else {
                    $('#state_id').append('<option value="">No states available</option>');
                }
            }
        });
    }
    });

    $('#state_id').change(function()
     {
        var stateId = $(this).val();

        if(stateId) 
        {
            $.ajax({
                url: "{{ url('/cities') }}/" + stateId,
                type: 'GET',
                success: function(data)
                 {
                    $('#city_id').empty();
                    $('#city_id').append('<option value="">Select City</option>');

                    if (data.cities.length > 0) 
                    {
                    $.each(data.cities, function(index, city) 
                    {
                        $('#city_id').append('<option value="'+city.id+'">'+city.name+'</option>');
                    });
                } else 
                {
                    $('#city_id').append('<option value="">No cities available</option>');
                }
            }
        });
    }
    });
});
    
    function getCountryData()
    {
        $.ajax({
            url: "{{ url('/countries')}}", 
            type: 'GET',
            success: function(data)
            {
                $('#country_id').empty(); 

                $('#country_id').append('<option value="">Select Country</option>');

                $.each(data, function(index, country) 
                {
                    $('#country_id').append('<option value="'+country.id+'">'+country.name+'</option>');
                });
            }
        });
    }

</script> 
@endsection








