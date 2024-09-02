<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="preload" href="https://securepubads.g.doubleclick.net/tag/js/gpt.js" as="script" type="text/javascript" crossorigin>
<script src="https://securepubads.g.doubleclick.net/tag/js/gpt.js" crossorigin="anonymous" async></script>
	
<link rel="preload" href="/wp-content/themes/norder-monetization/fonts/Poppins-Regular.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/wp-content/themes/norder-monetization/fonts/Poppins-Bold.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/wp-content/themes/norder-monetization/fonts/Poppins-Light.woff2" as="font" type="font/woff2" crossorigin>

<?php wp_head(); ?>

<style type="text/css">
	#header{
		background: <?php echo esc_attr(get_theme_mod('header_color','#FFF')); ?>;
		color:<?php echo esc_attr(get_theme_mod('header_color_text','#FFF')); ?>;
	}
	#header #menu_topo a{
		color:<?php echo esc_attr(get_theme_mod('header_color_text','#FFF')); ?>;
		text-decoration:none;
	}
	#header .entry-title a, #header .entry-categories a, #header .posted-on a {
		color:<?php echo esc_attr(get_theme_mod('header_color_text','#FFF')); ?>;
	}
	.entry-title a, .entry-categories a, .posted-on a {
		color:<?php echo esc_attr(get_theme_mod('header_color','#000')); ?>;
	}
	#menu_topo > nav::before{
		background: <?php echo esc_attr(get_theme_mod('header_color_text','#FFF')); ?>;
	}
	a.link{
		background: <?php echo esc_attr(get_theme_mod('header_color','#FFF')); ?>;
		color:<?php echo esc_attr(get_theme_mod('header_color_text','#FFF')); ?>;
	}
	#footer{
		background: <?php echo esc_attr(get_theme_mod('footer_color','#FFF')); ?>;
		color:<?php echo esc_attr(get_theme_mod('footer_color_text','#FFF')); ?>;
	}
	#footer p, #footer a, .privacy-policy-link {
		color:<?php echo esc_attr(get_theme_mod('footer_color_text','#FFF')); ?> !important;
	}
	#container{
		background: <?php echo esc_attr(get_theme_mod('body_color','#FFF')); ?>;
		color:<?php echo esc_attr(get_theme_mod('body_color_text','#FFF')); ?>;
	}
	.about-us {
        background-color: <?php echo esc_attr(get_theme_mod('about_us_background_color', '#ffffff')); ?>;
        color: <?php echo esc_attr(get_theme_mod('about_us_text_color', '#000000')); ?>;
    }
	
</style>

</head>

<body <?php body_class(); ?>>
	<?php wp_body_open() ?>
<header id="header">
    <div class="container">
        <section id="logo_site">
		<?php
		$logo_info = get_custom_logo_info();
		$site_name = get_bloginfo('name');
		$site_description = get_bloginfo('description');
		if ($logo_info['url']) {
		    echo '<a href="' . esc_url(home_url('/')) . '" rel="home" itemprop="url">';
		    echo '<img src="' . esc_url($logo_info['url']) . '" 
		              width="' . esc_attr($logo_info['width']) . '" 
		              height="' . esc_attr($logo_info['height']) . '" 
		              alt="' . esc_attr($site_name) . ' - ' . esc_attr($site_description) . '" 
		              itemprop="logo">';
		    echo '</a>';
		} else {
		    echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home" itemprop="url">' . esc_html($site_name) . '</a></h1>';
		    echo '<p class="site-description">' . esc_html($site_description) . '</p>';
		}
		?>
        </section>
        <section id="menu_topo">
            <nav role="navigation" aria-label="Menu principal">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </nav>
        </section>
    </div>
</header>