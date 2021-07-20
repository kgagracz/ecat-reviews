<?php 

if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$reviews = get_post( array(
    'post_type' => 'review',
    'numberposts' => -1
    ))

foreach($reviews as $review) {
    wp_delete_posts($review->ID, true);
}