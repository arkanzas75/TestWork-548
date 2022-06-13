<?php
get_header();
?>

<main id="primary" class="site-main">

        <?php
        while (have_posts()) :
                the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                        the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif; ?>
                        </header>

                        <div class="entry-content">
                                <?php
                                the_content(
                                        sprintf(
                                                wp_kses(
                                                        __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'testwork548'),
                                                        array(
                                                                'span' => array(
                                                                        'class' => array(),
                                                                ),
                                                        )
                                                ),
                                                wp_kses_post(get_the_title())
                                        )
                                );

                                wp_link_pages(
                                        array(
                                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'testwork548'),
                                                'after'  => '</div>',
                                        )
                                );
                                ?>
                        </div>
                </article>

        <?php if (comments_open() || get_comments_number()) :
                        comments_template();
                endif;

        endwhile;
        ?>

</main>

<?php
get_footer();
?>