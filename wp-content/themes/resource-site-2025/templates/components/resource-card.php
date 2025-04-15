<resource-card>
	<div class="resource-text">
		<h2 class="name strong-voice"><?=the_field('name');?></h2>
		<p class="description"> <span class="strong-voice">Information:</span> <?=the_field('description');?></p>
		<p class="phone"> <span class="strong-voice">Phone:</span> <?=the_field('phone');?></p>
		<p class="address"> <span class="strong-voice">Address:</span> <?=the_field('address');?></p>
		<a class="website strong-voice" href="<?=the_field('website');?>">Website</a>
	</div>
	<div class="button-group">
		<?php if ( !is_singular('resource') ) { ?>
			<a href="<?php the_permalink();?>"class="button strong-voice">Read more</a>
		<?php } ?>
		
		<?php if ( is_user_logged_in() && current_user_can('administrator')) { 
			$editLink = get_edit_post_link( get_the_ID() );
		?>
			<a href="<?= $editLink ?>"class="button strong-voice">Update Resource</a>
		<?php } ?>
	</div>
</resource-card>