<?php
namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Gender;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class UserController extends Controller
{
    public function create()
    {
        
        $genders = Gender::all();
        $countries = Country::all();

        return view('users.create', compact('genders', 'countries'));
    }

    public function edit($id)
    {
        $user = Users::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'mobile_no' => 'required|string|max:15',
                'gender_id' => 'required|exists:genders,id',
                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'gender_id.required' => 'Gender field is required',
                'country_id.required' => 'Country field is required',
                'state_id.required' => 'State field is required',
                'city_id.required' => 'City field is required',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
        
        $existingUser = Users::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->back()
                             ->withErrors(['email' => 'The email address is already taken.'])
                             ->withInput();
        }

        $data = $request->only([
            'name', 'email', 'mobile_no', 'gender_id', 'city_id', 'profile_photo',
        ]);
    
        $data['password'] = Hash::make($request->password);

        $data['created_at'] = now();
        
        $user = new Users();

        if ($request->hasFile('profile_photo'))
        {
            $file = $request->file('profile_photo');

            $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('profilePhotos'), $fileName);

            $user->profile_photo = 'profilePhotos/' . $fileName;

            $data['profile_photo'] = $user->profile_photo;

        }
        else{
            $data['profile_photo'] = null;
        }
   
        $save = $user->createdBy($data);

        if(!empty($save)){
            session()->flash('success', 'User created successfully!');
        }else{
            session()->flash('error', 'User not created!');
        }

        return redirect()->route('users.create'); 
    }

    public function update(Request $request, $id)
    {
        $user = Users::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'mobile_no' => 'required|string|max:15',
                'gender_id' => 'required|exists:genders,id',
                'country_id' => 'required|exists:countries,id',
                'state_id' => 'required|exists:states,id',
                'city_id' => 'required|exists:cities,id',
                'password' => 'nullable|string|min:8|confirmed',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'gender_id.required' => 'Gender field is required',
                'country_id.required' => 'Country field is required',
                'state_id.required' => 'State field is required',
                'city_id.required' => 'City field is required',

            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $request->only(['name', 'email', 'mobile_no', 'gender_id', 'city_id', 'password', 'profile_photo']);

        if ($request->password) 
        {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo'))
        {
            $file = $request->file('profile_photo');

            $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profilePhotos'), $fileName);

            $user->profile_photo = 'profilePhotos/' . $fileName;

            $data['profile_photo'] = $user->profile_photo;
        }
        else{
            $data['profile_photo'] = null;
        }
    
        $user->update($data); 

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    
    public function index(Request $request)
    {
       if($request->ajax()) {
        $users= Users::with(['gender', 'city', 'city.state.country'])->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('profile_photo', function($row)
            {
                if ($row->profile_photo) 
                {    
                    $photoPath = $row->profile_photo;
                
                    if (strpos($photoPath, '/storage') === 0) 
                    {
                        $editPath = substr($photoPath, strlen('/storage'));
                    }else{
                        $editPath = null;
                    }
                    return '<img src="' . Storage::disk('public')->url('profilePhotos/user_1738228493.png') . '" class="profile-photo" alt="profile photo" width="50">';
                    
                }
               return 'no photo';
            })
            ->addColumn('name', function($row) 
            {
                return $row->name ?? 'N/A';
            })
            ->addColumn('mobile_no', function($row)
            {
                return $row->mobile_no ?? 'N/A';

            })
            ->addColumn('gender', function($row)
            {
                return $row->gender->name ?? 'N/A';

            })
            ->addColumn('state', function($row) 
            {
                return $row->city->state->name ?? 'N/A';
            })
            ->addColumn('city', function($row) 
            {
                return $row->city->name ?? 'N/A';
            })
            ->addColumn('actions', function($row) 
            {
                return '
                    <a href="/users/' . $row->id . '/edit" class="btn btn-warning btn-sm mx-1">Edit</a>
                    <form action="/users/' . $row->id . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm mx-1 delete-btn" data-id="' . $row->id . '">Delete</button>
                    </form>';
            })
            ->rawColumns(['profile_photo', 'actions'])
            ->make(true);  
       }

        return view('users.index');
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

    public function getCountryData()
    {
        $countries = new Country();
        $getCountry = $countries->getCountry();

        return response()->json($getCountry);
    }

    public function getGender()
    {
        $genders = Gender::all();

        return response()->json(['genders' => $genders]);

    }

    public function updatedBy()
    {
        $users = Users::updatedBy();

        return view('users.updated', compact('users'));
    }

    public function deletedBy()
    {
        $users = Users::deletedBy();

        return view('users.deleted', compact('users'));
    }

    public function destroy($id)
{
    $user = Users::findOrFail($id);

    $deletedUserInfo = $user->only(['id', 'name', 'email', 'mobile_no', 'gender_ID', 'city_ID']);
  
    $user->delete();

    return response()->json(['message' => 'User deleted successfully!','user' => $deletedUserInfo]);
}

}

