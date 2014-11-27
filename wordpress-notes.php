<?php
/**
 * return arabic month name
 * @param integer $month
 * @return string
 */
function getArabicMonth($month) {
switch ($month) {
case '01':return 'يناير ';
break;
case '02':return 'فبراير ';
break;
case '03':return 'مارس ';
break;
case '04':return 'ابريل ';
break;
case '05':return 'مايو ';
break;
case '06':return 'يونيو ';
break;
case '07':return 'يوليو ';
break;
case '08':return 'اغسطس ';
break;
case '09':return 'سبتمبر ';
break;
case '10':return 'اكتوبر ';
break;
case '11':return 'نوفمبر ';
break;
case '12':return 'ديسمبر ';
break;
default:echo '';
break;
}
}

/**
 * date('D')
 * @param type $day
 * @return string
 */
function getArabicDay($day) {
switch ($day) {
case 'Mon':
return 'الاثنين';
break;
case 'Tue':
return 'الثلاثاء';
break;
case 'Wed':
return 'الاربعاء';
break;
case 'Thu':
return 'الخميس';
break;
case 'Fri':
return 'الجمعه';
break;
case 'Sat':
return 'السبت';
break;
case 'Sun':
return 'الاحد';
break;
default:
return 'الاثنين';
break;
}
}

function getPostGallery($postId) {
$gallery = get_post_meta($postId, 'wpsimplegallery_gallery', true);
$galleryArray = array();
if ($gallery) {
foreach ($gallery as $thumbid) {
$imageArray = array();
$image = get_post($thumbid);
$imageArray ['title'] = $image->post_title;
$imageArray ['url'] = wp_get_attachment_url($thumbid);
$galleryArray[] = $imageArray;
}
}
return $galleryArray;
}

echo get_stylesheet_directory_uri();


ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


if (function_exists('eemail_show')) {
eemail_show();
}


//force user to login
if (( is_single() || is_front_page() || is_page() ) && !is_page('login') && !is_user_logged_in()) {
auth_redirect();
}

echo do_shortcode('[wp-members page="register"]');

//cron job time
current_time( 'mysql', 1 );


add_post_type_support('page', 'excerpt');

//side bar
function site_init() {

register_sidebar(array(
'name' => __('Sidebar Name1'),
'id' => 'sidebar',
'description' => __('Widgets in this area will be shown on the right-hand side.'),
'before_title' => '<h1>',
    'after_title' => '</h1>',
'before_widget' => '',
'after_widget' => ''
));
}

add_action('widgets_init', 'site_init');

//show side bar
get_sidebar('sidebar'); 

if (is_active_sidebar('main-sidebar'))
dynamic_sidebar('main-sidebar');



//wordpress remove p tags from content
remove_filter ('the_content',  'wpautop');

get_the_excerpt(); 

echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; 


wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => '', 'items_wrap' => '%3$s')); 
include(TEMPLATEPATH . '/mostViewedFrom.php');

//hide admin bar
add_filter('show_admin_bar', '__return_false');

//get category for custom post
wp_get_post_terms(get_the_ID(), 'product-category');

//display cat title in category page
single_cat_title();
single_tag_title();

get_query_var('tag_id');
get_query_var('cat');
get_query_var( 'term' );

//wget http://wordpress.org/latest.zip

//short code 
echo do_shortcode('[fbcomments]'); 

//wordpress get  permalink for post
get_permalink($product->ID);


//Returns the correct url for a given Category ID. 
echo get_category_link( $category_id ); 
get_category_by_slug('news-and-events');
get_term_by('slug','products','product-category');


//post comments number
comments_number('0', '1', '%');

//post views number
if(function_exists('the_views')) { the_views();
}



//get_post_type_archive_link
get_post_type_archive_link('champ-videos');
?>
//most Read posts
<ul class="mostReadList" id="mostReadList">
    <?php
    $article = new WP_Query(array('orderby' => 'meta_value_num', 'meta_key' => 'views', 'order' => 'DESC', 'posts_per_page' => '5'));

    while ($article->have_posts()) : $article->the_post();
    ?>

    <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </li>

    <?
    endwhile;

    wp_reset_query();
    ?>
