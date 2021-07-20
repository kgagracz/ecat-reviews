<?php
/**
 * @package EcatReviews
 */
 /*
Plugin Name: Ecat Reviews
Plugin URI: https://github.com/kgagracz/ecat-reviews
Description: Lorem ipsum dolor, sit amet consectetur adipisicing elit. A quo quisquam, dignissimos fugit repudiandae debitis mollitia repellat cumque consequuntur iure.
Version: 1.0.0
Author: Krystian Gagracz
Author URI: 
Licence: GPLv2 or later
Text Domain: ecat-reviews
  */

if (! function_exists('add_action')) {
    echo 'Hey, you can/t acces this file!';
    die;
}

class EcatReviews
{
    function __construct() {
        add_action('init', array($this, 'custom_post_type'));
    }

    function activate(){
        $this->custom_post_type();

        flush_rewrite_rules();
    }

    function deactivate(){

    }

    function unistall(){
        
    }

    function custom_post_type() {
        register_post_type('reviews', [
            'public' => true, 
            'label' => 'Ec-at reviews',
            'menu_icon' => 'dashicons-star-empty'
        ]);
    }
}

if(class_exists('EcatReviews')){
    $ecatReviews = new EcatReviews();
}

//activation
register_activation_hook(__FILE__, array($ecatReviews, 'activate'));

//deactivation
register_activation_hook(__FILE__, array($ecatReviews, 'deactivate'));

//uninstall