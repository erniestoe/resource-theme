<?php 
function getFile($path) {
	return dirname(__FILE__) . '/' . $path;
}

add_filter( 'show_admin_bar', '__return_false' ); // Remove admin bar for all users

function mytheme_enqueue_style() {
	wp_enqueue_style( 'mytheme-style', get_stylesheet_uri() ); 
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_style' );


function register_my_menu() {
	register_nav_menu( 'site-menu', __( 'Site menu' ));
}
add_action( 'init', 'register_my_menu' );

function enqueue_filter_script() {
	wp_enqueue_script(
		'filter-script',
		get_template_directory_uri() . '/js/functions.js',
		[],
		null,
		true
	);

	wp_localize_script('filter-script', 'filter_script_data', [
		'ajax_url' => admin_url('admin-ajax.php')
	]);
}
add_action('wp_enqueue_scripts', 'enqueue_filter_script');

function handle_filter_resources_ajax() {
  $categories = isset($_POST['categories']) ? json_decode(stripslashes($_POST['categories']), true) : [];

  ob_start();

  if (!empty($categories)) {
    foreach ($categories as $slug) {
      $term = get_term_by('slug', $slug, 'category');

      $args = [
        'post_type' => 'resource',
        'posts_per_page' => -1,
        'tax_query' => [
          [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $slug,
          ]
        ]
      ];

      $query = new WP_Query($args);

      if ($query->have_posts()) {
        echo '<h2 class="attention-voice category-title">' . esc_html($term->name) . '</h2>';
        while ($query->have_posts()) {
          $query->the_post();
          include get_template_directory() . '/templates/components/resource-card.php';
        }
      }

      wp_reset_postdata();
    }
  } else {
    // No filters checked — return all posts in default grouped format
    $terms = get_terms([
      'taxonomy' => 'category',
      'hide_empty' => false,
      'exclude' => [get_cat_ID('Uncategorized')],
    ]);

    foreach ($terms as $term) {
      $args = [
        'post_type' => 'resource',
        'posts_per_page' => -1,
        'tax_query' => [
          [
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $term->slug,
          ]
        ]
      ];

      $query = new WP_Query($args);

      if ($query->have_posts()) {
        echo '<h2 class="attention-voice category-title">' . esc_html($term->name) . '</h2>';
        while ($query->have_posts()) {
          $query->the_post();
          include get_template_directory() . '/templates/components/resource-card.php';
        }
      }

      wp_reset_postdata();
    }
  }

  echo ob_get_clean();
  wp_die();
}
add_action('wp_ajax_filter_resources', 'handle_filter_resources_ajax');
add_action('wp_ajax_nopriv_filter_resources', 'handle_filter_resources_ajax');