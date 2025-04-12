<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=wp_get_document_title();?></title>

	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
	<header class="site-header">
		<inner-column id="top">
			<h1 class="logo "><a href="<?=get_site_url();?>">Forsyth Community Resources</a></h1>
			<a href="#top" aria-label="Go back to the beginning" class="top-button">Back to top</a>
			<nav class="site-navigation">
				<div class="pdf-list">
					<a href="<?= site_url('/cart'); ?>" class="pdf-list-title strong-voice">
        				My PDF <span id="listCount">[[]]</span>
    				</a>
				</div>
				<?php include('templates/components/site-menu.php'); ?>
			</nav>
		</inner-column>
	</header>

	<main>
