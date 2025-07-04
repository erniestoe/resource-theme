<?php session_start(); ?>

<section class="page-section">
  <inner-column>
    <pdf-cart>
      <h1 class="attention-voice">Resource PDF</h1>

      <?php if (!empty($_SESSION['pdf_cart'])){ ?>
        
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
                <form method="post">
                  <input type="hidden" name="index" value="<?= $index; ?>">
                  <input type="hidden" name="pdf_action" value="remove_item_from_cart">
                  <button class="button strong-voice" type="submit">Remove</button>
                </form>
              </li>
            <?php } ?>
          </ul>



          <form method="post" action="<?= admin_url('admin-post.php'); ?>">
            <div class="buttons">
            <button class="button strong-voice" onclick="window.print()">Print / Save as PDF</button>

              <button class="button strong-voice" type="submit" name="pdf_action" value="remove_pdf">
                Remove all
             </button>
            </div>
          </form>
          
        <p class="message"></p>  
      <?php } else { ?>
        <p>Your resources PDF is empty. <a href="javascript:history.go(-1)">Go back?</a></p>
      <?php } ?>
    </pdf-cart>  
  </inner-column>
</section>
