<?php

if (!function_exists('theme_setup')):
    function theme_setup() {
        // Adicionar suporte para título automático
        add_theme_support('title-tag');

        // Adicionar suporte para logo personalizado
        add_theme_support('custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // Adicionar suporte para favicon
        add_theme_support('site_icon');

        // Adicionar suporte para miniaturas de posts
        add_theme_support('post-thumbnails');

        // Adicionar suporte para formatos de posts
        add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

        // Adicionar suporte para HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Adicionar suporte para atualização seletiva de widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Adicionar suporte para alinhamento amplo e tela cheia
        add_theme_support('align-wide');

        // Adicionar suporte para menus
        register_nav_menus(array(
            'primary' => __('Menu Principal', 'norder-monetization'),
            'footer' => __('Menu do Rodapé', 'norder-monetization'),
        ));

        // Adicionar suporte para feeds automáticos
        add_theme_support('automatic-feed-links');

        // Adicionar suporte para estilos de blocos
        add_theme_support('wp-block-styles');

        // Adicionar suporte para cabeçalho personalizado
        add_theme_support('custom-header');

        // Adicionar suporte para fundo personalizado
        add_theme_support('custom-background');

        // Adicionar suporte para estilos do editor
        add_editor_style();
    }
endif;
add_action('after_setup_theme', 'theme_setup');

// Registrar áreas de widgets
function theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Barra lateral', 'norder-monetization'),
        'id'            => 'sidebar-1',
        'description'   => __('Adicione widgets aqui.', 'norder-monetization'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Rodapé', 'norder-monetization'),
        'id'            => 'footer-1',
        'description'   => __('Aparece no rodapé', 'norder-monetization'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'theme_widgets_init');

// Enfileirar scripts e estilos
function theme_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// Adicionar opções ao Personalizador
function theme_customizer_options($wp_customize) {
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
    
    // Seção de Identidade do Site
    $wp_customize->add_section('site_identity', array(
        'title' => __('Cores', 'norder-monetization'),
        'priority' => 30,
    ));

    // Fonte do texto
    $wp_customize->add_setting('text_font', array(
        'default' => 'Arial',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('text_font', array(
        'label' => __('Fonte do texto', 'norder-monetization'),
        'section' => 'site_identity',
        'type' => 'select',
        'choices' => array(
            'Arial' => 'Arial',
            'Helvetica' => 'Helvetica',
            'Times New Roman' => 'Times New Roman',
            'Georgia' => 'Georgia',
            'Verdana' => 'Verdana',
        ),
    ));

    // Cores
    $color_settings = array(
        'header_color' => __('Cor do Cabeçalho', 'norder-monetization'),
        'header_color_text' => __('Cor Texto do Cabeçalho', 'norder-monetization'),
        'footer_color' => __('Cor do Rodapé', 'norder-monetization'),
        'footer_color_text' => __('Cor Texto do Rodapé', 'norder-monetization'),
        'body_color' => __('Cor do Corpo', 'norder-monetization'),
        'body_color_text' => __('Cor Texto do Corpo', 'norder-monetization'),
    );

    foreach ($color_settings as $setting => $label) {
        $wp_customize->add_setting($setting, array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ));

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting, array(
            'label' => $label,
            'section' => 'site_identity',
        )));
    }

    $wp_customize->add_setting('homepage_display', array(
        'default' => 'posts',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('homepage_display', array(
        'label' => __('Exibir na página inicial', 'norder-monetization'),
        'section' => 'homepage_settings',
        'type' => 'radio',
        'choices' => array(
            'posts' => __('Posts da Página Principal', 'norder-monetization'),
        ),
    ));
}
add_action('customize_register', 'theme_customizer_options');

// Função para limitar o comprimento do resumo
function custom_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

// Função para mudar o final do resumo
function custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

// Adicionar suporte para imagens responsivas
function theme_responsive_images() {
    add_theme_support('responsive-embeds');
    add_image_size('theme-featured-image', 2000, 1200, true);
}
add_action('after_setup_theme', 'theme_responsive_images');

function theme_customize_register($wp_customize) {
    // Adiciona seção para "Quem Somos"
    $wp_customize->add_section('about_us_section', array(
        'title'    => __('Quem Somos', 'norder-monetization'),
        'priority' => 30,
    ));

    // Adiciona campo para o título de "Quem Somos"
    $wp_customize->add_setting('about_us_title', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('about_us_title', array(
        'label'    => __('Título', 'norder-monetization'),
        'section'  => 'about_us_section',
        'type'     => 'text',
    ));

    // Adiciona campo para o conteúdo de "Quem Somos"
    $wp_customize->add_setting('about_us_content', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('about_us_content', array(
        'label'    => __('Conteúdo Quem Somos', 'norder-monetization'),
        'section'  => 'about_us_section',
        'type'     => 'textarea',
    ));

    // Adiciona campo para a cor de fundo
    $wp_customize->add_setting('about_us_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'about_us_background_color', array(
        'label'    => __('Cor de Fundo', 'norder-monetization'),
        'section'  => 'about_us_section',
        'settings' => 'about_us_background_color',
    )));

    // Adiciona campo para a cor da letra
    $wp_customize->add_setting('about_us_text_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'about_us_text_color', array(
        'label'    => __('Cor da Letra', 'norder-monetization'),
        'section'  => 'about_us_section',
        'settings' => 'about_us_text_color',
    )));
}
add_action('customize_register', 'theme_customize_register');



function disable_wp_emojicons() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('emoji_svg_url', '__return_false');
}
add_action('init', 'disable_wp_emojicons');

