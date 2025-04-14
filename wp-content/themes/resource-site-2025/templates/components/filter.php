<filter>
	<inner-column>
		<?php 
		$categories = get_terms([
			'taxonomy' => 'category',
			'hide_empty' => false, 
      	'exclude' => [get_cat_ID('Uncategorized')]
		]);

		if (!empty($categories) && !is_wp_error($categories)) { ?>
			<form id="resource-filter" class="resource-filter">
				<?php foreach($categories as $category){?>
					<div class="field">
						<label class="pill">
							<input type="checkbox" name="category[]" value="<?= esc_attr($category->slug) ?>">
							<?= esc_html($category->name) ?>
						</label>
					</div>
				<?php }?>
			</form>
		<?php }?>
		<a  href="<?=site_url('/resource-list')?>">Clear filters</a>
	</inner-column>
</filter>