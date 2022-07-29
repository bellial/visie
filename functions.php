<?php


if (!function_exists('yourtheme_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     */
    function yourtheme_setup() {

        /**
         * Make theme available for translation.
         * Translations can be placed in the /languages/ directory.
         * The .mo files must use language-only filenames, like languages/de_DE.mo in your theme directory.
         * Unlike plugin language files, a name like my_theme-de_DE.mo will NOT work. 
         * Although plugin language files allow you to specify the text-domain in the filename, this will NOT work with themes. 
         * Language files for themes should include the language shortcut ONLY.
         */

        load_theme_textdomain('your-theme', get_stylesheet_directory() . '/languages');

        /**
         * This feature enables Post Thumbnails (https://codex.wordpress.org/Post_Thumbnails) support for a theme. 
         * Note that you can optionally pass a second argument, $args, 
         * with an array of the Post Types (https://codex.wordpress.org/Post_Types) for which you want to enable this feature.
         */

        add_theme_support('post-thumbnails');
        //add_theme_support( 'post-thumbnails', array( 'post' ) );          // Posts only
        //add_theme_support( 'post-thumbnails', array( 'page' ) );          // Pages only
        //add_theme_support( 'post-thumbnails', array( 'post', 'movie' ) ); // Posts and Movies

        /**
         * To display thumbnails in themes index.php or single.php or custom templates, use:
         * 
         * the_post_thumbnail();
         * 
         * To check if there is a post thumbnail assigned to the post before displaying it, use:
         * 
         * if ( has_post_thumbnail() ) {
         *  the_post_thumbnail();
         * }
         */


        /**
         * This feature enables Post Formats support for a theme. When using child themes, be aware that it
         * will override the formats as defined by the parent theme, not add to it.
         */

        add_theme_support('post-formats');

        /**
         * To enable the specific formats (see supported formats at Post Formats), use:
         * add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
         * To check if there is a ‘quote’ post format assigned to the post, use has_post_format():
         * // In your theme single.php, page.php or custom post type
         * if ( has_post_format( 'quote' ) ) {
         *  echo 'This is a quote.';
         * }
         */

         // This feature enables plugins and themes to manage the document title tag (https://codex.wordpress.org/Title_Tag). 

        add_theme_support('title-tag');

           // Enables Theme_Logo (https://codex.wordpress.org/Theme_Logo) support for a theme.

        add_theme_support('custom-logo');

        /**
            * Note that you can add default arguments using:
            * add_theme_support( 'custom-logo', array(
            *     'height'               => 100,
            *     'width'                => 400,
            *     'flex-height'          => true,
            *     'flex-width'           => true,
            *     'header-text'          => array( 'site-title', 'site-description' ),
            *     'unlink-homepage-logo' => true,
            * ) );
            */

        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */

        add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));



    remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
    remove_action('wp_head', 'wp_generator'); // remove wordpress version
    remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
    remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
    remove_action('wp_head', 'index_rel_link'); // remove link to index page
    remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
    remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles'); // Disabling emoji library from Wordpress.
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Remove shortlink  
    remove_action('wp_head', 'rest_output_link_wp_head', 10); //Disable Link header for the REST API
    remove_action('template_redirect', 'rest_output_link_header', 11, 0); //Disable Link header for the REST API
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); //Remove oEmbed discovery links
    remove_action('wp_head', 'rest_output_link_wp_head', 10); // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('rest_api_init', 'wp_oembed_register_route'); // Remove the REST API endpoint.
    add_filter('embed_oembed_discover', '__return_false'); // Turn off oEmbed auto discovery.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10); // Don't filter oEmbed results.
    remove_action('wp_head', 'wp_oembed_add_discovery_links'); // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_host_js'); // Remove oEmbed-specific JavaScript from the front-end and back-end.
    // Remove all embeds rewrite rules.
    //add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10); // Disable the hooks so that their order can be changed.
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 21); // Put the price after.

endif; // your-theme_setup

add_action('after_setup_theme', 'your-theme_setup');



/* Remove wp version from any enqueued scripts
* --------------------------------------------------------------------------------- */

function remove_css_js_version($src) {
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}

add_filter('style_loader_src', 'remove_css_js_version', 9999);
add_filter('script_loader_src', 'remove_css_js_version', 9999);

// remove wp version number from head and rss

function remove_version() {
    return '';
}

