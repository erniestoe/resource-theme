<section class="page-section">
	<inner-column class="resource-grid">
		<div class="category-title">
			<h1 class=" attention-voice"><?php single_term_title(); ?></h1>
		</div>
		

		<?php 
    	$term = get_queried_object(); 
   	$args = [
      	'post_type' => 'resource',
      	'tax_query' => [
        		[
          		'taxonomy' => 'resource-category', 
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