<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        
        $genders = Gender::all();
        $countries = Country::all();

        return view('users.create', compact('genders', 'countries'));
    }

    
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|string|max:15',
            'gender_id' => 'required|exists:genders,id',
            'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hash pass
        $hashedPassword = Hash::make($request->password);

        //  for profile photo
        if ($request->hasFile('profile_photo')) {
            $filename = time() . '.' . $request->file('profile_photo')->extension();
            $filePath = public_path('profilePhotos/' . $filename);
            $request->file('profile_photo')->move($filePath, $filename);
        }

        // Create the user record
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'gender_id' => $request->gender_id,
            'city_id' => $request->city_id,
            'password' => $hashedPassword,
            'profile_photo' => isset($filename) ? 'profilePhotos/' . $filename : null,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    //List all users
    public function index()
    {
        $userModel = new User();

        $users= $userModel->getAllUsers();

        return view('user.index', compact('users'));
    }

    
    public function getStates($countryId)
    {
        $stateModel = new State();

        $states = $stateModel->getStatesByCountry($countryId);

        return response()->json(['states' => $states]);
    }

    
    public function getCities($stateId)
    {
        $cityModel = new City();

        $cities = $cityModel->getCitiesByState($stateId);

        return response()->json(['cities' => $cities]);
    }

    public function getCountryData(){
        $countries = new Country();
        $getCountry = $countries->getCountry();

        return $getCountry;
    }

}






 //for country
    // public function showCreateCountryForm()
    // {
    //     return view('countries.create');
    // }

    // public function createCountry(Request $request)
    // {
        
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:countries,name', 
    //     ]);

    //     $country = new Country();
    //     $country->createCountry($request->name);

    //     return redirect()->route('countries.index')->with('success', 'Country created successfully!');
    // }

    // public function indexCountries()
    // {
    //     $countries = Country::all();  // Fetch all countries
    //     return view('countries.index', compact('countries'));  // Pass countries to the view
 
    // }