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
    // Fetch chart data and years
    $formationsChartData = getChartData('formations');
    $participantsChartData = getChartData('participants');
    $accompagnementChartData = getChartData('accompagnment');
    
    // Extract years from the chart data
    $formationsChart = $formationsChartData['data'];
    $participantsChart = $participantsChartData['data'];
    $accompagnementChart = $accompagnementChartData['data'];
    $years = array_unique(array_merge($formationsChartData['years'], $participantsChartData['years'], $accompagnementChartData['years']));
    // Fetch counts
    $formationsCount = DB::connection('mongodb')->table('formations')->count();
    $participantsCount = DB::connection('mongodb')->table('participants')->count();
    $accompagnementCount = DB::connection('mongodb')->table('accompagnment')->count();

    // Return the data to the view
    return view("admin", compact('formationsCount', 'participantsCount', 'accompagnementCount', 'formationsChart',
    'participantsChart','accompagnementChart', 'years'));
})->name('dashboard')->middleware('auth');


function getChartData($collection) {
    // Fetch the data from MongoDB
    $formations = DB::connection('mongodb')
        ->getCollection($collection)
        ->aggregate([
            [
                '$project' => [
                    'year' => ['$year' => '$createdAt'], 
                    'month' => ['$month' => '$createdAt'],
                ],
            ],
            [
                '$group' => [
                    '_id' => [
                        'year' => '$year',
                        'month' => '$month', 
                    ],
                    'count' => ['$sum' => 1], 
                ],
            ],
            [
                '$sort' => [
                    '_id.year' => -1, 
                    '_id.month' => 1, 
                ],
            ],
        ]);

    // Array of month names for mapping
    $monthNames = [
        1 => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin',
        '7' => 'Juillet', '8' => 'Aout', '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
    ];

    $results = [];
    $years = [];  // To store the years

    foreach ($formations as $formation) {
        $year = $formation['_id']['year'];
        $month = $formation['_id']['month'];
        $count = $formation['count'];

        // Store the year in the years array
        if (!in_array($year, $years)) {
            $years[] = $year;
        }

        // If the year does not exist in the results array, create it
        if (!isset($results[$year])) {
            $results[$year] = [
                'year' => $year,
                'count' => 0,
                'months' => [],
            ];
        }

        // Add the month name to the months array and count
        $monthName = $monthNames[$month] ?? "Unknown";
        $results[$year]['months'][$monthName] = $count;
        $results[$year]['count'] += $count;
    }

    // Ensure every year has all months (even months with no data should be 0)
    foreach ($results as &$yearData) {
        // Loop through all months to check if any month is missing
        foreach ($monthNames as $monthNum => $monthName) {
            // If the month is not set, add it with a count of 0
            if (!isset($yearData['months'][$monthName])) {
                $yearData['months'][$monthName] = 0;
            }
        }
        // Ensure the months are sorted in the correct order
        ksort($yearData['months']);
    }

    return ['data' => $results, 'years' => $years];  // Return both the results and the years
}




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