function add_post_preview_option() {
    add_meta_box('preview_option', __('Opção de Prévia', 'norder-monetization'), 'preview_option_callback', 'post');
}
add_action('add_meta_boxes', 'add_post_preview_option');

function preview_option_callback($post) {
    $value = get_post_meta($post->ID, '_preview_option', true);
    echo '<label><input type="checkbox" name="preview_option" value="1" ' . checked($value, 1, false) . '> ' . __('Ativar prévia de 30%', 'norder-monetization') . '</label>';
}

function save_preview_option($post_id) {
    if (isset($_POST['preview_option'])) {
        update_post_meta($post_id, '_preview_option', 1);
    } else {
        delete_post_meta($post_id, '_preview_option');
    }
}
add_action('save_post', 'save_preview_option');

function get_custom_logo_info() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_info = array(
        'url' => '',
        'width' => '',
        'height' => ''
    );

    if ($custom_logo_id) {
        $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_image) {
            $logo_info['url'] = $logo_image[0];
            $logo_info['width'] = $logo_image[1];
            $logo_info['height'] = $logo_image[2];
        }
    }

    return $logo_info;
}

function get_custom_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url = '';

    if ($custom_logo_id) {
        $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
        $logo_url = $logo_image[0];
    }

    return $logo_url;
}

function custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'medium' => __('Medium 300x200', 'norder-monetization'),
    ));
}
add_filter('image_size_names_choose', 'custom_image_sizes');

function custom_image_setup() {
    remove_image_size('medium');
    add_image_size('medium', 300, 200, true);
}
add_action('after_setup_theme', 'custom_image_setup');

function custom_post_thumbnail($class = 'wp-post-image') {
    if (has_post_thumbnail()) {
        the_post_thumbnail('home-thumbnail', array('class' => $class));
    } else {
        echo '<img src="' . esc_url(get_template_directory_uri() . '/default.webp') . '" class="' . esc_attr($class) . '" width="400" height="267" alt="' . esc_attr__('Default Thumbnail', 'norder-monetization') . '">';
    }
}

