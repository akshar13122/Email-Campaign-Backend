<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    then: function () {
        Route::middleware('web')->group(base_path('routes/rolesRoute.php'));
        Route::middleware('web')->group(base_path('routes/serviceRoute.php'));
        Route::middleware('web')->group(base_path('routes/contactRoute.php'));
        Route::middleware('web')->group(base_path('routes/contactListRoute.php'));
        Route::middleware('web')->group(base_path('routes/contactContactListRoute.php'));
        Route::middleware('web')->group(base_path('routes/campaignRoute.php'));
        Route::middleware('web')->group(base_path('routes/campaignRecipientRoute.php'));
        Route::middleware('web')->group(base_path('routes/addUserRoute.php'));
    },
)
    ->withMiddleware(function (Middleware $middleware): void {

         $middleware->append(HandleCors::class);

          $middleware->validateCsrfTokens(except: [
            'postuser',
             'updateuser/*',
             'deleteuser/*',
             'getusers',
             'createProject',
             'getprojects',
             'roles/post',
             '/roles/get',
             'updateRoute/*',
             'deleteRoute/*',
             '/service/post',
             '/service/get',
             'updateService/*',
             'deleteService/*',
            //  contact
             '/contact/post','/contact/get','updateContact/*','deleteContact/*',
            // Contact List
            '/contact-list/post', '/contact-list/get' ,
            '/update-contact-list/*' , '/delete-contact-list/*', '/contact-list-by-id/get/*',
            //Contact-Contact-list
            '/contact-contact-llist','ontact-contact-llist/*','contact-contact-llist-delete/*',
            'contact-contact-llist-excluded/*',

            //campaign
            '/campaign/post','/campaign/get', 'update-campaign/*' , '/delete-campaign/*' , '/get-campaign/*' ,
             '/send-campaign/*',

            //campaign recipients
            '/campaign/generate-recipients/*' , '/campaign/get-recipients/*',

            //Add user
            '/campaign/add-user' , '/campaign/get-user' , '/campaign/update-user/*'  , '/campaign/delete-user/*' , '/login-user'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
    })->create();
