<?php
namespace WPOrbit\Ajax\Setup;

class Bootstrapper
{
    public function admin_scripts()
    {
        // Declare path to assets.
        $path = plugin_dir_url( __FILE__ ) . '../../assets/';

        // Posts pivoter view model.
        wp_register_script( 'wp-orbit-ajax', $path . 'js/ajax.js' );

        // Enqueue scripts.
        wp_enqueue_script('wp-orbit-ajax');
    }

    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', [$this, 'admin_scripts'] );
    }
}