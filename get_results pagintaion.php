<?php
//query
$total = "your custom query goes here, but without LIMIT and OFFSET, so the total number of posts that match the query can be counted";
$totalposts = $wpdb->get_results($total, OBJECT);
$ppp = intval('2'); //12 posts per page you might use $ppp = intval(get_query_var('posts_per_page'));
$wp_query->found_posts = count($totalposts);
$wp_query->max_num_pages = ceil($wp_query->found_posts / $ppp);
$on_page = intval(get_query_var('paged'));
if ($on_page == 0) {
    $on_page = 1;
}
$offset = ($on_page - 1) * $ppp;
$wp_query->request = "your query again, but with the LIMIT and OFFSET as follows: LIMIT $ppp OFFSET $offset";
$pageposts = $wpdb->get_results($wp_query->request, OBJECT);


//loop
foreach ($pageposts as $image) {
    
}
?>


<?php
//pagination
if (strpos($currentPageUrl, '?')) {
    $currentPageUrlWithPage = $currentPageUrl . '&paged=';
} else {
    $currentPageUrlWithPage = $currentPageUrl . '?paged=';
}
?>

<?php if ($wp_query->max_num_pages > 1) { ?>
    <ul class="pging">
        <?php if ($on_page > 1) { ?>
            <li class="fristPage"><a href="<?php echo $currentPageUrlWithPage . '1'; ?>">&lsaquo;&lsaquo;</a></li>
            <li class="prevPage"><a href="<?php echo $currentPageUrlWithPage . ($on_page - 1); ?>">&lsaquo;</a></li>
        <?php } ?>

        <?php
        for ($index = 1; $index <= $wp_query->max_num_pages; $index++) {
            if ($index > $on_page - 3 && $index < $on_page + 3) {
                if ($index == $on_page) {
                    ?>
                    <li class="crnt">
                        <a href="javascript:void(0)"><?php echo $index; ?></a>
                    <? } else { ?>
                    <li>
                        <a href="<?php echo $currentPageUrlWithPage . $index; ?>"><?php echo $index; ?></a>
                    <? } ?>
                </li>
                <?
            }
        }
        ?>

        <?php if ($on_page < $wp_query->max_num_pages) { ?>
            <li class="nextPage"><a href="<?php echo $currentPageUrlWithPage . ($on_page + 1); ?>">&rsaquo;</a></li>
            <li class="lastPage"><a href="<?php echo $currentPageUrlWithPage . $wp_query->max_num_pages; ?>">&rsaquo;&rsaquo;</a></li>
        <?php } ?>
    </ul>
<?php } ?>
