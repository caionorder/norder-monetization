<?php
/*
Template Name: Home Page
*/

get_header();
?>

<section id="container">


<main id="main" class="site-main home-page container" role="main">

    <!-- Seção: Últimos Posts -->
    <section class="latest-posts">
        <div class="head-card">
            <h2><?php esc_html_e('Últimos Posts', 'norder-monetization'); ?></h2>
        </div>
        <div class="body-card">
        <?php
        $latest_posts = new WP_Query(array(
            'posts_per_page' => 2
        ));

        if ($latest_posts->have_posts()) :
            while ($latest_posts->have_posts()) : $latest_posts->the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </a>
                <?php endif; ?>
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

    <!-- Seção: Quem Somos -->
    <section class="about-us">
        <h2><?php echo wp_kses_post(get_theme_mod('about_us_title', 'Configure esta seção no Personalizador.')); ?></h2>
        <div class="about-content">
            <?php echo wp_kses_post(get_theme_mod('about_us_content', 'Configure esta seção no Personalizador.')); ?>
        </div>
    </section>

    <?php
    // Seção: Posts por Categoria
    $categories = get_categories(array('exclude' => array(1))); // Exclui a categoria "Uncategorized"

    foreach ($categories as $category) :
        $category_posts = new WP_Query(array(
            'cat' => $category->term_id,
            'posts_per_page' => 4,
            'offset' => 1, // Ignora o post mais recente
            'orderby' => 'rand'
        ));

        if ($category_posts->have_posts()) :
    ?>
        <section class="category-section">
            <div class="head-card">
                <h2><?php echo esc_html($category->name); ?></h2>
            </div>
            <div class="post-grid">
                <?php
                while ($category_posts->have_posts()) : $category_posts->the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                <?php custom_post_thumbnail(); ?>
                            </a>
                        <?php endif; ?>
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
                ?>
            </div>
        </section>
    <?php
        endif;
    endforeach;
    ?>

</main>

</section>

<?php
get_footer();
?>