add_filter('the_generator', 'remove_version');



//Page Slug Body Class

function add_slug_body_class($classes) {
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}

add_filter('body_class', 'add_slug_body_class');

/* Custom logo URL on login page
* --------------------------------------------------------------------------------- */

function custom_logo_login_url() {
    return home_url();
}

add_filter('login_headerurl', 'custom_logo_login_url');

/* Custom admin footer
* --------------------------------------------------------------------------------- */

function custom_admin_footer() {
    echo '<a target="_blank" href="' . home_url() . '">' . get_bloginfo('name') . '</a> &copy; ' . date('Y');
}

add_filter('admin_footer_text', 'custom_admin_footer');

/* Remove WordPress logo from top bar
* --------------------------------------------------------------------------------- */

function remove_logo_toolbar($wp_toolbar) {
    global $wp_admin_bar;
    $wp_toolbar->remove_node('wp-logo');
}

add_action('admin_bar_menu', 'remove_logo_toolbar');

/* Add custom logo in WordPress login screen
* --------------------------------------------------------------------------------- */

$location_path = get_stylesheet_directory_uri();
function my_custom_login_logo() {
    global $location_path;
    echo '<style type="text/css">
		.login h1 a {
		background-image:url(' . $location_path . '/assets/images/Logo-header.png);
		width: 280px;
		height: 52px;
		margin-bottom: 0;
		background-size: cover;
	}
	</style>';
}

add_action('login_head', 'my_custom_login_logo');

/* Custom logo title on login page
* --------------------------------------------------------------------------------- */

function custom_logo_login_title() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'custom_logo_login_title');

/* Remove Recent Comments
* --------------------------------------------------------------------------------- */

function remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}

add_action('widgets_init', 'remove_recent_comments_style');

/* Checks if there are any posts in the results
* --------------------------------------------------------------------------------- */

function is_search_has_results() {
    return 0 != $GLOBALS['wp_query']->found_posts;
}

/* Function to create the menu
* --------------------------------------------------------------------------------- */

function default_theme_nav($menu_location, $menu_class, $menu_id) {
    wp_nav_menu(
        array(
            'theme_location'  => $menu_location, // (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
            'menu'            => '', // (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
            'container'       => 'div', // (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
            'container_class' => '', // (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
            // 'container_id'    => $menu_id, // (string) The ID that is applied to the container.
            'menu_class'      => $menu_class, // (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
            'menu_id'         => $menu_id, // (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
            'echo'            => true, // (bool) Whether to echo the menu or return it. Default true.
            'fallback_cb'     => 'wp_page_menu', // (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
            'before'          => '', // (string) Text before the link markup.
            'after'           => '', // (string) Text after the link markup.
            'link_before'     => '', // (string) Text before the link text.
            'link_after'      => '', // (string) Text after the link text.
            //'items_wrap'      => '<ul>%3$s</ul>', // (string) How the list items should be wrapped. Default is a ul with an id and class. Uses printf() format with numbered placeholders.
            'item_spacing'      => 'preserve', // (string) Whether to preserve whitespace within the menu's HTML. Accepts 'preserve' or 'discard'. Default 'preserve'.
            'depth'           => 0, // (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
            'walker'          => '' // (object) Instance of a custom walker class.
        )
    );
}

// Custom login header text.

add_filter('login_headertext', 'customize_login_headertext');

function customize_login_headertext($headertext) {
    $headertext = esc_html__('Welcome', 'plugin-textdomain');
    return $headertext;
}

/*
* Remove JSON API links in header html
*/

function remove_json_api(){

    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');

    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');

    // Remove all embeds rewrite rules.
    //add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

}
add_action('after_setup_theme', 'remove_json_api');

/**
 * Snippet completely disable the REST API and shows {"code":"rest_disabled","message":"The REST API is disabled on this site."} 
 * when visiting http://yoursite.com/wp-json/
 */

function disable_json_api() {

    // Filters for WP-API version 1.x
    add_filter('json_enabled', '__return_false');
    add_filter('json_jsonp_enabled', '__return_false');

    // Filters for WP-API version 2.x
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
}

add_action('after_setup_theme', 'disable_json_api');

/**
 * Enqueue scripts and styles.
 */

