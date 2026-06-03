<?php
/**
 * Product Grid Block
 */

$heading          = get_field( 'heading' );
$description      = get_field( 'description' );
$products_list    = get_field( 'products_list' );
?>

<section <?php echo vt_block_attributes( 'product-grid', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--center"
             data-orientation="column"
          >
          <?php if ( $heading ) : ?>
            <h2 class="product-grid__heading">
              <?= wp_kses_post( $heading ); ?>
            </h2>
          <?php endif; ?>

          <?php if ( $description ) : ?>
            <div class="product-grid__description">
              <?= wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ( $products_list ) : ?>
          <div class="product-grid__products">
            <?php foreach ( $products_list as $product ) :
              $best_check = $product['best_check'];
              $heading = $product['heading'];
              $image = $product['image'];
              $subheading = $product['subheading'];
              $feature_list = $product['feature_list'];
              $secondary_feature_list = $product['secondary_feature_list'];
              ?>
              <div class="product-grid__product"
                   x-data="{ open: false }"
                >
                <?php if ( $best_check ) : ?>
                  <div class="product-grid__product__banner">
                    <span>Best-in-class</span>
                  </div>
                <?php endif; ?>
                <div class="product-grid__product__wrapper">
                  <h3 class="product-grid__product__heading">
                    <?= wp_kses_post( $heading ); ?>
                  </h3>
                  <div class="product-grid__product__divider"></div>
                  <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                      alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                      loading="lazy"
                      class="product-grid__product__image"
                    />
                  <h4 class="product-grid__product__subheading">
                    <?= wp_kses_post( $subheading ); ?>
                  </h4>
                  <div class="product-grid__product__feature-list">
                    <?php foreach ( $feature_list as $feature ) :
                      $item = $feature['feature'];
                      ?>
                      <p class="product-grid__product__feature">
                        <?= wp_kses_post( $item ); ?>
                      </p>
                    <?php endforeach; ?>
                  </div>
                </div>
                <?php if ( $secondary_feature_list ) : ?>
                  <button class="product-grid__product__toggle"
                          type="button"
                          @click="open = !open"
                          :aria-expanded="open.toString()"
                    >
                      <span x-text="open ? '- Hide All Features' : '+ See All Features'"></span>
                  </button>
                  <div class="product-grid__product__secondary-feature-list"
                       x-show="open"
                       x-collapse
                       x-cloak
                    >
                    <?php foreach ( $secondary_feature_list as $feature ) :
                      $heading = $feature['heading'];
                      $feature_text = $feature['feature_text'];
                      $feature_image = $feature['feature_image'];
                      ?>
                      <div class="product-grid__product__secondary-feature">
                        <div class="product-grid__product__secondary-feature__heading__wrapper">
                          <h6 class="product-grid__product__secondary-feature__heading">
                            <?= wp_kses_post( $heading ); ?>
                          </h6>
                        </div>
                        <div class="product-grid__product__secondary-feature__content">
                          <?php if ( $feature_text ) : ?>
                            <p class="product-grid__product__secondary-feature__text">
                              <?= wp_kses_post( $feature_text ); ?>
                            </p>
                          <?php elseif ( $feature_image ) : ?>
                            <img src="<?= esc_url( wp_get_attachment_image_src( $feature_image, 'full' )[0] ); ?>"
                                 alt="<?= esc_attr( get_post_meta( $feature_image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                                 loading="lazy"
                                 class="product-grid__product__secondary-feature__image"
                              />
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
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