<section class="page-section">
	<inner-column>
		<h1 class="category-title attention-voice"><?php single_term_title(); ?></h1>

		<?php 
    	$term = get_queried_object(); 
   	$args = [
      	'post_type' => 'resource',
      	'tax_query' => [
        		[
          		'taxonomy' => 'category', 
          		'field'    => 'slug',
          		'terms'    => $term->slug,
        		],
      	],
      	'posts_per_page' => -1
    	];

    	$query = new WP_Query($args);
    	while ( $query->have_posts() ) : $query->the_post();
      	include( getFile('templates/components/resource-card.php') );
    	endwhile;

    	wp_reset_postdata();
    	?>
	</inner-column>
</section>