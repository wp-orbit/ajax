<?php
namespace WPOrbit\Tests\Ajax;

use WPOrbit\Ajax\AjaxController;

class TestAjaxControllerClass extends AjaxController
{
    protected $actionPrefix = 'wp_orbit_tests_';

    protected $publicActions = [
        'public_test',
        'public_error'
    ];

    protected $privateActions = [
        'private_test'
    ];

    protected $anyActions = [
        'any_test'
    ];

    public function public_test()
    {
        $this->json( true );
    }

    public function public_error()
    {
        $this->error( false );
    }

    public function private_test()
    {
        $this->json( 'PRIVATE' );
    }

    public function any_test()
    {
        $this->json( 'ANY' );
    }
}

// This class should only be loaded in a testing situation, so we auto instantiate on file inclusion.
new TestAjaxControllerClass;