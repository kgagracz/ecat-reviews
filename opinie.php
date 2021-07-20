
 <?php
require_once('wp-load.php');
    
    
$allresults = $wpdb->get_results("SELECT review_id, rating, name, avatar, post_content FROM wp_glsr_ratings JOIN wp_posts WHERE wp_glsr_ratings.review_id = wp_posts.ID AND wp_glsr_ratings.is_approved = 1 AND rating > 0;");

// counting all results

$reviewslength = count($allresults);
$sum = 0;

for($i=0; $i<=$reviewslength; $i++) {
    $sum += $allresults[$i]->rating;
}

//counting avg of reviews points
$ratingavg = $sum / $reviewslength;

?> 
  
  <link rel="stylesheet" href="./style.css">
    <div id="opinions_badge" class="opinons-badge">
    <div class="opinions_badge__wrapper">
        <div class="opinions_badge__img">
            <img src="https://manito.pl/data/include/cms/trustedOpinions/badge_opinion_pl.svg" alt="opinie-img">
        </div>
        <div class="opinions_badge__info">
            <span class="opinions_badge__meta opinions_badge__stars">gwiazdki</span>
            <span class="opinions_badge__meta opinions_badge__avg"><?php echo $ratingavg?> / 5</span>
            <span class="opinions_badge__meta opinions_badge__all"><?php echo $reviewslength?> opinii</span>
        </div>
        <div class="opinions_badge__more" id="opinions-badge-more"></div>
    </div>
    </div>
    <div class="opinions_wrapper" id="opinions-wrapper">
        <div class="opinions_top" style="overflow-y: scroll; height: 50vh">
            <h2>Opinie naszych klientów</h2>
            <?php 
                foreach($allresults as $result) {
                    echo '
                    <div class="opinion">
                        <h4 class="opinions_name">Autor: '. $result->name .'</h3>
                        <p class="date"></p>
                        <p class="opinions_rating">Ocena: '. $result->rating .'/5</p>
                        <p class="opinion_content">'.$result->post_content.'</p>
                        <hr/>
                    </div>
                    ';
                }
            ?>
            
        </div>
            <p style="text-align: center">Średnia <span class="avg-rating"><?php echo $ratingavg?></span> z <?php echo $reviewslength?> opinii.</p>
            <div class="opinions_badge__close" id="close-button"></div>
    </div>
            <script src="./popup.js"></script>'


