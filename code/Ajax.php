<?php
namespace WPOrbit\Ajax;

/**
 * Class Ajax
 * @package WPOrbit\Ajax
 */
class Ajax
{
    /**
     * @var array An array of ajax action strings which are bound to logged-in-users.
     */
    protected $privateActions = [];

    /**
     * @var array An array of ajax action strings which are bound to unauthenticated users.
     */
    protected $publicActions = [];

    /**
     * @return array
     */
    public function getPublicActions()
    {
        return $this->publicActions;
    }

    /**
     * @return array
     */
    public function getPrivateActions()
    {
        return $this->privateActions;
    }

    /**
     * Set the header to return JSON data.
     */
    public function setJson()
    {
        header('Content-Type: application/json');
    }

    /**
     * Set the HTTP response code; ie: 200 for success, 400 for error, etc.
     * @param int $code
     */
    public function setHttpCode( $code = 200 )
    {
        // Set the HTTP response code.
        http_response_code( $code );
    }

    /**
     * @param $data
     * @param int $code
     */
    public function sendJsonResponse( $data, $code = 200 )
    {
        $this->setJson();
        $this->setHttpCode( $code );
        echo json_encode( $data );
    }

    /**
     * Adds a private action callback.
     * @param $prefix
     * @param $action
     * @param $class
     */
    public function addPrivateAction( $prefix, $action, $class )
    {
        $this->privateActions[] = [
            'prefix' => $prefix,
            'action' => $action,
            'class' => $class
        ];
    }

    /**
     * Adds a public action callback.
     * @param $prefix
     * @param $action
     * @param $class
     */
    public function addPublicAction( $prefix, $action, $class )
    {
        $this->publicActions[] = [
            'prefix' => $prefix,
            'action' => $action,
            'class' => $class
        ];
    }

    /**
     * @var Ajax
     */
    protected static $instance;

    /**
     * Ajax constructor.
     */
    protected function __construct()
    {}

    /**
     * @return Ajax
     */
    public static function getInstance()
    {
        if ( null === static::$instance ) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}