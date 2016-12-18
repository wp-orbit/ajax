<?php
namespace WPOrbit\Tests\Ajax;

use WPOrbit\Ajax\AjaxController;

class ExampleAjaxControllerClass extends AjaxController
{
    // Define an action prefix.
    protected $actionPrefix = 'wp_orbit_tests_';

    // Define publicly accessible actions.
    protected $publicActions = [
        'public_test',
        'public_error'
    ];

    // Define privately accessible actions (must be logged in).
    protected $privateActions = [
        'private_test'
    ];

    // Define actions for users either logged in or not.
    protected $anyActions = [
        'any_test'
    ];

    // Declare the callback for "public_test".
    public function public_test()
    {
        // Send a json response of "true", with HTTP status code 200.
        $this->json( true );
    }

    // Declare the callback for "public_error".
    public function public_error()
    {
        // Send a json response of "false", with HTTP status error code 400.
        $this->error( false );
    }

    // Declare the callback for "private_test".
    public function private_test()
    {
        // Send a json response of string "PRIVATE", with HTTP status code 200.
        $this->json( 'PRIVATE' );
    }

    // Declare the callback for "any_test".
    public function any_test()
    {
        // Send a json response of string "ANY", with HTTP status code 200.
        $this->json( 'ANY' );
    }
}

// This class should only be loaded in a testing situation, so we auto instantiate on file inclusion.
new ExampleAjaxControllerClass;