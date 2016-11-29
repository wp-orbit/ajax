<?php
namespace Zawntech\WordPress\Orbit\Ajax;

/**
 * Class Ajax
 * @package Zawntech\WordPress\Orbit\Ajax
 */
class Ajax
{
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
}