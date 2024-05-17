<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\User;
use  \Illuminate\Support\Facades\Log;
use \App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//    $maxId = User::max('id');
//    return User::with('posts')->orderBy('id')->where('id',$maxId)->first() ;
//    return ['sumPoint' => User::sum('point')];
//    return User::select('id', 'email as user_email')->where('is_active', 0)->get()->map(function ($user) {
//        return $user->user_email;
//    });
    $users = User::with('posts')->get()[0]->posts->map(function ($post) {
        return $post->title;
    });
//    $users->append('address');
    return $users;
});

Route::get('/about', function () {
    return view('welcome');
});

Route::get('/contact/{contactId}/{name}', function ($contactId, $name) {
    return 'Contact ID: ' . $contactId . ' Name: ' . $name;
});

Route::get('/post/{id}', [PostController::class, 'findByUserId']);

Route::resource('posts', PostController::class);

Route::resource('users', UserController::class);
