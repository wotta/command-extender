<?php

use Illuminate\Support\Facades\Route;
use Wotta\CommandExtender\Http\Controllers\TestController;

Route::get('test_url', TestController::class.'@index');
