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

    function register() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
    }

    function activate(){
        flush_rewrite_rules();
    }

    function deactivate(){

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
    $allResults = [];
    $allResults = $wpdb->get_results("SELECT review_id, rating, name, avatar, post_content FROM wp_glsr_ratings JOIN wp_posts WHERE wp_glsr_ratings.review_id = wp_posts.ID AND wp_glsr_ratings.is_approved = 1 AND rating >= 4;");
    // counting all results
    $positiveReviewslength = count($allResults);
    $sum = 0;

    for($i=0; $i<=$positiveReviewslength; $i++) {
        $sum += $allResults[$i]->rating;
    }

    //counting avg of reviews points
    $ratingavg = round($sum / $positiveReviewslength, 2);

    echo
    '
    <div id="opinions_badge" class="opinons-badge">
    <div class="opinions_badge__wrapper">
        <div class="opinions_badge__img">
            <img src="https://misiule.pl/wp-content/uploads/2021/07/ikonka-opinie.png" alt="opinie-img">
        </div>
        <div class="opinions_badge__info">
            <span class="opinions_badge__meta opinions_badge__stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
            <span class="opinions_badge__meta opinions_badge__avg">'.$ratingavg.' / 5.00</span>
            <span class="opinions_badge__meta opinions_badge__all">'.$positiveReviewslength.' opinii</span>
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

    $reviewslength = count($allResults);
    $sum = 0;

    for($i=0; $i<=$reviewslength; $i++) {
        $sum = $sum + $allResults[$i]->rating;
    }

    //counting avg of reviews points
    $ratingavg = $sum / $reviewslength;
    foreach($allResults as $review) {
        echo '
            <div class="opinion">
                <h4 class="opinions_name">Autor: '. $review->name .'</h3>
                <p class="date"></p>
                <p class="opinions_rating">Ocena: '. $review->rating .'/5</p>
                <p class="opinion_content">&bdquo;'.$review->post_content.'&ldquo;</p>
            </div>
        ';
    }
    $homeUrl = get_home_url();
    echo '
        </div>
        <div class="opinions-bottom">
            <p class="bottom-avg"><a href="'.$homeUrl.'/opinie">Dodaj opinie (wszystkich: '.$positiveReviewslength.')</a></p>
        </div>
            <div class="opinions_badge__close" id="close-button"><i class="fas fa-times"></i></div>
    </div>';
}

add_shortcode('ecat-reviews-badge', 'reviewsBadge');

//activation
register_activation_hook(__FILE__, array($ecatReviews, 'activate'));

//deactivation
register_deactivation_hook(__FILE__, array($ecatReviews, 'deactivate'));
