
  <?php 
      if (!isset($terms)) {
        $terms = get_terms([
        'taxonomy' => 'category',
        'hide_empty' => false, 
        'exclude' => [get_cat_ID('Uncategorized')], 
        ]);
      }
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
         include( getFile('templates/components/resource-card.php') ); 
      }?>
      <?php
      }

      wp_reset_postdata();
    }
?>
