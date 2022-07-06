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

Route::get('/', function () {
    return view('brackets/admin-auth::admin.auth.login');
});


Route::get('/', 'App\Http\Controllers\Admin\HomeController@dashboard');

Route::get('cedula/{cedula}','App\Http\Controllers\Admin\HelpsController@cedula')->name('cedula');

Route::post('test/', 'App\Http\Controllers\Admin\HelpsController@store')->name('store');

Route::get('/consulta', 'App\Http\Controllers\Admin\HomeController@consulta');

//Route::get('/helps/{help}/show', 'App\Http\Controllers\Admin\HelpsController@show');




/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('helps')->name('helps/')->group(static function() {
            Route::get('/',                                             'HelpsController@index')->name('index');
            Route::get('/create',                                       'HelpsController@create')->name('create');
            Route::get('/createadm',                                    'HelpsController@createadm')->name('createadm');
            // Route::post('/',                                          'HelpsController@store')->name('store');
            Route::post('/storeadm',                                    'HelpsController@storeadm');
            Route::get('/{help}/show',                                  'HelpsController@show')->name('show');
            Route::get('/{help}/createdetail',                          'HelpsController@createdetail')->name('createdetail');
            Route::get('/{help}/edit',                                  'HelpsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HelpsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{help}',                                      'HelpsController@update')->name('update');
            Route::delete('/{help}',                                    'HelpsController@destroy')->name('destroy');
            Route::get('{help}/showdetallepdf',                         'HelpsController@createPDF');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('helps/finalizadas')->name('helps/finalizadas')->group(static function() {
            Route::get('/',                                             'HelpsController@finalizadas')->name('finalizadas');
            Route::get('/create',                                       'HelpsController@create')->name('create');
            Route::get('/createadm',                                    'HelpsController@createadm')->name('createadm');
            // Route::post('/',                                          'HelpsController@store')->name('store');
            Route::post('/storeadm',                                    'HelpsController@storeadm');
            Route::get('/{help}/show',                                  'HelpsController@show')->name('show');
            Route::get('/{help}/createdetail',                          'HelpsController@createdetail')->name('createdetail');
            Route::get('/{help}/edit',                                  'HelpsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'HelpsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{help}',                                      'HelpsController@update')->name('update');
            Route::delete('/{help}',                                    'HelpsController@destroy')->name('destroy');
        });
    });
});



/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('states')->name('states/')->group(static function() {
            Route::get('/',                                             'StatesController@index')->name('index');
            Route::get('/create',                                       'StatesController@create')->name('create');
            Route::post('/',                                            'StatesController@store')->name('store');
            Route::get('/{state}/edit',                                 'StatesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'StatesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{state}',                                     'StatesController@update')->name('update');
            Route::delete('/{state}',                                   'StatesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('categories')->name('categories/')->group(static function() {
            Route::get('/',                                             'CategoriesController@index')->name('index');
            Route::get('/create',                                       'CategoriesController@create')->name('create');
            Route::post('/',                                            'CategoriesController@store')->name('store');
            Route::get('/{category}/edit',                              'CategoriesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CategoriesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{category}',                                  'CategoriesController@update')->name('update');
            Route::delete('/{category}',                                'CategoriesController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('detail-helps')->name('detail-helps/')->group(static function() {
            Route::get('/',                                             'DetailHelpsController@index')->name('index');
            Route::get('/create',                                       'DetailHelpsController@create')->name('create');
            Route::post('/',                                            'DetailHelpsController@store')->name('store');
            Route::get('/{detailHelp}/edit',                            'DetailHelpsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DetailHelpsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{detailHelp}',                                'DetailHelpsController@update')->name('update');
            Route::delete('/{detailHelp}',                              'DetailHelpsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
// Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
//     Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
//         Route::prefix('detail-helps')->name('detail-helps/')->group(static function() {
//             Route::get('/',                                             'DetailHelpsController@index')->name('index');
//             Route::get('/create',                                       'DetailHelpsController@create')->name('create');
//             Route::post('/',                                            'DetailHelpsController@store')->name('store');
//             Route::get('/{detailHelp}/edit',                            'DetailHelpsController@edit')->name('edit');
//             Route::post('/bulk-destroy',                                'DetailHelpsController@bulkDestroy')->name('bulk-destroy');
//             Route::post('/{detailHelp}',                                'DetailHelpsController@update')->name('update');
//             Route::delete('/{detailHelp}',                              'DetailHelpsController@destroy')->name('destroy');
//         });
//     });
// });


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('functionaries')->name('functionaries/')->group(static function() {
            Route::get('/',                                             'FunctionariesController@index')->name('index');
            Route::get('/create',                                       'FunctionariesController@create')->name('create');
            Route::post('/',                                            'FunctionariesController@store')->name('store');
            Route::get('/{functionary}/edit',                           'FunctionariesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'FunctionariesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{functionary}',                               'FunctionariesController@update')->name('update');
            Route::delete('/{functionary}',                             'FunctionariesController@destroy')->name('destroy');
        });
    });
});
