<?php 
session_start();
$active_filters = $_SESSION['active_filters'] ?? [];
?>
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
							<input type="checkbox" name="category[]" value="<?= esc_attr($category->slug) ?>"
							<?= in_array($category->slug, $active_filters) ? 'checked' : '' ?>>
							<?= esc_html($category->name) ?>
						</label>
					</div>
				<?php }?>
			</form>
		<?php }?>
		<a  href="<?=get_template_directory_uri();?>/reset-filters.php">Clear filters</a>
	</inner-column>
</filter>