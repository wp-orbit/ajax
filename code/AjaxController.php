<?php
namespace WPOrbit\Ajax;

/**
 * Class AjaxController
 * @package WPOrbit\Ajax
 */
abstract class AjaxController
{
    /**
     * @var string A unique string which group this controller's actions.
     */
    protected $actionPrefix = '';

    /**
     * @var array An array of wp-ajax action keys that should be bound to logged-in users only.
     */
    protected $privateActions = [];

    /**
     * @var array An array of wp-ajax actions keys that should be bound to not-logged-in users only.
     */
    protected $publicActions = [];

    /**
     * @var array An array of wp-ajax actions that should be bound to either logged-in or not-logged-in users.
     */
    protected $anyActions = [];

    /**
     * Register WPOrbit tests callbacks.
     */
    protected function bindTestCallbacks()
    {
        // Check for the presence of the 'wp_orbit_testing' key.
        if ( isset( $_GET['wp_orbit_testing'] ) || isset( $_POST['wp_orbit_testing'] ) )
        {

        }
    }

    protected function isBound( $ajaxRole, $callback )
    {
        // Declare $data.
        $data = false;

        // Get bindings.
        if ( 'wp_ajax' === $ajaxRole ) {
            $data = Ajax::getInstance()->getPrivateActions();
        }

        if ( 'wp_ajax_nopriv' === $ajaxRole ) {
            $data = Ajax::getInstance()->getPublicActions();
        }

        // No bindings, return false.
        if ( ! $data ) {
            return false;
        }

        // Loop through bindings.
        foreach( $data as $binding )
        {
            if (
                $callback === $binding['action'] &&
                $this->actionPrefix === $binding['prefix'] &&
                static::class === $binding['class']
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Loops through an array of action strings, each of which should match a callable method on the extending class.
     * @param $actionsArray array An array of ajax actions.
     * @param $ajaxRole 'wp_ajax', 'wp_ajax_nopriv'
     * @throws \Exception
     */
    protected function bindAjaxActions( $actionsArray, $ajaxRole )
    {
        // Loop through private actions.
        foreach( $actionsArray as $actionKey => $methodCallback )
        {
            // If the method exists on the extending class, call it.
            if ( method_exists( $this, $methodCallback ) )
            {
                // Don't apply this binding if it already exists.
                if ( $this->isBound( $ajaxRole, $methodCallback ) ) {
                    continue;
                }

                //die( "{$this->actionPrefix}{$methodCallback}" );
                // Bind the action callback.
                add_action( "{$ajaxRole}_{$this->actionPrefix}{$methodCallback}", function() use ( $methodCallback, $actionKey )
                {
                    // WP Orbit Ajax tests need special loading when making
                    // requests from PHPUnit; so this registers that state.
                    $this->bindTestCallbacks();

                    // Run the callback.
                    $this->{$methodCallback}();
                });

                // Bind the action into the main Ajax class container.
                if ( 'wp_ajax' === $ajaxRole ) {
                    Ajax::getInstance()->addPrivateAction( $this->actionPrefix, $methodCallback, static::class );
                }
                if ( 'wp_ajax_nopriv' === $ajaxRole ) {
                    Ajax::getInstance()->addPublicAction( $this->actionPrefix, $methodCallback, static::class );
                }
            }

            // The method doesn't exist on the extending class, so throw an exception.
            else
            {
                $className = __CLASS__;
                throw new \Exception( "Method: {$methodCallback} does not exist on class {$className}." );
            }
        }
    }

    /**
     * Loop through all private actions and hook the appropriate ajax callback.
     */
    protected function bindPrivateActions()
    {
        $this->bindAjaxActions( $this->privateActions, 'wp_ajax' );
    }

    /**
     * Loop through all public actions and hook the appropriate ajax callback.
     */
    protected function bindPublicActions()
    {
        $this->bindAjaxActions( $this->publicActions, 'wp_ajax_nopriv' );
    }

    /**
     * Loop through the any actions array and hook each to both public and private callbacks.
     */
    protected function bindAnyActions()
    {
        $this->bindAjaxActions( $this->publicActions, 'wp_ajax_nopriv' );
        $this->bindAjaxActions( $this->privateActions, 'wp_ajax' );
    }

    /**
     * AjaxHandler constructor.
     */
    public function __construct()
    {
        $this->bindPublicActions();
        $this->bindPrivateActions();
        $this->bindAnyActions();
    }

    /**
     * Send a JSON error response and terminate request.
     * @param array $data
     * @param int $httpCode
     */
    protected function error( $data = [], $httpCode = 400 )
    {
        Ajax::getInstance()->setHttpCode( $httpCode );
        Ajax::getInstance()->setJson();
        echo json_encode( $data );
        exit;
    }

    /**
     * Send a JSON response and terminate request.
     * @param array $data
     * @param int $httpCode
     */
    protected function json( $data = [], $httpCode = 200 )
    {
        Ajax::getInstance()->setHttpCode( $httpCode );
        Ajax::getInstance()->setJson();
        echo json_encode( $data );
        exit;
    }
}