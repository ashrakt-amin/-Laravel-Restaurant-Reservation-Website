<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UI\MenuController;
use App\Http\Controllers\UI\WelcomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\UI\CategoryController;
use App\Http\Controllers\UI\ReservationController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminReservationController;

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

Route::get('/',[WelcomeController::class,'index']);
Route::get('/categories',[CategoryController::class,'index'])->name('ui.categories.index');
Route::get('/categories/{categories}',[CategoryController::class,'show'])->name('ui.categories.show');
Route::get('/menus',[MenuController::class,'index'])->name('ui.menus.index');
Route::get('/breakfast/{id}',[MenuController::class,'breakfast'])->name('ui.menus.Breakfast');
Route::get('/lunch/{id}',[MenuController::class,'lunch'])->name('ui.menus.Lunch');
Route::get('/dessert/{id}',[MenuController::class,'dessert'])->name('ui.menus.dessert');
Route::get('/drinks/{id}',[MenuController::class,'drinks'])->name('ui.menus.drinks');
Route::get('/special/{id}',[MenuController::class,'special'])->name('ui.menus.special');



Route::get('/reservation', [ReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/store', [ReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [ReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/store-two', [ReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','admin'])->name('admin.')->prefix('admin')->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('index');
    Route::resource('/categories',AdminCategoryController::class);
  
    Route::get('/menus/breakfast',[AdminMenuController::class,'breakfast'])->name('menus.Breakfast');
    Route::get('/menus/lunch',[AdminMenuController::class,'lunch'])->name('menus.Lunch');
    Route::get('/menus/dessert',[AdminMenuController::class,'dessert'])->name('menus.dessert');
    Route::get('/menus/drink',[AdminMenuController::class,'drink'])->name('menus.drinks');
    Route::get('/menus/special',[AdminMenuController::class,'special'])->name('menus.special');
    Route::resource('/menus',AdminMenuController::class);
    Route::resource('/tables',TableController::class);
    Route::resource('/reservations',AdminReservationController::class);


});

require __DIR__.'/auth.php';
