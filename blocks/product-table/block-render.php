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
            <div class="product-table__products__header product-table__products__header--left">
              <h3 class="product-table__products__heading product-table__products__heading--left">
                Roofing package
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                CLASSIC <br>series
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                DELUXE <br>series
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                PREMIUM <br>series
              </h3>
            </div>

            <?php foreach ( $products_list as $product ) :
              $label = $product['label'];
              $classic = $product['classic'];
              $deluxe = $product['deluxe'];
              $premium = $product['premium'];
              ?>
              <div class="product-table__products__body product-table__products__body--label">
                <h4 class="product-table__products__body__label">
                  <?= wp_kses_post( $label ); ?>
                </h4>
              </div>
              <div class="product-table__products__body">
                <?php if ( $classic['text'] ) : ?>
                  <p class="product-table__products__body__text">
                    <?= wp_kses_post( $classic['text'] ); ?>
                  </p>
                <?php elseif ( $classic['image'] ) : ?>
                  <img src="<?= esc_url( wp_get_attachment_image_src( $classic['image'], 'full' )[0] ); ?>"
                       alt="<?= esc_attr( get_post_meta( $classic['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                       loading="lazy"
                       class="product-table__products__body__image"
                    />
                <?php endif; ?>
              </div>
              <div class="product-table__products__body">
                <?php if ( $deluxe['text'] ) : ?>
                  <p class="product-table__products__body__text">
                    <?= wp_kses_post( $deluxe['text'] ); ?>
                  </p>
                <?php elseif ( $deluxe['image'] ) : ?>
                  <img src="<?= esc_url( wp_get_attachment_image_src( $deluxe['image'], 'full' )[0] ); ?>"
                       alt="<?= esc_attr( get_post_meta( $deluxe['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                       loading="lazy"
                       class="product-table__products__body__image"
                    />
                <?php endif; ?>
              </div>
              <div class="product-table__products__body product-table__products__body--premium">
                <?php if ( $premium['text'] ) : ?>
                  <p class="product-table__products__body__text">
                    <?= wp_kses_post( $premium['text'] ); ?>
                  </p>
                <?php elseif ( $premium['image'] ) : ?>
                  <img src="<?= esc_url( wp_get_attachment_image_src( $premium['image'], 'full' )[0] ); ?>"
                       alt="<?= esc_attr( get_post_meta( $premium['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                       loading="lazy"
                       class="product-table__products__body__image"
                    />
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>