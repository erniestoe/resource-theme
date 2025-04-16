<resource-card>
	<div class="resource-text">
		<h2 class="name strong-voice"><?= the_field('name'); ?></h2>
		<p class="description"> <span class="strong-voice">Information:</span> <?= the_field('description'); ?></p>
		<p class="phone"> <span class="strong-voice">Phone:</span> <?= the_field('phone'); ?></p>
		<p class="address"> <span class="strong-voice">Address:</span> <?= the_field('address'); ?></p>
	</div>

	<div class="links-group">
		<a class="website strong-voice" href="<?=the_field('website');?>">Website</a>
		<?php if ( !is_singular('resource') ) { ?>
		<a href="<?php the_permalink();?>"class="read-more strong-voice">Read more</a>
		<?php } ?>
		<?php if ( is_user_logged_in() && current_user_can('administrator')) { 
			$editLink = get_edit_post_link( get_the_ID() );
		?>
		<a href="<?= $editLink ?>"class="update strong-voice">Update Resource</a>
		<?php } ?>
	</div>

	<div class="button-group">
		<form method="post" action="">
  			<input type="hidden" name="pdf_action" value="add_to_cart">
  			<input type="hidden" name="title" value="<?= the_field('name'); ?>">
  			<input type="hidden" name="description" value="<?= the_field('description'); ?>">
  			<input type="hidden" name="phone" value="<?= the_field('phone'); ?>">
  			<input type="hidden" name="address" value="<?= the_field('address'); ?>">
  			<input type="hidden" name="website" value="<?= the_field('website'); ?>">
  			<button class="button strong-voice" type="submit">Add to PDF</button>
		</form>
	</div>
</resource-card>