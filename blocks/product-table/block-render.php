<?php
/**
 * Product Table Block
 */

$heading           = get_field( 'heading' );
$products_headings = get_field( 'products_headings' );
$products_list     = get_field( 'products_list' );
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

        <?php if ( $products_list && $products_headings ) : ?>
          <div class="product-table__products">
            <div class="product-table__products__header product-table__products__header--left">
              <h3 class="product-table__products__heading product-table__products__heading--left">
                <?= wp_kses_post( $products_headings['label'] ); ?>
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                <?= wp_kses_post( $products_headings['classic'] ); ?>
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                <?= wp_kses_post( $products_headings['deluxe'] ); ?>
              </h3>
            </div>
            <div class="product-table__products__header product-table__products__header--center">
              <h3 class="product-table__products__heading product-table__products__heading--center">
                <?= wp_kses_post( $products_headings['premium'] ); ?>
              </h3>
            </div>

            <?php foreach ( $products_list as $product ) :
              $label = $product['label'];
              $classic = $product['classic'];
              $deluxe = $product['deluxe'];
              $premium = $product['premium'];
              ?>
              <div class="product-table__products__body product-table__products__body--label product-table__products__body--left">
                <h4 class="product-table__products__body__label">
                  <?= wp_kses_post( $label ); ?>
                </h4>
              </div>
              <div class="product-table__products__body product-table__products__body--center">
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
                <?php elseif ( $classic['text'] && $classic['image'] ) : ?>
                  <div class="product-table__products__body__wrapper">
                    <img src="<?= esc_url( wp_get_attachment_image_src( $classic['image'], 'full' )[0] ); ?>"
                         alt="<?= esc_attr( get_post_meta( $classic['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                         loading="lazy"
                         class="product-table__products__body__wrapper__image"
                      />
                    <p class="product-table__products__body__wrapper__text">
                      <?= wp_kses_post( $classic['text'] ); ?>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="product-table__products__body product-table__products__body--center">
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
                <?php elseif ( $deluxe['text'] && $deluxe['image'] ) : ?>
                  <div class="product-table__products__body__wrapper">
                    <img src="<?= esc_url( wp_get_attachment_image_src( $deluxe['image'], 'full' )[0] ); ?>"
                         alt="<?= esc_attr( get_post_meta( $deluxe['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                         loading="lazy"
                         class="product-table__products__body__wrapper__image"
                      />
                    <p class="product-table__products__body__wrapper__text">
                      <?= wp_kses_post( $deluxe['text'] ); ?>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
              <div class="product-table__products__body product-table__products__body--premium product-table__products__body--center">
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
                <?php elseif ( $premium['text'] && $premium['image'] ) : ?>
                  <div class="product-table__products__body__wrapper">
                    <img src="<?= esc_url( wp_get_attachment_image_src( $premium['image'], 'full' )[0] ); ?>"
                         alt="<?= esc_attr( get_post_meta( $premium['image'], '_wp_attachment_image_alt', TRUE ) ); ?>"
                         loading="lazy"
                         class="product-table__products__body__wrapper__image"
                      />
                    <p class="product-table__products__body__wrapper__text">
                      <?= wp_kses_post( $premium['text'] ); ?>
                    </p>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>