</ul>


//most Comment posts
<ul class="mostReadList" id="mostCommentList" style="display: none;">
    <?php
    global $wpdb;
    $posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'post' and post_status = 'publish' order by comment_count desc limit 5");
    foreach ($posts as $post) {
    ?>
    <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </li>
<? } ?>
</ul>



//custom comment template
<article class="article-1">
    <h3>ADD COMMENT</h3>
    <hr/>
    <div class="admin-box">
        <?php
        $comments_args = array(
        // change the title of send button 
        'title_reply' => '',
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
        // redefine your own textarea (the comment body)
        'comment_field' => '<textarea id="comment" name="comment" aria-required="true" placeholder="Your Message.."></textarea>',
        'comment_notes_before' => '',
        'label_submit' => 'SUBMIT',
        'fields' => array(
        'author' => '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' placeholder="Name"/>',
        'email' => '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' placeholder="Email"/>',
        'url' => '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" placeholder="URL (Optional)"/>',
        )
        );
        comment_form($comments_args);
        ?>
    </div>
</article><!--article-1-->
<hr/>
<article class="article-1">
    <?php
    $comments = get_comments(array(
    'post_id' => $post->ID,
    'status' => 'approve'
    ));

    foreach ($comments as $comment) :
    ?>

    <div class="user-img-box">
        <?php
        if ($comment->user_id != 0) {
        if (get_usermeta($comment->user_id, 'author_image')) {
        ?>
        <img src="<? bloginfo('template_url'); ?>/thumb.php?src=/wp-content/authors/<?php echo get_usermeta($comment->user_id, 'author_image'); ?>&amp;w=75/&amp;h=75&amp;zc=1&amp;q=100" width="75" height="75">
        <? } else { ?>
        <img src="<? bloginfo('template_url'); ?>/thumb.php?src=/wp-content/themes/Red-App/img/user-img.jpg&amp;w=75/&amp;h=75&amp;zc=1&amp;q=100" width="75" height="75"> 
        <? } ?>

        <? } else { ?>
        <img src="<? bloginfo('template_url'); ?>/thumb.php?src=/wp-content/themes/Red-App/img/user-img.jpg&amp;w=75/&amp;h=75&amp;zc=1&amp;q=100" width="75" height="75">
<? } ?>

    </div>
    <div class="admin-box">
        <div class="name red"><?php echo $comment->comment_author; ?></div>
        <time><?php
            $commentDate = new DateTime($comment->comment_date);
            echo $commentDate->format('F d, Y \a\t h:i A');
            ?></time>
        <p><?php echo $comment->comment_content; ?></p>
    </div>
<? endforeach; ?>
</article><!--article-1-->



<?php
//post images
$images = get_posts(array(
'post_parent' => $postId,
'post_type' => 'attachment',
'numberposts' => -1, // show all
'post_status' => null,
'post_mime_type' => 'image',
'orderby' => 'menu_order',
'order' => 'ASC',
));
$imagesSize = sizeof($images);
foreach ($images as $image) {
$attimg = wp_get_attachment_image_src($image->ID, 'full');
$blogurl = get_bloginfo('url');
$image_url = str_replace($blogurl, '', $attimg['0']);
}




// hook failed login
add_action('wp_login_failed', 'my_front_end_login_fail');  

function my_front_end_login_fail($username) {
$referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
// if there's a valid referrer, and it's not the default log-in screen
if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin')) {
wp_redirect($referrer . '?loginError=failed');  // let's append some information (login=failed) to the URL for the theme to use
exit;
}
}

if (is_user_logged_in()) {
$currentUser = wp_get_current_user();
}

//schedule

wp_schedule_event($firstOccurTime, $reimportPeriod, 'my_schedule_event');

function do_this_schedule(){

}

//schedule functions
add_action('my_schedule_event', 'do_this_schedule');

//add weekly and monthly to reoccurs types
add_filter('cron_schedules', 'cron_add_weekly_schedule');

function cron_add_weekly_schedule($schedules) {
$schedules['weekly'] = array(
'interval' => 604800,
'display' => __('Once Week')
);

return $schedules;
}



