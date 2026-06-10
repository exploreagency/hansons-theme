<?php
/**
 * Product Grid Simple Block
 */

$heading       = get_field( 'heading' );
$description   = get_field( 'description' );
$products_list = get_field( 'products_list' );
?>

<section <?php echo vt_block_attributes( 'product-grid-simple', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--center"
             data-orientation="column"
          >
          <?php if ( $heading ) : ?>
            <h2 class="product-grid-simple__heading">
              <?= wp_kses_post( $heading ); ?>
            </h2>
          <?php endif; ?>

          <?php if ( $description ) : ?>
            <div class="product-grid-simple__description">
              <?= wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ( $products_list ) : ?>
          <div class="product-grid-simple__products">
            <?php foreach ( $products_list as $product ) :
              $heading = $product['heading'];
              $image = $product['image'];
              $feature_list = $product['feature_list'];
              ?>
              <div class="product-grid-simple__product">
                <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                     alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                     loading="lazy"
                     class="product-grid-simple__product__image"
                  />
                <div class="product-grid-simple__product__wrapper">
                  <h3 class="product-grid-simple__product__heading">
                    <?= wp_kses_post( $heading ); ?>
                  </h3>
                  <div class="product-grid-simple__product__feature-list">
                    <?php foreach ( $feature_list as $feature ) :
                      $item = $feature['feature'];
                      ?>
                      <div class="product-grid-simple__product__feature__wrapper">
                        <p class="product-grid-simple__product__feature">
                          <?= wp_kses_post( $item ); ?>
                        </p>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>