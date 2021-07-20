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

    function register() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
    }

    function activate(){
        $this->custom_post_type();

        flush_rewrite_rules();
    }

    function deactivate(){

    }

    function custom_post_type() {
        register_post_type('review', [
            'public' => true, 
            'label' => 'Ec-at reviews',
            'menu_icon' => 'dashicons-star-empty'
        ]);
    }

    function enqueue() {
        wp_enqueue_style(
            'ecatreviewsstyle',
            plugins_url('./asets/ecatreviews-style.css', __FILE__)
        );
        wp_enqueue_script(
            'ecatreviewsscript',
            plugins_url('./asets/ecatreviews-script.js', __FILE__)
        );
    }
    
}

if(class_exists('EcatReviews')){
    $ecatReviews = new EcatReviews();
    $ecatReviews->register();
}

function reviewsBadge() {
    global $wpdb;
    $allPositiveResults = $wpdb->get_results("SELECT review_id, rating, name, avatar, post_content FROM wp_glsr_ratings JOIN wp_posts WHERE wp_glsr_ratings.review_id = wp_posts.ID AND wp_glsr_ratings.is_approved = 1 AND rating >= 4;");
    $allResults = $wpdb->get_results("SELECT review_id, rating, name, avatar, post_content FROM wp_glsr_ratings JOIN wp_posts WHERE wp_glsr_ratings.review_id = wp_posts.ID AND wp_glsr_ratings.is_approved = 1 AND rating >= 0;");
    
    // counting all results
    $positiveReviewslength = count($allPositiveResults);
    $allReviewsLength = count($allResults);
    $sum = 0;

    for($i=0; $i<=$positiveReviewslength; $i++) {
        $sum += $allPositiveResults[$i]->rating;
    }

    //counting avg of reviews points
    $ratingavg = round($sum / $positiveReviewslength, 2);

    echo
    '
    <div id="opinions_badge" class="opinons-badge">
    <div class="opinions_badge__wrapper">
        <div class="opinions_badge__img">
            <img src="https://manito.pl/data/include/cms/trustedOpinions/badge_opinion_pl.svg" alt="opinie-img">
        </div>
        <div class="opinions_badge__info">
            <span class="opinions_badge__meta opinions_badge__stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
            <span class="opinions_badge__meta opinions_badge__avg">'.$ratingavg.' / 5.00</span>
            <span class="opinions_badge__meta opinions_badge__all">'.$allReviewsLength.' opinii</span>
        </div>
        <div class="opinions_badge__more" id="opinions-badge-more"><i class="fas fa-arrow-right"></i></div>
    </div>
    </div>
    <div class="opinions_wrapper" id="opinions-wrapper">
        <div class="opinions_top" style="overflow-y: scroll; height: 50vh">
            <h2 class="opinion-box-title">Opinie naszych klientów</h2>
            ';
            global $wpdb;
    // counting all results

    $reviewslength = count($allPositiveResults);
    $sum = 0;

    for($i=0; $i<=$reviewslength; $i++) {
        $sum = $sum + $allPositiveResults[$i]->rating;
    }

    //counting avg of reviews points
    $ratingavg = $sum / $reviewslength;
    foreach($allPositiveResults as $review) {
        echo '
            <div class="opinion">
                <h4 class="opinions_name">Autor: '. $review->name .'</h3>
                <p class="date"></p>
                <p class="opinions_rating">Ocena: '. $review->rating .'/5</p>
                <p class="opinion_content">&bdquo;'.$review->post_content.'&ldquo;</p>
            </div>
        ';
    }
    echo '
        </div>
        <div class="opinions-bottom">
            <p class="bottom-avg"><a href="https://misiule.pl/opinie/">Dodaj opinie (wszystkich: '.$reviewslength.')</a></p>
        </div>
            <div class="opinions_badge__close" id="close-button"><i class="fas fa-times"></i></div>
    </div>';
}

function reviewsPage() {
    foreach($allPositiveResults as $review) {
        echo '
            <div class="opinion">
                <h4 class="opinions_name">Autor: '. $review->name .'</h3>
                <p class="date"></p>
                <p class="opinions_rating">Ocena: '. $review->rating .'/5</p>
                <p class="opinion_content">&bdquo;'.$review->post_content.'&ldquo;</p>
            </div>
        ';
    }
}

add_shortcode('ecat-reviews-badge', 'reviewsBadge');
add_shortcode('ecat-reviews', 'reviewsPage');


//activation
register_activation_hook(__FILE__, array($ecatReviews, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($ecatReviews, 'deactivate'));
