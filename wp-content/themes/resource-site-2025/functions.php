<?php 
//This looks gross... but issa WIP
function cptui_register_my_cpts() {

  /**
   * Post Type: Resources.
   */

  $labels = [
    "name" => esc_html__( "Resources", "resourcesite2025" ),
    "singular_name" => esc_html__( "Resource", "resourcesite2025" ),
  ];

  $args = [
    "label" => esc_html__( "Resources", "resourcesite2025" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "rest_namespace" => "wp/v2",
    "has_archive" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "can_export" => true,
    "rewrite" => [ "slug" => "resources", "with_front" => true ],
    "query_var" => true,
    "menu_icon" => "dashicons-book",
    "supports" => [ "title", "editor", "thumbnail" ],
    "taxonomies" => [ "resource-category" ],
    "show_in_graphql" => false,
  ];

  register_post_type( "resource", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);

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
      $term = get_term_by('slug', $slug, 'resource-category');

      $args = [
        'post_type' => 'resource',
        'posts_per_page' => 5,
        'tax_query' => [
          [
            'taxonomy' => 'resource-category',
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
    // If no filters are checked default to all resources grouped by category
    $terms = get_terms([
      'taxonomy' => 'resource-category',
      'hide_empty' => false,
      'exclude' => [get_cat_ID('Uncategorized')],
    ]);

    foreach ($terms as $term) {
      $args = [
        'post_type' => 'resource',
        'posts_per_page' => 5,
        'tax_query' => [
          [
            'taxonomy' => 'resource-category',
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

function save_filter_selection_to_session() {
  session_start();

  if (isset($_POST['categories'])) {
    $_SESSION['active_filters'] = json_decode(stripslashes($_POST['categories']), true);
  }

  wp_send_json_success();
}
add_action('wp_ajax_save_filter_session', 'save_filter_selection_to_session');
add_action('wp_ajax_nopriv_save_filter_session', 'save_filter_selection_to_session');

function get_term_icon($slug) {
  switch ($slug) {
    case 'childcare-assistance':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M160,32h-8a16,16,0,0,0-16,16v56H55.2A40.07,40.07,0,0,0,16,72a8,8,0,0,0,0,16,24,24,0,0,1,24,24,80.09,80.09,0,0,0,80,80h40a80,80,0,0,0,0-160Zm63.48,72H166.81l41.86-33.49A63.73,63.73,0,0,1,223.48,104ZM160,48a63.59,63.59,0,0,1,36.69,11.61L152,95.35V48Zm0,128H120a64.09,64.09,0,0,1-63.5-56h167A64.09,64.09,0,0,1,160,176Zm-56,48a16,16,0,1,1-16-16A16,16,0,0,1,104,224Zm104,0a16,16,0,1,1-16-16A16,16,0,0,1,208,224Z"></path></svg>';
    case 'clothing':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M247.59,61.22,195.83,33A8,8,0,0,0,192,32H160a8,8,0,0,0-8,8,24,24,0,0,1-48,0,8,8,0,0,0-8-8H64a8,8,0,0,0-3.84,1L8.41,61.22A15.76,15.76,0,0,0,1.82,82.48l19.27,36.81A16.37,16.37,0,0,0,35.67,128H56v80a16,16,0,0,0,16,16H184a16,16,0,0,0,16-16V128h20.34a16.37,16.37,0,0,0,14.58-8.71l19.27-36.81A15.76,15.76,0,0,0,247.59,61.22ZM35.67,112a.62.62,0,0,1-.41-.13L16.09,75.26,56,53.48V112ZM184,208H72V48h16.8a40,40,0,0,0,78.38,0H184Zm36.75-96.14a.55.55,0,0,1-.41.14H200V53.48l39.92,21.78Z"></path></svg>';
    case 'employment':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M210.78,39.25l-130.25-23A16,16,0,0,0,62,29.23l-29.75,169a16,16,0,0,0,13,18.53l130.25,23h0a16,16,0,0,0,18.54-13l29.75-169A16,16,0,0,0,210.78,39.25ZM178.26,224h0L48,201,77.75,32,208,55ZM89.34,58.42a8,8,0,0,1,9.27-6.48l83,14.65a8,8,0,0,1-1.39,15.88,8.36,8.36,0,0,1-1.4-.12l-83-14.66A8,8,0,0,1,89.34,58.42ZM83.8,89.94a8,8,0,0,1,9.27-6.49l83,14.66A8,8,0,0,1,174.67,114a7.55,7.55,0,0,1-1.41-.13l-83-14.65A8,8,0,0,1,83.8,89.94Zm-5.55,31.51A8,8,0,0,1,87.52,115L129,122.29a8,8,0,0,1-1.38,15.88,8.27,8.27,0,0,1-1.4-.12l-41.5-7.33A8,8,0,0,1,78.25,121.45Z"></path></svg>';
    case 'financial':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M128,88a40,40,0,1,0,40,40A40,40,0,0,0,128,88Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,152ZM240,56H16a8,8,0,0,0-8,8V192a8,8,0,0,0,8,8H240a8,8,0,0,0,8-8V64A8,8,0,0,0,240,56ZM193.65,184H62.35A56.78,56.78,0,0,0,24,145.65v-35.3A56.78,56.78,0,0,0,62.35,72h131.3A56.78,56.78,0,0,0,232,110.35v35.3A56.78,56.78,0,0,0,193.65,184ZM232,93.37A40.81,40.81,0,0,1,210.63,72H232ZM45.37,72A40.81,40.81,0,0,1,24,93.37V72ZM24,162.63A40.81,40.81,0,0,1,45.37,184H24ZM210.63,184A40.81,40.81,0,0,1,232,162.63V184Z"></path></svg>';
    case 'government':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M240,208h-8V72a8,8,0,0,0-8-8H184V40a8,8,0,0,0-8-8H80a8,8,0,0,0-8,8V96H32a8,8,0,0,0-8,8V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM40,112H80a8,8,0,0,0,8-8V48h80V72a8,8,0,0,0,8,8h40V208H152V168a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v40H40Zm96,96H120V176h16ZM112,72a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H120A8,8,0,0,1,112,72Zm0,32a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H120A8,8,0,0,1,112,104Zm56,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H176A8,8,0,0,1,168,104ZM88,136a8,8,0,0,1-8,8H64a8,8,0,0,1,0-16H80A8,8,0,0,1,88,136Zm0,32a8,8,0,0,1-8,8H64a8,8,0,0,1,0-16H80A8,8,0,0,1,88,168Zm24-32a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H120A8,8,0,0,1,112,136Zm56,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H176A8,8,0,0,1,168,136Zm0,32a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H176A8,8,0,0,1,168,168Z"></path></svg>';
    case 'legal':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M239.43,133l-32-80h0a8,8,0,0,0-9.16-4.84L136,62V40a8,8,0,0,0-16,0V65.58L54.26,80.19A8,8,0,0,0,48.57,85h0v.06L16.57,165a7.92,7.92,0,0,0-.57,3c0,23.31,24.54,32,40,32s40-8.69,40-32a7.92,7.92,0,0,0-.57-3L66.92,93.77,120,82V208H104a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16H136V78.42L187,67.1,160.57,133a7.92,7.92,0,0,0-.57,3c0,23.31,24.54,32,40,32s40-8.69,40-32A7.92,7.92,0,0,0,239.43,133ZM56,184c-7.53,0-22.76-3.61-23.93-14.64L56,109.54l23.93,59.82C78.76,180.39,63.53,184,56,184Zm144-32c-7.53,0-22.76-3.61-23.93-14.64L200,77.54l23.93,59.82C222.76,148.39,207.53,152,200,152Z"></path></svg>';
    case 'transportation':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M184,32H72A32,32,0,0,0,40,64V208a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V192h64v16a16,16,0,0,0,16,16h24a16,16,0,0,0,16-16V64A32,32,0,0,0,184,32ZM56,176V120H200v56Zm0-96H200v24H56ZM72,48H184a16,16,0,0,1,16,16H56A16,16,0,0,1,72,48Zm8,160H56V192H80Zm96,0V192h24v16Zm-72-60a12,12,0,1,1-12-12A12,12,0,0,1,104,148Zm72,0a12,12,0,1,1-12-12A12,12,0,0,1,176,148Zm72-68v24a8,8,0,0,1-16,0V80a8,8,0,0,1,16,0ZM24,80v24a8,8,0,0,1-16,0V80a8,8,0,0,1,16,0Z"></path></svg>';
    case 'education-training':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M226.53,56.41l-96-32a8,8,0,0,0-5.06,0l-96,32A8,8,0,0,0,24,64v80a8,8,0,0,0,16,0V75.1L73.59,86.29a64,64,0,0,0,20.65,88.05c-18,7.06-33.56,19.83-44.94,37.29a8,8,0,1,0,13.4,8.74C77.77,197.25,101.57,184,128,184s50.23,13.25,65.3,36.37a8,8,0,0,0,13.4-8.74c-11.38-17.46-27-30.23-44.94-37.29a64,64,0,0,0,20.65-88l44.12-14.7a8,8,0,0,0,0-15.18ZM176,120A48,48,0,1,1,89.35,91.55l36.12,12a8,8,0,0,0,5.06,0l36.12-12A47.89,47.89,0,0,1,176,120ZM128,87.57,57.3,64,128,40.43,198.7,64Z"></path></svg>';
    case 'family-services':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z"></path></svg>';
    case 'food':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M240,80a40,40,0,0,0-40-40H48a40,40,0,0,0-16,76.65V200a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V116.65A40.06,40.06,0,0,0,240,80ZM48,120a8,8,0,0,0,0-16,24,24,0,0,1,0-48h96a24,24,0,0,1,0,48,8,8,0,0,0,0,16v80H48Zm152-16a8,8,0,0,0,0,16v80H160V116.65A40,40,0,0,0,176,56h24a24,24,0,0,1,0,48Z"></path></svg>';
    case 'housing':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M219.31,108.68l-80-80a16,16,0,0,0-22.62,0l-80,80A15.87,15.87,0,0,0,32,120v96a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V160h32v56a8,8,0,0,0,8,8h64a8,8,0,0,0,8-8V120A15.87,15.87,0,0,0,219.31,108.68ZM208,208H160V152a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8v56H48V120l80-80,80,80Z"></path></svg>';
    case 'medical-mental-health':
      return '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M248,208h-8V128a16,16,0,0,0-16-16H168V48a16,16,0,0,0-16-16H56A16,16,0,0,0,40,48V208H32a8,8,0,0,0,0,16H248a8,8,0,0,0,0-16Zm-24-80v80H168V128ZM56,48h96V208H136V160a8,8,0,0,0-8-8H80a8,8,0,0,0-8,8v48H56Zm64,160H88V168h32ZM72,96a8,8,0,0,1,8-8H96V72a8,8,0,0,1,16,0V88h16a8,8,0,0,1,0,16H112v16a8,8,0,0,1-16,0V104H80A8,8,0,0,1,72,96Z"></path></svg>';
  }
}

add_action('template_redirect', function () {
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pdf_action'])) {
    if (!session_id()) session_start();

    if ($_POST['pdf_action'] === 'add_to_cart') {
      $item = [
        'title' => sanitize_text_field($_POST['title']),
        'description' => sanitize_textarea_field($_POST['description']),
        'phone' => sanitize_text_field($_POST['phone']),
        'address' => sanitize_text_field($_POST['address']),
        'website' => esc_url_raw($_POST['website']),
      ];

  
      if (!isset($_SESSION['pdf_cart'])) {
        $_SESSION['pdf_cart'] = [];
      }
   
      foreach ($_SESSION['pdf_cart'] as $existing) {
        if ($existing['title'] === $item['title']) {
          wp_redirect($_SERVER['REQUEST_URI']);
          exit;
        }
      }

      $_SESSION['pdf_cart'][] = $item;

      wp_redirect($_SERVER['REQUEST_URI']); // Prevent resubmission
      exit;
    }

    if ($_POST['pdf_action'] === 'download_pdf') {
      generate_pdf_from_cart(); 
      exit;
    }

    if ($_POST['pdf_action'] === 'remove_pdf') {
      unset($_SESSION['pdf_cart']);

      if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
      ) {
        echo 'cleared';
        exit;
      }

      wp_redirect($_SERVER['REQUEST_URI']);
      exit;
    }

    if ($_POST['pdf_action'] === 'remove_item_from_cart' && isset($_POST['index'])) {
      $index = (int) $_POST['index'];

      if (isset($_SESSION['pdf_cart'][$index])) {
        unset($_SESSION['pdf_cart'][$index]);
        $_SESSION['pdf_cart'] = array_values($_SESSION['pdf_cart']);
      }

      if (
        !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
      ) {
        echo 'removed';
        exit;
      }

      wp_redirect($_SERVER['REQUEST_URI']);
      exit;
    }
  }
});

//Get session data and generate pdf from resouces when called
function generate_pdf_from_cart() {
  if (!session_id()) session_start();

  if (!isset($_SESSION['pdf_cart']) || empty($_SESSION['pdf_cart'])) {
    wp_die('No resources selected. <a href="' . esc_url(home_url()) . '">Go back</a>');
  }

  require_once get_template_directory() . '/includes/fpdf/fpdf.php';

  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(40, 10, 'Community Resources');
  $pdf->Ln(10);

  foreach ($_SESSION['pdf_cart'] as $resource) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $resource["title"], 0, 1);

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, "Description: " . $resource["description"]);
    if (!empty($resource["phone"])) {
      $pdf->Cell(0, 6, "Phone: " . $resource["phone"], 0, 1);
    }
    if (!empty($resource["address"])) {
      $pdf->Cell(0, 6, "Address: " . $resource["address"], 0, 1);
    }
    if (!empty($resource["website"])) {
      $pdf->Cell(0, 6, "Website: " . $resource["website"], 0, 1);
    }

    $pdf->Ln(10);
  }

  $pdf->Output("resources.pdf", "D");

  unset($_SESSION['pdf_cart']);
  exit;
}
add_action('admin_post_remove_from_pdf_cart', 'handle_pdf_cart_removal');
add_action('admin_post_nopriv_remove_from_pdf_cart', 'handle_pdf_cart_removal');
