<section id="container">
    <article class="container">
        <header class="entry-header">
            <?php
            // Exibir categorias
            $categories_list = get_the_category_list(', ');
            if ($categories_list) {
                echo '<div class="entry-categories"><a href="/">Home</a> > ' . $categories_list . '</div>';
            }
            ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <span class="posted-on">
                    <?php
                    echo 'Publicado em ';
                    echo '<time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
                    echo ' por ' . get_the_author_posts_link();
                    ?>
                </span>      
            </div>
        </header>


        <div class="entry-content">
            <?php

            $preview_enabled = get_post_meta(get_the_ID(), '_preview_option', true);
            if ($preview_enabled && !isset($_GET['open'])) {
            ?>
            <div id="preview">
                <?php the_content(); ?>
            </div>
            <div id="open-preview">
                <?php echo '<a href="' . add_query_arg('open', 'now') . '" class="see-more">CONTINUE LENDO</a>'; ?>
            </div>
            <?php

            } else {

                the_content();
                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'norder-monetization' ),
                        'after'  => '</div>',
                    )
                );
            }

            ?>
        </div>

        <footer class="entry-footer">
            <?php
            $tags_list = get_the_tag_list( '', ', ' );
            if ( $tags_list ) {
                echo '<div class="entry-tags">' . __( 'Tags: ', 'norder-monetization' ) . $tags_list . '</div>';
            }
            ?>
        </footer>
    </article>
</section>

<section id="container" style="min-height:auto !important">
    <article class="container">
    <!-- Seção: Últimos Posts -->
    <section class="latest-posts">
        <div class="head-card">
            <h2><?php esc_html_e('Últimos Posts', 'norder-monetization'); ?></h2>
        </div>
        <div class="body-card">
        <?php
        $latest_posts = new WP_Query(array(
            'posts_per_page' => 4,
            'orderby' => 'rand',
            'post__not_in' => array(get_the_ID())
        ));

        if ($latest_posts->have_posts()) :
            while ($latest_posts->have_posts()) : $latest_posts->the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </header>
                <div class="entry-summary">
                    <p><?php echo get_the_date(); ?> - <?php echo get_the_excerpt(); ?></p>
                </div>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
        </div>
    </section>
    </article>
</section>