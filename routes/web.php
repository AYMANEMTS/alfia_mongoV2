<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    if (Session::has('auth')) {
        Session::flash('status', 'Vous êtes déjà connecté');
        return redirect()->route('dashboard');
    }
    return view("login");
})->name("login");

Route::get('/admin', function () {
    // Define days in French
    $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    $startOfWeek = Carbon::now()->startOfWeek(); // Start of the current week
    $endOfWeek = Carbon::now()->endOfWeek(); // End of the current week

    // Helper function to map data to French days and fill missing days with 0
    function mapDataToFrenchDays($data, $days) {
        $englishToFrench = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche',
        ];

        // Initialize an array with all days as 0
        $mappedData = array_fill_keys($days, 0);

        foreach ($data as $englishDay => $count) {
            $frenchDay = $englishToFrench[$englishDay] ?? null;
            if ($frenchDay) {
                $mappedData[$frenchDay] = $count;
            }
        }

        return array_values($mappedData); // Return values in the correct order
    }

    // Query and group by day for each collection
    $formations = DB::connection('mongodb')->table('formations')
        ->whereBetween('createdAt', [$startOfWeek, $endOfWeek])
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->createdAt)->format('l'); // Group by weekday
        })
        ->map(function ($group) {
            return $group->count();
        });

    $participants = DB::connection('mongodb')->table('participants')
        ->whereBetween('createdAt', [$startOfWeek, $endOfWeek])
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->createdAt)->format('l');
        })
        ->map(function ($group) {
            return $group->count();
        });

    $accompagnement = DB::connection('mongodb')->table('accompagnment')
        ->whereBetween('createdAt', [$startOfWeek, $endOfWeek])
        ->get()
        ->groupBy(function ($date) {
            return Carbon::parse($date->createdAt)->format('l');
        })
        ->map(function ($group) {
            return $group->count();
        });

    // Map the data to French days
    $formationsData = mapDataToFrenchDays($formations->toArray(), $days);
    $participantsData = mapDataToFrenchDays($participants->toArray(), $days);
    $accompagnementData = mapDataToFrenchDays($accompagnement->toArray(), $days);

    // Count total records
    $formationsCount = DB::connection('mongodb')->table('formations')->count();
    $participantsCount = DB::connection('mongodb')->table('participants')->count();
    $accompagnementCount = DB::connection('mongodb')->table('accompagnment')->count();

    // Pass data to the view
    return view("admin", compact('formationsCount', 'participantsCount', 'accompagnementCount', 'formationsData', 'participantsData', 'accompagnementData'));
})->name('dashboard')->middleware('auth');




Route::post('/login', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $email = $request->input('email');
    $password = $request->input('password');

    try {
        $usersCollection = DB::connection('mongodb')->getCollection('users');

        $user = $usersCollection->findOne(['email' => $email, 'password' => $password]);
        if ($user) {
            Session::put('auth', true);
            Session::put('auth_user', [
                'admin_id' => (string) $user['_id'],
                'user_name' => $user['username'],
                'user_email' => $user['email'],
                'job' => $user['job'],
                'role' => $user['role']
            ]);

            if ($user['role'] === "utilistateur") {
                Session::put('status', "Logged In Successfully");
                return redirect()->route('dashboard');
            } elseif ($user['role'] === "admin") {
                Session::put('status', "Logged In Successfully");
                return redirect()->route('dashboard');
            }
        } else {
            Session::put('status', "Access Denied");
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Error: ' . $e->getMessage());
    }
})->name('postLogin');

Route::get('/logout', function () {
    Session::forget('auth');
    Session::forget('auth_user');

    Session::put('status', 'Déconnexion réussie');
    return redirect()->route('login');
})->name('logout')->middleware('auth');

Route::get('/participant', function () {
    $participantollection = DB::connection('mongodb')->getCollection('participants');
    $participants = $participantollection->find()->toArray();
    return view('participant', compact('participants'));
})->middleware('auth');


Route::get('/formation', function () {
    $formationsollection = DB::connection('mongodb')->getCollection('formations');
    $formations = $formationsollection->find()->toArray();
    return view('formation', compact('formations'));
})->middleware('auth');


Route::get('/accompagnement', function () {
    $accompagnementCollection = DB::connection('mongodb')->getCollection('accompagnment');
    $accompagnement = $accompagnementCollection->find()->toArray();
    return view('accompagnement', compact('accompagnement'));
})->middleware('auth');

Route::get('/users', function () {
    $usersCollection = DB::connection('mongodb')->getCollection('users');
    $users = $usersCollection->find()->toArray();
    return view('users', compact('users'));
})->name('users')->middleware('auth');

Route::post('/add-user',function (Request $request) {
    $validated = $request->validate([
        'full_name' => 'required',
        'job' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required',
    ]);
    $fullname = $request->input('full_name');
    $job = $request->input('job');
    $email = $request->input('email');
    $password = $request->input('password');
    $role = $request->input('role');

    try {
        // Create the user data
        $data = [
            'username' => $fullname,
            'email' => $email,
            'password' => $password,
            'job' => $job,
            'role' => $role,
        ];

        // Get the collection and insert the data
        $usersCollection = DB::connection('mongodb')->getCollection('users');
        $insertResult = $usersCollection->insertOne($data);

        if ($insertResult->getInsertedCount() === 1) {
            return redirect()->route('users')->with('success', 'User created successfully!');
        } else {
            return redirect()->route('users')->with('error', 'An error occurred while creating the user.');
        }
    } catch (\Exception $e) {
        return redirect()->route('users')->with('error', 'Error: ' . $e->getMessage());
    }
})->name('add-user')->middleware('auth');
