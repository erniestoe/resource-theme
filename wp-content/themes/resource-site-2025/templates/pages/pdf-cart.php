<?php session_start(); ?>

<section class="page-section">
  <inner-column>
      <h1 class="attention-voice">Resource PDF</h1>

      <?php if (!empty($_SESSION['pdf_cart'])){ ?>
        <form method="post">
          <ul class="cart-resources">
            <?php foreach ($_SESSION['pdf_cart'] as $index => $resource){ ?>
              <li>
                <p class="strong-voice"><?= esc_html($resource['title']); ?></p>
                <p><span class="strong-voice">Information:</span> <?= esc_html($resource['description']); ?></p>
                <?php if (!empty($resource['phone'])){ ?>
                  <p><span class="strong-voice">Phone:</span> <?= esc_html($resource['phone']); ?></p>
                <?php } ?>
                <?php if (!empty($resource['address'])){ ?>
                  <p><span class="strong-voice">Address:</span> <?= esc_html($resource['address']); ?></p>
                <?php } ?>
                <?php if (!empty($resource['website'])){ ?>
                  <a class="website" href="<?= esc_url($resource['website']); ?>" target="_blank">Website</a>
                <?php } ?>

                
                <button class="button strong-voice" type="submit" name="pdf_action" value="remove_from_cart">
                  Remove
                </button>
                <input type="hidden" name="index" value="<?= $index; ?>">
              </li>
            <?php } ?>
          </ul>

          <button class="button strong-voice" type="submit" name="pdf_action" value="download_pdf">
            Download PDF
          </button>
        </form>
      <?php } else { ?>
        <p>Your resources PDF is empty. <a href="javascript:history.go(-1)">Go back?</a></p>
      <?php } ?>
  </inner-column>
</section>
