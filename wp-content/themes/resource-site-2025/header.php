<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=wp_get_document_title();?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
	<header>
		<inner-column id="top">
			<h1 class="logo loud-voice"><a href="index.php">Header</a></h1>
			<a href="#top" aria-label="Go back to the beginning" class="top-button">Back to top</a>

			<div class="pdf-list">
				<a href="#" class="pdf-list-title strong-voice">
        			My PDF <span id="listCount">[[]]</span>
    			</a>
			</div>
		</inner-column>
	</header>

	<main>
