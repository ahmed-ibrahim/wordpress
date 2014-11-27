<?php
// Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );

function return_7200($seconds) {
    // change the default feed cache recreation period to 2 hours
    return 7200;
}

add_filter('wp_feed_cache_transient_lifetime', 'return_7200');
// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed('http://www.dewa.gov.ae/rss/newsrss.rss');
remove_filter('wp_feed_cache_transient_lifetime', 'return_7200');

if (!is_wp_error($rss)) : // Checks that the object is created correctly
    // Figure out how many total items there are, but limit it to 5. 
    $maxitems = $rss->get_item_quantity(10);

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems);
    if ($maxitems > 0):
        ?>
        <div id="newsTicker">
            <ul>
                <?php foreach ($rss_items as $item) : ?>
                    <li><p><a target="_blank" href="<?php echo esc_url($item->get_permalink()); ?>"><?php echo esc_html($item->get_title()); ?></a></p></li>                     
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    endif;
endif;
?>