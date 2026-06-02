<?php
/**
 * Call To Action Block
 */

$heading     = get_field( 'heading' );
$description = get_field( 'description' );
$cta         = get_field( 'cta' );
$image       = get_field( 'image' );
?>

<section <?php echo vt_block_attributes( 'call-to-action', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="call-to-action__grid">
          <div class="call-to-action__content">
            <?php if ( $heading ) : ?>
              <h2 class="call-to-action__content__heading">
                <?= wp_kses_post( $heading ); ?>
              </h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
              <div class="call-to-action__content__description">
                <?= wp_kses_post( $description ); ?>
              </div>
            <?php endif; ?>

            <?php if ( $cta ) :
              $url = $cta['url'];
              $label = $cta['title'];
              ?>
              <a href="<?= esc_url( $url ); ?>"
                aria-label="<?= esc_html( $label ); ?>"
                class="call-to-action__content__cta"
                >
                <?= esc_html( $label ); ?>
              </a>
            <?php endif; ?>
          </div>

          <?php if ( $image ) : ?>
            <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                loading="lazy"
                class="call-to-action__image"
              />
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>