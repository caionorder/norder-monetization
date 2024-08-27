<header class="entry-header">
    <?php
    // Exibir categorias
    $categories_list = get_the_category_list(', ');
    if ($categories_list) {
        echo '<div class="entry-categories">' . $categories_list . '</div>';
    }
    ?>
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <div class="entry-meta">
        <span class="posted-on">
            <?php
            echo 'Publicado em ';
            echo '<time class="entry-date published" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
            ?>
        </span>
        <?php
        $u_time = get_the_time('U');
        $u_modified_time = get_the_modified_time('U');
        if ($u_modified_time >= $u_time + 86400) {
            echo '<span class="updated-on">';
            echo 'Atualizado em ';
            echo '<time class="entry-date updated" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date() ) . '</time>';
            echo '</span>';
        }
        ?>
    </div>
</header>

<div class="entry-content">
    <?php
    the_content();

    wp_link_pages(
        array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'norder-monetization' ),
            'after'  => '</div>',
        )
    );
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