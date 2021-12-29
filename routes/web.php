<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;





// Non Authenticated access group
Route::middleware(['guest', 'preventBackHistory'])->group(function(){

  Route::prefix('/user')->name('user.')->group(function(){
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/create', [UserController::class, 'create'])->name('create');
    Route::post('/check', [UserController::class, 'check'])->name('check');
  });

});





// Authenticated access group
Route::middleware(['auth', 'preventBackHistory'])->group(function(){

  // this route to create the admin first time using this application
  Route::get('/create_admin', [UserController::class, 'createAdmin']);

  // these routs for admin api to create roles, permissions and assigning to users
  Route::middleware('role:admin')->group(function(){
    Route::get('/admin/create_role', [UserController::class, 'createRole']);
    Route::get('/admin/create_permission', [UserController::class, 'createPermission']);
    Route::get('admin/give_permission_to', [UserController::class, 'givePermissionTo']);
    Route::get('admin/make_writer', [UserController::class, 'makeWriter']);
    Route::get('admin/make_editor', [UserController::class, 'makeEditor']);
    Route::get('admin/make_publisher', [UserController::class, 'makePublisher']);
  });

  Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');
  Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');

  Route::prefix('posts')->name('posts.')->group(function(){
    // for all authenticated users
    Route::get('/', [PostController::class, 'home'])->name('home');

    // routes for the writers
    Route::middleware(['role:writer|admin'])->group(function(){
      Route::get('/create', [PostController::class, 'createPost'])->name('create');
      Route::post('/save_post', [PostController::class, 'savePost'])->name('save');
    });

    // routes for the publishers
    Route::middleware(['role:publisher|admin'])->group(function(){
      Route::get('/reviews', [PostController::class, 'underReview'])->name('reviews');
      Route::get('/publish/{id}', [PostController::class, 'publish'])->name('publish');
      Route::get('/sendToEdit/{id}', [PostController::class, 'sendToEdit'])->name('editable');
    });

    // routes for the editors
    Route::middleware(['role:editor|admin'])->group(function(){
      Route::get('/edits', [PostController::class, 'underEdit'])->name('edits');
      Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
      Route::post('/update/{id}', [PostController::class, 'update'])->name('update');
      Route::get('/cancelEdit', [PostController::class, 'cancelEdit'])->name('cancelEdit');
    });

    // routes for the writers and publishers
    Route::get('/sendToReview/{id}', [PostController::class, 'sendToReview'])->name('reviewable')->middleware('role:writer|editor|admin');

    // routes for the writers and editors
    Route::get('/delete/{id}', [PostController::class, 'delete'])->name('delete')->middleware('role:writer|publisher|admin');

  });

});
