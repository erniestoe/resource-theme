<?php 
session_start(); 

$selected_categories = isset($_SESSION['active_filters']) ? $_SESSION['active_filters'] : [];

if (!empty($selected_categories)) {
    // Only show filtered categories
    foreach ($selected_categories as $slug) {
        $term = get_term_by('slug', $slug, 'category');
        if (!$term) continue;

        $args = [
            'post_type' => 'resource',
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $slug,
                ],
            ],
            'posts_per_page' => -1
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ?>
            <div class="category-title">
              <h2 class="attention-voice" aria-label="Resource Category: <?= esc_html($term->name) ?>">
                <?= esc_html($term->name) ?>
              </h2>
            </div>
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                include getFile('templates/components/resource-card.php');
            }
        }

        wp_reset_postdata();
    }
} else {
    // Show all resources if no filters saved (default / fallback)
    $terms = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => false, 
        'exclude' => [get_cat_ID('Uncategorized')], 
    ]);

    foreach ($terms as $term) {
        $args = [
            'post_type' => 'resource',
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ],
            ],
            'posts_per_page' => -1
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            ?>
            <div class="category-title">
              <h2 class="attention-voice" aria-label="Resource Category: <?= esc_html($term->name) ?>">
                <?= esc_html($term->name) ?>
              </h2>
            </div>
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                include getFile('templates/components/resource-card.php');
            }
        }

        wp_reset_postdata();
    }
}
?>
