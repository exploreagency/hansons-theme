<?php
/**
 * Product Table Block
 */

$heading       = get_field( 'heading' );
$products_list = get_field( 'products_list' );
?>

<section <?php echo vt_block_attributes( 'product-table', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--center"
             data-orientation="column"
          >
          <?php if ( $heading ) : ?>
            <h2 class="product-table__heading">
              <?= wp_kses_post( $heading ); ?>
            </h2>
          <?php endif; ?>
        </div>

        <?php if ( $products_list ) : ?>
          <div class="product-table__products">

          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>