<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJX3Z0X3jxs+1dXbt8kF7x3sfHwPoqFISkIowYwMDt/edYkJd1EO4dT0yDXJ" crossorigin="anonymous">

    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 0.5rem;
        }

        .form-group select,
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"] {
            margin-bottom: 15px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Create User Account</h2>

        <form id="userForm" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf

            
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name">
            </div>

            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
            </div>

           
            <div class="form-group">
                <label for="mobile_no">Mobile No</label>
                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter your mobile number">
            </div>

            
            <div class="form-group">
                <label for="gender_id">Gender</label>
                <select class="form-control" name="gender_id" id="gender_id">
                    @foreach($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>

           
            <div class="form-group">
                <label for="country_id">Country</label>
                <select class="form-control" id="country_id" name="country_id">
                    <option>Select Country</option>
                </select>
            </div>

            
            <div class="form-group">
                <label for="state_id">State</label>
                <select class="form-control" name="state_id" id="state_id">
                    <option>Select State</option>
                </select>
            </div>

          
            <div class="form-group">
                <label for="city_id">City</label>
                <select class="form-control" name="city_id" id="city_id">
                    <option>Select City</option>
                </select>
            </div>

            
            <div class="form-group">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" class="form-control" name="profile_photo" id="profile_photo">
            </div>

            
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>


 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){

        getCountryData();
    })

    function getCountryData()
    {
        $.ajax({
            url: "{{ url('/countries')}}", 
            type: 'GET',
            success: function(data)
            {
                $('#country_id').empty(); 

                $('#country_id').append('<option value="">Select Country</option>'); // Add default option

                $.each(data, function(index, country) 
                {
                    $('#country_id').append('<option value="'+country.id+'">'+country.name+'</option>');
                });
            }
        });
    }

    $('#country').change(function() {
        var countryId = $(this).val();
        $.ajax({
            url: '/states/' + countryId,
            type: 'GET',
            success: function(data) {
                $('#state').empty();
                $('#state_id').append('<option value="">Select State</option>');
                $.each(data.states, function(index, state) {
                    $('#state').append('<option value="'+state.id+'">'+state.state+'</option>');
                });
            }
        });
    });

    $('#state').change(function() {
        var stateId = $(this).val();
        $.ajax({
            url: '/cities/' + stateId,
            type: 'GET',
            success: function(data) {
                $('select[name="city_id"]').empty();
                $('#city_id').append('<option value="">Select City</option>');
                $.each(data.cities, function(index, city) {
                    $('select[name="city_id"]').append('<option value="'+city.id+'">'+city.city+'</option>');
                });
            }
        });
    });
</script> 


</body>
</html>