function theme_loader_customizer($wp_customize) {
    // Adiciona uma nova seção para as configurações do Loader
    $wp_customize->add_section('loader_settings', array(
        'title'    => __('Configurações do Loader', 'norder-monetization'),
        'priority' => 30,
    ));

    // Adiciona configuração para ativar/desativar o Loader
    $wp_customize->add_setting('loader_active', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('loader_active', array(
        'label'    => __('Ativar Loader', 'norder-monetization'),
        'section'  => 'loader_settings',
        'type'     => 'checkbox',
    ));

    // Adiciona configuração para a cor do Loader
    $wp_customize->add_setting('loader_color', array(
        'default'           => '#ff0000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'loader_color', array(
        'label'    => __('Loader Cor', 'norder-monetization'),
        'section'  => 'loader_settings',
        'settings' => 'loader_color',
    )));

    // Adiciona configuração para o tempo do Loader
    $wp_customize->add_setting('loader_time', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('loader_time', array(
        'label'       => __('Loader (segundos para aguardar o anúncio)', 'norder-monetization'),
        'section'     => 'loader_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
    ));

    // Adiciona configuração para o tempo do Home Loader
    $wp_customize->add_setting('home_loader_time', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('home_loader_time', array(
        'label'       => __('Home Loader (segundos para aguardar o anúncio)', 'norder-monetization'),
        'section'     => 'loader_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 10,
            'step' => 1,
        ),
    ));

    // Adiciona configuração para o nome do AdUnit
    $wp_customize->add_setting('adunit_name', array(
        'default'           => 'Content1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('adunit_name', array(
        'label'       => __('AdUnit Name (Nome do bloco ex: Content1)', 'norder-monetization'),
        'section'     => 'loader_settings',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'theme_loader_customizer');

function enqueue_theme_js() {
    wp_enqueue_script('theme-js', get_template_directory_uri() . '/theme.js', array(), '1.0.0', true);
    
    $loader_active = get_theme_mod('loader_active', false);
    $meta_ads_active = get_theme_mod('meta_ads_active', false);
    $meta_pixel_id = get_theme_mod('meta_pixel_id', '');
    $meta_pixel_token = get_theme_mod('meta_pixel_token', '');

    $theme_config = array();

    if ($loader_active) {
        $theme_config['NorderLoader'] = array(
            'adUnit' => get_theme_mod('adunit_name', 'Content1'),
            'timeout' => get_theme_mod('loader_time', 5) * 1000,
            'loaderId' => 'joinadsloader__wrapper'
        );
    }

    if ($meta_ads_active && !empty($meta_pixel_id) && !empty($meta_pixel_token)) {
        $theme_config['metaPixel'] = array(
            'pixelId' => $meta_pixel_id
        );
    }

    wp_localize_script('theme-js', 'themeConfig', $theme_config);
}
add_action('wp_enqueue_scripts', 'enqueue_theme_js');

function theme_meta_ads_customizer($wp_customize) {
    // Adiciona uma nova seção para as configurações de Meta Ads
    $wp_customize->add_section('meta_ads_settings', array(
        'title'    => __('Meta Ads', 'norder-monetization'),
        'priority' => 30,
    ));

    // Adiciona configuração para ativar/desativar Meta Ads
    $wp_customize->add_setting('meta_ads_active', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('meta_ads_active', array(
        'label'    => __('Ativar Meta Ads', 'norder-monetization'),
        'section'  => 'meta_ads_settings',
        'type'     => 'checkbox',
    ));

    // Adiciona configuração para o Pixel ID
    $wp_customize->add_setting('meta_pixel_id', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('meta_pixel_id', array(
        'label'       => __('Pixel ID', 'norder-monetization'),
        'section'     => 'meta_ads_settings',
        'type'        => 'text',
    ));

    // Adiciona configuração para o Pixel Token
    $wp_customize->add_setting('meta_pixel_token', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('meta_pixel_token', array(
        'label'       => __('Pixel Token', 'norder-monetization'),
        'section'     => 'meta_ads_settings',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'theme_meta_ads_customizer');


function theme_add_custom_image_size() {
    add_image_size('home-thumbnail', 400, 267, true); // Você pode ajustar esses números conforme necessário
}
add_action('after_setup_theme', 'theme_add_custom_image_size');