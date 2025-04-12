<resource-card>
	<h2 class="name"><?=the_field('name');?></h2>
	<p class="description">Information: <?=the_field('description');?></p>
	<p class="phone">Phone: <?=the_field('phone');?></p>
	<p class="address">Address: <?=the_field('address');?></p>
	<a href="<?=the_field('website');?>">Website</a>
	<div class="button-group">
		<a href="#"class="button strong-voice">Add to PDF</a>
		<a href="<?php the_permalink();?>"class="button strong-voice">Read more</a>
	</div>
</resource-card>