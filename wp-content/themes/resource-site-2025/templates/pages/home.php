
<section class="page-section">
	<inner-column>
		<h1 class="attention-voice intro-text">Start here to find community programs near you. Browse all resources or jump into a specific category.</h1>
		

		<ul class="home-button-grid">
			<li><a class="button strong-voice" href="<?= site_url('/resource-list'); ?>">All Resources</a></li>
		<?php
		$terms = get_terms(array(
   			'taxonomy' => 'resource-category',
   			'hide_empty' => false,
    		'orderby' => 'name',
    		'order' => 'ASC',
		));

		if (!empty($terms) && !is_wp_error($terms)) {
    		foreach ($terms as $term) {
        		if ($term->slug === 'uncategorized') continue;
        ?>
        	<li>
        		<a class="button strong-voice" href="<?php echo get_term_link($term); ?>">
           	 	<?php echo esc_html($term->name); ?>
        		</a>
        	</li>	
        <?php }
			}
		?>
		</ul>
	</inner-column>
</section>