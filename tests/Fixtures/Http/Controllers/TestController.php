<?php

namespace Wotta\IlluminateExtender\Tests\Fixtures\Http\Controllers;

class TestController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        return 'hello';
    }
}
