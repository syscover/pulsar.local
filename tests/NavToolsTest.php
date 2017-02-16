<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;

class NavToolsTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testBasicTest()
//    {
//        $response = $this->get('/');
//
//
//        $response->assertResponseOk();
//    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Route::get('/es-us/this/is/a/test', function (){
            //
        });


        $response = $this->call('GET','/es-us/this/is/a/test');

        $this->assertResponseOk();
    }
}
