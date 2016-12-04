<?php
/**
 * Class AjaxControllerTest
 * @see \WPOrbit\Ajax\AjaxController
 * @see \WPOrbit\Tests\Ajax\TestAjaxControllerClass
 */
class AjaxControllerTest extends \WPOrbit\Tests\TestCase
{
    /** @var string Set on instantiation.  */
    public $ajaxUrl;

    // This is our actionPrefix key (defined in the AjaxController extension).
    public $ajaxAction = 'wp_orbit_tests_';

    // Setup the test.
    public function setUp()
    {
        // "wp_orbit_testing=1" is defined in the request URL so that WPOrbit knows
        // to load test dependencies which otherwise would not be included in a typical
        // request flow.

        // Set our ajax URL endpoint.
        $this->ajaxUrl = "http://wp-orbit-dev.wp/wp/wp-admin/admin-ajax.php?wp_orbit_testing=1&action={$this->ajaxAction}";
    }

    // Verify that our TestAjaxControllerClass AjaxController extension is hooking
    // into WordPress, and that it returns the expected JSON response.
    public function testCanHookAjaxRequests()
    {
        // Get response.
        $response = wp_remote_get( $this->ajaxUrl . 'public_test' );

        // We expect a json response of true.
        $this->assertEquals( 'true', $response['body'] );
        $this->assertEquals( 'application/json', $response['headers']['content-type'] );
    }

    // Verify that we get a JSON error response with an error code.
    public function testCanGetJsonError()
    {
        // Get response.
        $response = wp_remote_get( $this->ajaxUrl . 'public_error' );

        // We expect a json response of false with an error code of 400.
        $this->assertEquals( 'false', $response['body'] );
        $this->assertEquals( 400, $response['response']['code'] );
        $this->assertEquals( 'application/json', $response['headers']['content-type'] );
    }
}