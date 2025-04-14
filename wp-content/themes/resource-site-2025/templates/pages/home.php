
<section class="page-section">
	<inner-column>
		<h1 class="attention-voice intro-text">Start here to find community programs near you. <a class="homepage-all-link" href="<?= site_url('/resource-list'); ?>">Browse all resources</a> or jump into a specific category.</h1>

		<ul class="home-button-grid">
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
        		$icon = get_term_icon($term->slug);
        ?>
        	<li class="home-button">
        		<a class="strong-voice" href="<?php echo get_term_link($term); ?>">
           	 	<span class="icon"><?= $icon ?></span> 
           	 	<?= esc_html($term->name) ?>
        		</a>
        		
        	</li>	
        <?php }
			}
		?>
		</ul>
	</inner-column>
</section>