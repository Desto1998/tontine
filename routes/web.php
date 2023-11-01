<?php

use App\Http\Controllers\AssociationController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SanctionsController;
use App\Http\Controllers\SessionsController;
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
                Route::delete('members/destroy', 'destroy')->name('members.delete');
            });

            Route::controller(FundController::class)->group(function () {
                Route::get('fund', 'index')->name('fund.index');
                Route::get('fund/load', 'load')->name('fund.load');
                Route::get('fund/{id}', 'show')->name('fund.show');
                Route::post('fund/store', 'store')->name('fund.store');
                Route::post('fund/update', 'update')->name('fund.update');
                Route::delete('fund/destroy', 'destroy')->name('fund.delete');
            });

            Route::controller(SanctionsController::class)->group(function () {
                Route::get('sanction', 'index')->name('sanction.index');
                Route::get('sanction/load', 'load')->name('sanction.load');
                Route::get('sanction/{id}', 'show')->name('sanction.show');
                Route::post('sanction/store', 'store')->name('sanction.store');
                Route::post('sanction/update', 'update')->name('sanction.update');
                Route::delete('sanction/destroy', 'destroy')->name('sanction.delete');
            });

            Route::controller(ContributionController::class)->group(function () {
                Route::get('contribution', 'index')->name('contribution.index');
                Route::get('contribution/load', 'load')->name('contribution.load');
                Route::get('contribution/{id}', 'show')->name('contribution.show');
                Route::post('contribution/store', 'store')->name('contribution.store');
                Route::post('contribution/update', 'update')->name('contribution.update');
                Route::delete('contribution/destroy', 'destroy')->name('contribution.delete');
            });

            Route::controller(LoanController::class)->group(function () {
                Route::get('loan', 'index')->name('loan.index');
                Route::get('loan/load', 'load')->name('loan.load');
                Route::get('loan/{id}', 'show')->name('loan.show');
                Route::post('loan/store', 'store')->name('loan.store');
                Route::post('loan/update', 'update')->name('loan.update');
                Route::delete('loan/destroy', 'destroy')->name('loan.delete');
            });

            Route::controller(SessionsController::class)->group(function () {
                Route::get('sessions', 'index')->name('sessions.index');
                Route::get('sessions/load', 'load')->name('sessions.load');
                Route::get('sessions/{id}', 'show')->name('sessions.show');
                Route::get('sessions/edit/{id}', 'edit')->name('sessions.edit');
                Route::post('sessions/store', 'store')->name('sessions.store');
                Route::post('sessions/update', 'update')->name('sessions.update');
                Route::delete('sessions/destroy', 'destroy')->name('sessions.delete');

                Route::delete('sessions/member/destroy', 'deleteSessionMember')->name('member-session-delete');
                Route::post('sessions/member/taken', 'markAsTaken')->name('sessions.member.taken');
                Route::post('sessions/member/update', 'updateSessionMember')->name('sessions.member.update');

                Route::get('sessions/print/{id}', 'print')->name('sessions.print');

            });

            Route::controller(MeetingController::class)->group(function () {
                Route::get('meeting', 'index')->name('meeting.index');
                Route::get('meeting/load', 'load')->name('meeting.load');
                Route::get('meeting/create', 'create')->name('meeting.create');
                Route::get('meeting/{id}', 'show')->name('meeting.show');
                Route::get('meeting/edit/{id}', 'edit')->name('meeting.edit');
                Route::post('meeting/store', 'store')->name('meeting.store');
                Route::post('meeting/update', 'update')->name('meeting.update');
                Route::delete('meeting/destroy', 'destroy')->name('meeting.delete');
                Route::delete('meeting/sanction/destroy', 'deleteMeetingSanction')->name('meeting.sanction.delete');
                Route::delete('meeting/member/winner/destroy', 'deleteMeetingMemberWinner')->name('meeting.member.winner.delete');

                Route::post('meeting/member/session/store', 'storeMeetingMemberContribution')->name('meeting.member.session.store');
                Route::post('meeting/member/sanction/store', 'storeMeetingMemberSanction')->name('meeting.member.sanction.store');
                Route::post('meeting/member/winner/store', 'storeMeetingMemberWinner')->name('meeting.member.winner.store');

                Route::delete('meeting/member/destroy', 'deleteSessionMember')->name('meeting-member-delete');
                Route::post('meeting/member/taken', 'markAsTaken')->name('meeting.member.taken');
                Route::post('meeting/member/update', 'updateSessionMember')->name('meeting.member.update');

                Route::get('meeting/print/{id}', 'print')->name('meeting.print');

            });


            Route::get('association/detail', [App\Http\Controllers\AssociationController::class, 'editForm'])->name('association.detail');
            Route::post('association/my/update', [App\Http\Controllers\AssociationController::class, 'updateMy'])->name('association.my.update');

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
                Route::delete('associations/destroy', 'destroy')->name('admin.associations.delete');
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
Route::get('app/reset/duration/{number}', [App\Http\Controllers\UserController::class, 'setLicenceDays']);
