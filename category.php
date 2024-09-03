<?php get_header(); ?>
<section id="container">
	<main id="main" class="container" role="main">
	    <?php if (have_posts()) : ?>
	        <header class="page-header">
	            <h1 class="page-title">
	                <?php
	                printf(esc_html__('%s', 'norder-monetization'), single_cat_title('', false));
	                ?>
	            </h1>
	            <?php
	            the_archive_description('<div class="archive-description">', '</div>');
	            ?>
	        </header>

	        <div class="post-list">
	            <?php
	            while (have_posts()) :
	                the_post();
	            ?>
	                <article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
	                    <?php if (has_post_thumbnail()) : ?>
	                        <div class="post-thumbnail">
	                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php custom_post_thumbnail(); ?>
	                            </a>
	                        </div>
	                    <?php endif; ?>

	                    <header class="entry-header">
	                        <h2 class="entry-title">
	                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	                        </h2>
	                    </header>

	                    <div class="entry-meta">
	                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
	                            <?php echo esc_html(get_the_date()); ?>
	                        </time>
	                    </div>

	                    <div class="entry-summary">
	                        <?php the_excerpt(); ?>
	                    </div>

	                    <footer class="entry-footer">
	                        <a href="<?php the_permalink(); ?>" class="read-more">
	                            <?php esc_html_e('Leia mais', 'norder-monetization'); ?>
	                            <span class="screen-reader-text"><?php esc_html_e('sobre', 'norder-monetization'); ?> <?php the_title(); ?></span>
	                        </a>
	                    </footer>
	                </article>
	            <?php endwhile; ?>
	        </div>

	        <?php
	        the_posts_pagination(array(
	            'mid_size'  => 2,
	            'prev_text' => __('&laquo; Anterior', 'norder-monetization'),
	            'next_text' => __('Próximo &raquo;', 'norder-monetization'),
	        ));
	        ?>

	    <?php else : ?>
	        <p><?php esc_html_e('Desculpe, nenhum post encontrado nesta categoria.', 'norder-monetization'); ?></p>
	    <?php endif; ?>
	</main>
</section>
<?php get_footer(); ?>