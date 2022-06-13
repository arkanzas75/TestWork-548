<?php
get_header();
?>

<?php
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
);
$wc_query = new WP_Query($args);
if ($wc_query->have_posts()) { ?>
    <section>
        <div class="container">
            <div class="front-products">
                <h2 class="section-title">Наш ассортимент</h2>
                <div class="front-products-list">
                    <?php while ($wc_query->have_posts()) {
                        $wc_query->the_post(); ?>
                        <div class="front-products-list-item">
                            <div class="front-products-list-item-pic">
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                            </div>
                            <div class="front-products-list-item-content">
                                <div class="front-products-list-item-content-title">
                                    <span><?php the_title(); ?></span>
                                </div>
                                <?php $price = get_post_meta(get_the_ID(), '_price', true); ?>
                                <span><?php echo wc_price($price); ?></span>
                                <a class="buy-button" href="<?php echo get_permalink(); ?>">Купить</a>
                            </div>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </section>
<?php }
wp_reset_postdata(); ?>

<?php
get_footer();
?>