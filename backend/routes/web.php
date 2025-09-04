<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MushroomController;
use App\Http\Controllers\Admin\NegativeController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PositiveController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::resource('mushrooms', MushroomController::class,[
        'names' => [
            'index'=>'admin.mushrooms.index',
            'create'=>'admin.mushrooms.create',
            'update'=>'admin.mushrooms.update',
            'destroy'=>'admin.mushrooms.destroy',
            'store'=>'admin.mushrooms.store',
            'edit'=>'admin.mushrooms.edit',
            'show'=>'admin.mushrooms.show'
        ]
    ]);
    Route::resource('positives', PositiveController::class,[
        'names' => [
            'index'=>'admin.positives.index',
            'create'=>'admin.positives.create',
            'update'=>'admin.positives.update',
            'destroy'=>'admin.positives.destroy',
            'store'=>'admin.positives.store',
            'edit'=>'admin.positives.edit',
            'show'=>'admin.positives.show'

        ]
    ]);
    Route::resource('negatives', NegativeController::class,[
        'names' => [
            'index'=>'admin.negatives.index',
            'create'=>'admin.negatives.create',
            'update'=>'admin.negatives.update',
            'destroy'=>'admin.negatives.destroy',
            'store'=>'admin.negatives.store',
            'edit'=>'admin.negatives.edit',
            'show'=>'admin.negatives.show'
        ]
    ]);
    Route::resource('plans', PlanController::class,[
        'names' => [
            'index'=>'admin.plans.index',
            'create'=>'admin.plans.create',
            'update'=>'admin.plans.update',
            'destroy'=>'admin.plans.destroy',
            'store'=>'admin.plans.store',
            'edit'=>'admin.plans.edit',
            'show'=>'admin.plans.show'
        ]
    ]);
});
