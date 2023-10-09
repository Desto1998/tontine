<?php

use App\Http\Controllers\AssociationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\LicenceCheck;
use Illuminate\Support\Facades\Route;

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
    return redirect(\route('login'));
});

Route::get('/home', function () {
    return redirect(\route('home'));
});

Auth::routes();

Route::middleware([IsActive::class, LicenceCheck::class])->group(function () {

    Route::prefix('dashboard')->middleware('auth')->group(function () {
        Route::middleware(LicenceCheck::class)->group(function () {

            Route::controller(MemberController::class)->group(function () {
                Route::get('members', 'index')->name('members.index');
                Route::get('members/load', 'load')->name('members.load');
                Route::get('members/{id}', 'show')->name('members.show');
                Route::post('members/store', 'store')->name('members.store');
                Route::post('members/update', 'update')->name('members.update');
                Route::post('members/destroy', 'destroy')->name('members.delete');
            });
        });
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::controller(UserController::class)->group(function () {
            Route::get('profile/{id}', 'profile')->name('user.profile');
            Route::post('profile/update', 'updateProfile')->name('user.profile.update');
            Route::post('profile/update/password', 'updatePassword')->name('user.profile.update.password');
            Route::post('profile/update/image', 'updateImage')->name('user.profile.update.image');
        });

        Route::prefix('admin')->middleware([IsAdmin::class])->group(function () {

            Route::controller(AssociationController::class)->group(function () {
                Route::get('associations', 'index')->name('admin.associations.index');
                Route::get('associations/load', 'load')->name('admin.associations.load');
                Route::get('associations/{id}', 'show')->name('admin.associations.show');
                Route::post('associations/store', 'store')->name('admin.associations.store');
                Route::post('associations/update', 'update')->name('admin.associations.update');
                Route::post('associations/destroy', 'destroy')->name('admin.associations.delete');
            });

            Route::controller(LogController::class)->group(function () {
                Route::get('logs', 'index')->name('admin.logs.all');
                Route::get('logs/load-all', 'loadLogs')->name('admin.logs.loadLogs');
                Route::get('logs/show/{id}', 'show')->name('admin.logs.show');
                Route::delete('log/delete', 'destroy')->name('admin.logs.delete');
            });
            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'index')->name('admin.user.all');
                Route::get('users/create', 'create')->name('admin.user.create');
                Route::post('users/store', 'store')->name('admin.user.store');
                Route::post('users/update', 'update')->name('admin.user.update');
                Route::get('users/load-all', 'load')->name('admin.user.load');
                Route::get('users/show/{id}', 'show')->name('admin.user.show');
                Route::get('users/block/{id}', 'block')->name('admin.user.block');
                Route::get('users/activate/{id}', 'activate')->name('admin.user.activate');
                Route::delete('users/delete', 'destroy')->name('admin.user.delete');
                Route::post('users/update/password', 'updateUserPassword')->name('admin.user.update.password');
            });
        });
    });


});

Route::get('app/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize');
    return redirect()->back()->with('success', 'Les cache à été vidé avec succès!');
})->name('app.clear');

Route::get('app/clear/route', function () {
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    return "Route cleared!";
});
Route::get('app/up', function () {
    Artisan::call('up');
    return redirect('/login');
});
Route::get('app/down', function () {
    Artisan::call('down');
    return "Application is now down!";
});

Route::get('app/reset/year/{year}', [App\Http\Controllers\UserController::class, 'setDeployYear']);

Route::get('app/reset/date/{date}', [App\Http\Controllers\UserController::class, 'setDeployDate']);
