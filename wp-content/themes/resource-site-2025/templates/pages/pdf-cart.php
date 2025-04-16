<?php session_start(); ?>

<section class="page-section">
  <inner-column>
    <div class="pdf-cart-container">
      <h1>PDF Resource Cart</h1>

      <?php if (!empty($_SESSION['pdf_cart'])){ ?>
        <form method="post">
          <ul>
            <?php foreach ($_SESSION['pdf_cart'] as $index => $resource){ ?>
              <li>
                <p><?= esc_html($resource['title']); ?></p>
                <p><?= esc_html($resource['description']); ?></p>
                <?php if (!empty($resource['phone'])){ ?>
                  <p>Phone: <?= esc_html($resource['phone']); ?></p>
                <?php } ?>
                <?php if (!empty($resource['address'])){ ?>
                  <p>Address: <?= esc_html($resource['address']); ?></p>
                <?php } ?>
                <?php if (!empty($resource['website'])){ ?>
                  <p>Website: <a href="<?= esc_url($resource['website']); ?>" target="_blank"><?= esc_html($resource['website']); ?></a></p>
                <?php } ?>

                
                <button class="button" type="submit" name="pdf_action" value="remove_from_cart">
                  Remove
                </button>
                <input type="hidden" name="index" value="<?= $index; ?>">
              </li>
            <?php } ?>
          </ul>

         
          <button class="button" type="submit" name="pdf_action" value="download_pdf">
            Download PDF
          </button>
        </form>
      <?php } else { ?>
        <p>Your PDF cart is empty. <a href="<?= esc_url(site_url('/resource-list')); ?>">Go back</a></p>
      <?php } ?>
    </div>
  </inner-column>
</section>
