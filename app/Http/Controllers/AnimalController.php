<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalType;
use App\Models\City;
use App\Models\Message;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;



class AnimalController extends Controller
{
    public function mypage()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $animals = Animal::where('owner_id', $user_id)->get();
        return Inertia::render('Profile/MyPage', ['user' => $user, 'animals' => $animals]);
    }

    public function index() {
        $user_id = Auth::id();
        $animals = Animal::all();
        $types = AnimalType::all();
        $regions = Region::all();
        $cities = City::all();

        $data = $this->getData();

        $mergedData = [];

        foreach ($data as $key => $value) {
            $decodedImg = base64_decode($value['Img']);
            $imgPath = storage_path('app/public/AnimalPictures/' . $key . '.jpg');
            file_put_contents($imgPath, $decodedImg);

            $mergedData[] = [
                'id' => $value['Theid'],
                'owner' => $value['Owner'],
                'location' => $value['location'],
                'type' => $value['thetype'],
                'breed' => $value['Poroda'],
                'image' => 'AnimalPictures/' . $key . '.jpg',
                'gender' => $value['pol'],
                'date_of_birth' => $value['Birthdate'],
                'direction' => $value['napr'],
                'reason_for_staging' => $value['prichpost'],
                'date_for_registration' => $value['datapost'],
                'identification_method' => $value['metidentif'],
                'note' => $value['Note'],
            ];
        }
        return Inertia::render('Animal/List', ['data' => $data,'animals' => $animals, 'types' => $types, 'regions' => $regions, 'cities' => $cities]);

    }

    public function getData()
    {
        $factory = (new Factory)
            ->withServiceAccount('G:\Programs\Firebase\thediplomaproject-3c9f0-firebase-adminsdk-wic6m-7e0972aeb6.json')
            ->withDatabaseUri('https://thediplomaproject-3c9f0-default-rtdb.firebaseio.com/');

        $database = $factory->createDatabase();

        return $database->getReference('Information')->getValue();
    }

    public function show($id) {
        $animal = Animal::find($id);

        if ($animal) {
            $user = User::find($animal->owner_id);
            $region = Region::find($animal->region);
            $city = City::find($animal->city);
            $type = AnimalType::find($animal->type);
            $created_at = date('Y-m-d', strtotime($animal->created_at));
            $owner_created_at = date('Y-m-d', strtotime($user->created_at));

            $animalData = [
                'owner_id' => $user->id,
                'owner' => $user->name,
                'owner_date_registration' => $owner_created_at,
                'city' => $city->name,
                'region' => $region->name,
                'type' => $type->name,
                'created_at' => $created_at,
                'image' => $animal->image,
            ];
        } else {
            $data = $this->getData();

            if (isset($data[$id])) {
                $value = $data[$id];

                $decodedImg = base64_decode($value['Img']);
                $imgPath = storage_path('app/public/AnimalPictures/' . $id . '.jpg');
                file_put_contents($imgPath, $decodedImg);

                $animalData = [
                    'id' => $value['Theid'],
                    'owner' => $value['Owner'],
                    'location' => $value['location'],
                    'type' => $value['thetype'],
                    'breed' => $value['Poroda'],
                    'image' => 'AnimalPictures/' . $id . '.jpg',
                    'gender' => $value['pol'],
                    'date_of_birth' => $value['Birthdate'],
                    'direction' => $value['napr'],
                    'reason_for_staging' => $value['prichpost'],
                    'date_for_registration' => $value['datapost'],
                    'identification_method' => $value['metidentif'],
                    'note' => $value['Note'],
                ];
            } else {
                return response()->json(['message' => 'Animal not found'], 404);
            }
        }

        return Inertia::render('Animal/Show', ['animal' => $animal, 'animalData' => $animalData]);
    }

    public function delete($id) {
        $animal = Animal::find($id);
        $animal -> delete();
        return back();
    }

    public function create() {
        $cities = City::all();
        $regions = Region::all();
        $animal_types = AnimalType::all();

        return Inertia::render('Animal/Create',['cities' => $cities, 'regions' => $regions, 'animal_types' => $animal_types]);
    }

    public function store() {
        $user_id = Auth::id();
        $region = request()->selectedRegion;
        $city = request()->selectedCity;
        $animal_type = request()->animalType;
        $animal_gender = request()->animalGender;
        $animal_breed = request()->animalBreed;
        $date_of_birth = request()->dateOfBitrh;
        $note = request()->note;
        $price = request()->price;
        $image = request()->image;

        if ($image) {
            $image = $image->store('AnimalPictures', 'public');
        } else {
            $image = null;
        }

        Animal::create([
            'owner_id' => $user_id,
            'region' => $region,
            'city' => $city,
            'type' => $animal_type,
            'gender' => $animal_gender,
            'breed' => $animal_breed,
            'image' => $image,
            'date_of_birth' => $date_of_birth,
            'note' => $note,
            'price' => $price,
        ]);

        return 200;
    }

    public function filter(Request $request)
    {
        $query = Animal::query();

        if (is_numeric($request->type)) {
            $query->where('type', $request->type);
        }

        if (is_numeric($request->region)) {
            $query->where('region', $request->region);
        }

        if (is_numeric($request->city)) {
            $query->where('city', $request->city);
        }

        if ($request->gender !== 'Пол') {
            $query->where('gender', $request->gender);
        }

        $animals = $query->get();

        $types = AnimalType::all();
        $regions = Region::all();
        $cities = City::all();
        $error = 1;
        return response()->json([
            'error' => $error,
            'filteredAnimals' => $animals,
            'types' => $types,
            'regions' => $regions,
            'cities' => $cities,
        ]);
    }

//            $query->orWhere('gender', 'LIKE', '%' . $animal_gender . '%');
//        }
//
//        $animals = $query->get();
//        $types = AnimalType::all();
//        $regions = Region::all();
//        $cities = City::all();
//
//
//        return Inertia::render('Animal/Filter', ['filteredAnimals' => $animals, 'types' => $types, 'regions' => $regions, 'cities' => $cities]);
//    }
}
