<?php
/**
 * Testimonials Block
 */

$heading           = get_field( 'heading' );
$rating            = get_field( 'rating' );
$testimonials_list = get_field( 'testimonials_list' );
?>

<section <?php echo vt_block_attributes( 'testimonials', $block ); ?>>
  <div class="container">
    <div class="section__wrapper">
      <div class="section__heading section__heading--center"
           data-orientation="column"
        >
        <?php if ( $heading ) : ?>
          <h2 class="testimonials__heading">
            <?= wp_kses_post( $heading ); ?>
          </h2>
        <?php endif; ?>

        <?php if ( $rating ) : ?>
          <p class="testimonials__rating">
            <?= wp_kses_post( $rating ); ?>
          </p>
        <?php endif; ?>
      </div>

      <?php if ( $testimonials_list ) : ?>
        <div class="testimonials__carousel"
             data-embla
             data-options='{ "loop": true }'
          >
          <div class="embla__viewport">
            <div class="embla__wrapper">
              <?php foreach ( $testimonials_list as $testimonial ) :
                $name = $testimonial['name'];
                $review = $testimonial['review'];
                $source = $testimonial['source'];
                ?>
                <div class="testimonials__carousel__slide">
                  <div class="testimonials__carousel__slide__container">
                    <div class="testimonials__carousel__slide__wrapper">
                      <div class="testimonials__carousel__slide__content">
                        <div class="testimonials__carousel__slide__heading">
                          <svg width="23" height="14" viewBox="0 0 23 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.52239 0.5H11.0112L5.57836 13.5H0L2.52239 0.5ZM13.5336 0.5H22.0224L16.5896 13.5H11.0112L13.5336 0.5Z" fill="currentColor"/>
                          </svg>
                          <span class="testimonials__carousel__slide__rating">
                            ★★★★★
                          </span>
                        </div>

                        <p class="testimonials__carousel__slide__review">
                          <?= wp_kses_post( $review ); ?>
                        </p>
                      </div>

                      <div class="testimonials__carousel__slide__footing">
                        <div class="testimonials__carousel__slide__divider"></div>

                        <div class="testimonials__carousel__slide__source">
                          <p class="testimonials__carousel__slide__name">
                            <?= wp_kses_post( $name ); ?>
                          </p>

                          <img src="<?= esc_url( wp_get_attachment_image_src( $source, 'testimonial-source' )[0] ); ?>"
                               alt="<?= esc_attr( get_post_meta( $source, '_wp_attachment_image_alt', TRUE ) ); ?>"
                               loading="lazy"
                               class="testimonials__carousel__slide__icon"
                            />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <button class="embla__button embla__button--absolute embla__button--absolute--left embla__button--prev"
                  type="button"
                  aria-label="Previous testimonial"
            >
            <svg width="19" height="33" viewBox="0 0 19 33" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.5 32L2 16.5L17.5 1" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
          <button class="embla__button embla__button--absolute embla__button--absolute--right embla__button--next"
                  type="button"
                  aria-label="Next testimonial"
            >
            <svg width="18" height="33" viewBox="0 0 18 33" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.999998 32L16.5 16.5L0.999999 1" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>