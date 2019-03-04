<?php

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

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::group(['middleware' => ['web']], function () {
        /* Pages */
        Route::name('home')->get('/', 'HomeController@index');
        

        if(app()->getLocale() == 'tr'){
            Route::name('articles.index')->get('/haberler', 'ArticlesController@index');
            Route::name('articles.detail')->get('/haberler/{url}', 'ArticlesController@detail');
        }else{
            Route::name('articles.index')->get('/news', 'ArticlesController@index');
            Route::name('articles.detail')->get('/news/{url}', 'ArticlesController@detail');
        }

        Route::name('validate-mailgun')->get('/validate-mailgun/{email}', 'ValidationController@validateMailgun');
        /*Mails*/
        Route::name('mail.contact')->post('/contact', 'EmailController@contact');
        Route::name('mail.job')->post('/job', 'EmailController@job');
        Route::name('mail.quote')->post('/quote', 'EmailController@quote');
        Route::name('mail.request-offer')->post('/request-offer', 'EmailController@offer');
    });
});

Auth::routes();

Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
    Route::prefix(config('app.cms_path'))->middleware('auth')->as('cms.')->namespace('Cms')->group(function(){
        Route::name('home')->get('/home', 'HomeController@index');
        Route::name('search')->get('/search', 'SearchController@search');
        Route::name('change-settings')->post('/settings', 'UserProfileController@changeSettings');
        Route::name('change-profile-photo.index')->get('/change-profile-photo', 'UserProfileController@changeProfilePhoto');
        Route::name('change-profile-photo.store')->post('/change-profile-photo', 'UserProfileController@storeProfilePhoto');

        Route::name('tasks.index')->get('/tasks', 'TasksController@index');
        Route::name('tasks.store')->post('/tasks', 'TasksController@store');
        Route::name('tasks.update')->post('/tasks/update', 'TasksController@update');
        Route::name('tasks.fetch')->get('/tasks/fetch', 'TasksController@fetch');
        Route::name('tasks.order')->post('/tasks/order', 'TasksController@order');
        Route::name('tasks.orderCompleted')->post('/tasks/orderCompleted', 'TasksController@orderCompleted');

        Route::prefix('user-management')->as('user-management.')->namespace('UserManagement')->group(function(){
            Route::name('roles.index')->get('/roles', 'RolesController@index');
            Route::name('roles.store')->post('/roles', 'RolesController@store');
            Route::name('roles.create')->get('/roles/create', 'RolesController@create');
            Route::name('roles.edit')->get('/roles/{role}/edit', 'RolesController@edit');
            Route::name('roles.update')->put('/roles/{role}', 'RolesController@update');
            Route::name('roles.delete')->delete('/roles/{role}', 'RolesController@delete');

            Route::name('permissions.index')->get('/permissions', 'PermissionsController@index');
            Route::name('permissions.create')->get('/permissions/create', 'PermissionsController@create');
            Route::name('permissions.store')->post('/permissions', 'PermissionsController@store');
            Route::name('permissions.edit')->get('/permissions/{permission}/edit', 'PermissionsController@edit');
            Route::name('permissions.update')->put('/permissions/{permission}', 'PermissionsController@update');
            Route::name('permissions.delete')->delete('/permissions/{permission}', 'PermissionsController@delete');

            Route::name('users.index')->get('/users', 'UsersController@index');
            Route::name('users.store')->post('/users', 'UsersController@store');
            Route::name('users.create')->get('/users/create', 'UsersController@create');
            Route::name('users.edit')->get('/users/{user}/edit', 'UsersController@edit');
            Route::name('users.update')->put('/users/{user}', 'UsersController@update');
            Route::name('users.delete')->delete('/users/{invitee}', 'UsersController@delete');
            Route::name('users.ban')->put('/users/{user}/ban', 'UsersController@ban');
            Route::name('users.reactivate')->put('/users/{user}/reactivate', 'UsersController@reactivate');
        });

        Route::prefix('forms')->as('forms.')->namespace('Forms')->group(function(){
            Route::name('index')->get('/', 'FormsController@index');
            Route::name('store')->post('/', 'FormsController@store');
            Route::name('create')->get('/create', 'FormsController@create');
            Route::name('edit')->get('/{form}/edit', 'FormsController@edit');
            Route::name('update')->put('/{form}', 'FormsController@update');
            Route::name('delete')->delete('/{form}', 'FormsController@delete');

            Route::name('categories.store')->post('/categories', 'CategoriesController@store');
            Route::name('categories.create')->get('/categories/{form}/create', 'CategoriesController@create');
            Route::name('categories.edit')->get('/categories/{category}/edit', 'CategoriesController@edit');
            Route::name('categories.update')->put('/categories/{category}', 'CategoriesController@update');
            Route::name('categories.delete')->delete('/categories/{category}', 'CategoriesController@delete');
        });

        Route::prefix('inbox')->as('inbox.')->namespace('Inbox')->group(function(){
            Route::name('index')->get('/', 'InboxController@index');
            Route::name('sent')->get('/sent', 'InboxController@sent');
            Route::name('trash')->get('/trash', 'InboxController@trash');
            Route::name('important')->get('/important', 'InboxController@important');
            Route::name('drafts')->get('/drafts', 'InboxController@drafts');
            Route::name('form')->get('/form/{form}', 'InboxController@form');
            Route::name('category')->get('/category/{category}', 'InboxController@category');
            Route::name('detail')->get('/{mail}/detail', 'InboxController@detail');
            Route::name('edit')->get('/{mail}/edit', 'InboxController@edit');
            Route::name('reply')->get('/{mail}/reply', 'InboxController@reply');
            Route::name('compose')->get('/compose', 'InboxController@compose');
            Route::name('search')->get('/search', 'InboxController@search');

            Route::name('send')->post('/send', 'InboxController@send');
            Route::name('save-draft')->post('/save-draft', 'InboxController@saveDraft');
            Route::name('update')->post('/{mail}/update', 'InboxController@update');
            Route::name('delete')->put('/delete', 'InboxController@delete');
            Route::name('discard')->delete('/discard', 'InboxController@discard');
            Route::name('mark-as-important')->post('/mark-as-important', 'InboxController@markAsImportant');
            Route::name('mark-as-read')->post('/mark-as-read', 'InboxController@markAsRead');
            Route::name('mark-as-trash')->post('/mark-as-trash', 'InboxController@markAsTrash');
            Route::name('move-to-trash')->post('/{mail}/move-to-trash', 'InboxController@moveToTrash');
        });

        Route::prefix('file-manager')->as('file-manager.')->namespace('FileManager')->group(function(){
            Route::name('index')->get('/', 'FileManagerController@index');
            Route::name('store')->post('/', 'FileManagerController@store');
            Route::name('detail')->get('/{folder}/detail', 'FileManagerController@detail');
            Route::name('delete')->delete('/{file}', 'FileManagerController@delete');
            Route::name('categories.store')->post('/categories', 'CategoriesController@store');
        });

        Route::prefix('articles')->as('articles.')->namespace('Articles')->group(function(){
            Route::name('index')->get('/', 'ArticlesController@index');
            Route::name('store')->post('/', 'ArticlesController@store');
            Route::name('create')->get('/create', 'ArticlesController@create');
            Route::name('sort')->get('/sort', 'ArticlesController@sort');
            Route::name('sort-records')->post('/sort-records', 'ArticlesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ArticlesController@edit');
            Route::name('update')->put('/{record}', 'ArticlesController@update');
            Route::name('delete')->delete('/{record}', 'ArticlesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ArticlesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ArticlesController@togglePromotion');

            Route::name('gallery')->get('/{record}/gallery', 'GalleryController@index');
            Route::name('gallery.edit')->get('/gallery/{record}/edit', 'GalleryController@edit');
            Route::name('gallery.update')->put('/gallery/{record}', 'GalleryController@update');
            Route::name('gallery.store')->post('/gallery', 'GalleryController@store');
            Route::name('gallery.delete')->delete('/gallery/{record}/delete', 'GalleryController@delete');
            Route::name('gallery.sort-records')->post('/gallery/sort-records', 'GalleryController@sortRecords');
        });

        Route::prefix('employees')->as('employees.')->namespace('Employees')->group(function(){
            Route::name('index')->get('/', 'EmployeesController@index');
            Route::name('store')->post('/', 'EmployeesController@store');
            Route::name('create')->get('/create', 'EmployeesController@create');
            Route::name('sort')->get('/sort', 'EmployeesController@sort');
            Route::name('sort-records')->post('/sort-records', 'EmployeesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'EmployeesController@edit');
            Route::name('update')->put('/{record}', 'EmployeesController@update');
            Route::name('delete')->delete('/{record}', 'EmployeesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'EmployeesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'EmployeesController@togglePromotion');
        });

        Route::prefix('general-catalogs')->as('general-catalogs.')->namespace('Catalogs')->group(function(){
            Route::name('index')->get('/', 'CatalogsController@index');
            Route::name('store')->post('/', 'CatalogsController@store');
            Route::name('create')->get('/create', 'CatalogsController@create');
            Route::name('sort')->get('/sort', 'CatalogsController@sort');
            Route::name('sort-records')->post('/sort-records', 'CatalogsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'CatalogsController@edit');
            Route::name('update')->put('/{record}', 'CatalogsController@update');
            Route::name('delete')->delete('/{record}', 'CatalogsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'CatalogsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'CatalogsController@togglePromotion');
        });

        


        Route::prefix('main-settings')->as('main-settings.')->namespace('MainSettings')->group(function(){
            Route::name('index')->get('/', 'MainSettingsController@index');
            Route::name('store')->post('/', 'MainSettingsController@store');
            Route::name('create')->get('/create', 'MainSettingsController@create');
            Route::name('sort')->get('/sort', 'MainSettingsController@sort');
            Route::name('sort-records')->post('/sort-records', 'MainSettingsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'MainSettingsController@edit');
            Route::name('update')->put('/{record}', 'MainSettingsController@update');
            Route::name('delete')->delete('/{record}', 'MainSettingsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'MainSettingsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'MainSettingsController@togglePromotion');
        });

        

        Route::prefix('product-images')->as('product-images.')->namespace('ProductImages')->group(function(){
            Route::name('index')->get('/', 'ProductImagesController@index');
            Route::name('store')->post('/', 'ProductImagesController@store');
            Route::name('create')->get('/create', 'ProductImagesController@create');
            Route::name('sort')->get('/sort', 'ProductImagesController@sort');
            Route::name('sort-records')->post('/sort-records', 'ProductImagesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ProductImagesController@edit');
            Route::name('update')->put('/{record}', 'ProductImagesController@update');
            Route::name('delete')->delete('/{record}', 'ProductImagesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ProductImagesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ProductImagesController@togglePromotion');
        });

       

        Route::prefix('popups')->as('popups.')->namespace('Popups')->group(function(){
            Route::name('index')->get('/', 'PopupsController@index');
            Route::name('store')->post('/', 'PopupsController@store');
            Route::name('create')->get('/create', 'PopupsController@create');
            Route::name('sort')->get('/sort', 'PopupsController@sort');
            Route::name('sort-records')->post('/sort-records', 'PopupsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'PopupsController@edit');
            Route::name('update')->put('/{record}', 'PopupsController@update');
            Route::name('delete')->delete('/{record}', 'PopupsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'PopupsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'PopupsController@togglePromotion');
        });

        Route::prefix('sliders')->as('sliders.')->namespace('Sliders')->group(function(){
            Route::name('index')->get('/', 'SlidersController@index');
            Route::name('store')->post('/', 'SlidersController@store');
            Route::name('create')->get('/create', 'SlidersController@create');
            Route::name('sort')->get('/sort', 'SlidersController@sort');
            Route::name('sort-records')->post('/sort-records', 'SlidersController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'SlidersController@edit');
            Route::name('update')->put('/{record}', 'SlidersController@update');
            Route::name('delete')->delete('/{record}', 'SlidersController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'SlidersController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'SlidersController@togglePromotion');
        });
    });
});