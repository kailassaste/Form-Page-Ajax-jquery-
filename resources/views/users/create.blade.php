<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJX3Z0X3jxs+1dXbt8kF7x3sfHwPoqFISkIowYwMDt/edYkJd1EO4dT0yDXJ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 4px solid #007bff;
        }

        .form-control {
            width: 100% !important;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
            font-size: 1rem;
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            height: 45px;
            border: 1px solid #ced4da;
        }

        .btn-primary {
            background-color: #0069d9;
            border-color: #0062cc;
            padding: 12px 0;
            font-size: 16px;
            border-radius: 0.5rem;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-select {
            appearance: none;
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"%3E%3Cpath d="M7 10l5 5 5-5z"%3E%3C/path%3E%3C/svg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 15px;
            border: 1px solid #ced4da;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            border-radius: 0.5rem;
            padding: 6px 12px;
            height: 45px !important;
        }

        .select2-container--bootstrap-5 .select2-selection__arrow {
            height: 32px !important;
            width: 32px !important;
        }

        .form-select {
            width: 100%; 
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .form-group select {
            width: 100% !important; 
        }

        .text-danger {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>

</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center text-primary mb-4">Create User Account</h2>

        <form id="userForm" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" >
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mobile_no" class="form-label">Mobile No</label>
                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter your mobile number" >
                @error('mobile_no')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender_id" class="form-label">Gender</label>
                <select class="form-select" name="gender_id" id="gender_id" >
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
                <label for="country_id" class="form-label">Country</label>
                <select class="form-select" id="country_id" name="country_id" >
                    <option>Select Country</option>
                </select>
                @error('country_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="state_id" class="form-label">State</label>
                <select class="form-select" name="state_id" id="state_id" >
                    <option>Select State</option>
                </select>
                @error('state_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="city_id" class="form-label">City</label>
                <select class="form-select" name="city_id" id="city_id">
                    <option>Select City</option>
                </select>
                @error('city_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profile_photo" class="form-label">Profile Photo</label>
                <input type="file" class="form-control" name="profile_photo" id="profile_photo">
                @error('profile_photo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){

        $('#gender_id').select2();
        
        getCountryData(); 
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

    $('#country_id').change(function() 
    {
        var countryId = $(this).val();

        if(countryId) 
        {
            $.ajax({
                url: '/states/' + countryId,
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
                url: '/cities/' + stateId,
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
</script> 

</body>
</html>








