<?php

/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}




if (!function_exists('theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function theme_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Theme, use a find and replace
		 * to change 'theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('theme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'theme'),
				'main-menu' => esc_html__('Secondary', 'theme'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'theme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('theme_content_width', 640);
}
add_action('after_setup_theme', 'theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'theme'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'theme_widgets_init');


function theme_scripts()
{
	wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), _S_VERSION);

	wp_enqueue_style('frontend', get_template_directory_uri() . '/dist/css/main.css');
	wp_enqueue_script('frontend-js', get_template_directory_uri() . '/dist/js/main.js', array(), true, true);
	wp_enqueue_script('custom', get_stylesheet_directory_uri(), array(), true, true);
	wp_localize_script('frontend-js', 'ajaxparam', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',

	));
}
add_action('wp_enqueue_scripts', 'theme_scripts');

function clear_phone($phone_str)
{
	$phone_str = preg_replace('/\D+/', '', $phone_str);

	return $phone_str;
}

if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Настройки темы ',
		'menu_title' => 'Настройки темы ',
		'menu_slug'  => "site-options",
	));
}
add_filter(
	'ai1wm_exclude_themes_from_export',
	function ($exclude_filters) {
		$exclude_filters[] = 'theme/node_modules';
		return $exclude_filters;
	}
);






add_filter('excerpt_length', function () {
	return 10;
});

// defer loading of videos
function defer_video_src_to_data($data, $url, $args)
{
	$data = preg_replace('/(src="([^\"\']+)")/', 'src="" data-src-defer="$2"', $data);
	return $data;
} // end function defer_video_src_to_data
add_filter('oembed_result', 'defer_video_src_to_data', 99, 3);
add_filter('embed_oembed_html', 'defer_video_src_to_data', 99, 3);
