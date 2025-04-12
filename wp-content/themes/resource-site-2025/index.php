<?php get_header();?>

<?php
	if ( is_page('home') ) {
		include('templates/pages/home.php');
	}

	if ( is_page('resource-list') ) {
		include('templates/pages/resource-list.php');
	}

	if ( is_page('cart')) {
		include('templates/pages/pdf-cart.php');
	}

	if ( is_singular('resource') ) {
		include('templates/pages/resource-detail.php');
	}

	if ( is_404() ) {
		include('templates/pages/404.php');
	}

	if ( is_tax('resource-category')) {
		include('templates/pages/resource-category.php');
	}
?>

<?php get_footer();?>