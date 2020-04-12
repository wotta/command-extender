<?php

use Illuminate\Support\Facades\Route;
use Wotta\IlluminateExtender\Tests\Fixtures\Http\Controllers\TestController;

Route::get('test_url', TestController::class.'@index');
