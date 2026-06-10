<?php
/**
 * Product Carousel Block
 */

$heading       = get_field( 'heading' );
$description   = get_field( 'description' );
$products_list = get_field( 'products_list' );
?>

<section <?php echo vt_block_attributes( 'product-carousel', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--center"
             data-orientation="column"
          >
          <?php if ( $heading ) : ?>
            <h2 class="product-carousel__heading">
              <?= wp_kses_post( $heading ); ?>
            </h2>
          <?php endif; ?>

          <?php if ( $description ) : ?>
            <div class="product-carousel__description">
              <?= wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php if ( $products_list ) : ?>
          <div class="product-caoursel__carousel"
               data-embla
               data-options='{ "loop": true, "align": "start" }'
            >
            <div class="embla__viewport">
              <div class="embla__wrapper">
                <?php foreach ( $products_list as $product ) :
                  $image = $product['image'];
                  $heading = $product['heading'];
                  ?>
                  <div class="product-caoursel__carousel__slide">
                    <div class="tproduct-caoursel__carousel__slide__container">
                      <div class="product-caoursel__carousel__slide__wrapper">
                        <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                             alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                             loading="lazy"
                             class="product-carousel__carousel__slide__image"
                          />
                        <h3 class="product-carousel__carousel__slide__heading">
                          <?= wp_kses_post( $heading ); ?>
                        </h3>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <button class="embla__button embla__button--absolute embla__button--absolute--left embla__button--prev"
                    type="button"
                    aria-label="Previous product"
              >
              <svg width="19" height="33" viewBox="0 0 19 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.5 32L2 16.5L17.5 1" stroke="currentColor" stroke-width="2"/>
              </svg>
            </button>
            <button class="embla__button embla__button--absolute embla__button--absolute--right embla__button--next"
                    type="button"
                    aria-label="Next product"
              >
              <svg width="18" height="33" viewBox="0 0 18 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.999998 32L16.5 16.5L0.999999 1" stroke="currentColor" stroke-width="2"/>
              </svg>
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>