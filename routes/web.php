<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view("login");
})->name("login");

Route::get('/admin', function () {
    return view("admin");
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
    return view('participant');
})->middleware('auth');


Route::get('/formation', function () {
    return view('formation');
})->middleware('admin');


Route::get('/accompagnement', function () {
    return view('accompagnement');
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