function yourtheme_scripts() {
    wp_enqueue_style('your-theme-stylesheet', get_stylesheet_uri(), array(), 'THEME_VERSION');

    // scripts
    wp_enqueue_script('your-theme-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), 'THEME_VERSION', true);
}

add_action('wp_enqueue_scripts', 'yourtheme_scripts', 99);


// Replaces the excerpt "Read More" text by a link

function new_excerpt_more($more) {
    global $post;
    return '<a class="moretag" href="' . get_permalink($post->ID) . '"> [...]</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');

/**
 * Get posts via REST API.
 */
function get_posts_via_rest() {

	// Initialize variable.
	$allposts = '';
	
	// Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
	$response = wp_remote_get( 'https://techcrunch.com/wp-json/wp/v2/posts?per_page=10' );

	// Exit if error.
	if ( is_wp_error( $response ) ) {
		return;
	}

	// Get the body.
	$posts = json_decode( wp_remote_retrieve_body( $response ) );

	// Exit if nothing is returned.
	if ( empty( $posts ) ) {
		return;
	}

	// If there are posts.
	if ( ! empty( $posts ) ) {

		// For each post.
		foreach ( $posts as $post ) {

			// Use print_r($post); to get the details of the post and all available fields
			// Format the date.
			$fordate = date( 'n/j/Y', strtotime( $post->modified ) );

			// Show a linked title and post date.
			$allposts .= '<a href="' . esc_url( $post->link ) . '" target=\"_blank\">' . esc_html( $post->title->rendered ) . '</a>  ' . esc_html( $fordate ) . '<br />';

		}
		
		return $allposts;
	}
    // Post excerpt.
    if ( ! empty( $schema['properties']['excerpt'] ) && isset( $request['excerpt'] ) ) {
        if ( is_string( $request['excerpt'] ) ) {
            $prepared_post->post_excerpt = $request['excerpt'];
        } elseif ( isset( $request['excerpt']['raw'] ) ) {
            $prepared_post->post_excerpt = $request['excerpt']['raw'];
        }
    }
    // Post content.
    if ( ! empty( $schema['properties']['content'] ) && isset( $request['content'] ) ) {
        if ( is_string( $request['content'] ) ) {
            $prepared_post->post_content = $request['content'];
        } elseif ( isset( $request['content']['raw'] ) ) {
            $prepared_post->post_content = $request['content']['raw'];
        }
    }


}
// Register as a shortcode to be used on the site.
add_shortcode( 'get_posts_via_rest_api', 'get_posts_via_rest' );

/**
 * Get posts via SQL.
 */
function get_posts_via_sql() {
$args = array(
	'numberposts'	=> 5
    'date_query' => array(
        array(
    'year'  => $year,
    'month' => $month,
    'day'   =>$day,
    ),
    ),
);
$query = new WP_Query( $args );

   // The Loop
if ( $query->have_posts() ) {
    echo '<ul>';
    while ( $query->have_posts() ) {
        $query->the_post();
        echo '<li>' . get_the_title() . '</li>';
    }
    echo '</ul>';
       /* Restore original Post Data */
    wp_reset_postdata();
} else {
       // no posts found

    }
}
// Register as a shortcode to be used on the site.
add_shortcode( 'get_posts_via_phpmyadmin', 'get_posts_via_sql' );

/**
 * Get posts via CSV.
 */
add_action( "admin_init", function() {
	global $wpdb;

	// Get the data from all those CSVs!
	$posts = function() {
	$data = array();

	// Get array of CSV files
	$files = wp_remote_get( 'https://drive.google.com/file/d/12t47ydLe_lkngDAtVzx_yLKLcKcjYq_w/view' );

	foreach ( $files as $file ) {

		return $data;
	};

	// Simple check to see if the current post exists within the
	//  database. This isn't very efficient, but it works.
	$post_exists = function( $title ) use ( $wpdb, $site ) {

	// Get an array of all posts within our custom post type
	$posts = $wpdb->get_col( "SELECT post_title FROM {$wpdb->posts} WHERE post_type = '{$site["custom-post-type"]}'" );

	// Check if the passed title exists in array
		return in_array( $title, $posts );
	};

	foreach ( $posts() as $post ) {

	    // If the post exists, skip this post and go to the next one
		if ( $post_exists( $post["title"] ) ) {
			continue;
		}

		// Insert the post into the database
		$post["id"] = wp_insert_post( array(
			"post_title" => $post["title"],
			"post_content" => $post["content"],
			"post_status" => "draft"
		));

	}

})
});
