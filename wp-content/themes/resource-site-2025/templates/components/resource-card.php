<resource-card>
	<h2 class="name"><?=the_field('name');?></h2>
	<p class="description">Information: <?=the_field('description');?></p>
	<p class="phone">Phone: <?=the_field('phone');?></p>
	<p class="address">Address: <?=the_field('address');?></p>
	<a href="<?=the_field('website');?>">Website</a>
	<div class="button-group">
		<a href="#"class="button strong-voice">Add to PDF</a>
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