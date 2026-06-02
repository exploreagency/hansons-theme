<?php
/**
 * Certifications Block
 */

$heading = get_field( 'heading' );
$gallery = get_field( 'gallery' );
?>

<section <?php echo vt_block_attributes( 'certifications', $block ); ?>>
  <div class="container">
    <div class="certifications__wrapper">
      <div class="section__wrapper">
        <?php if ( $heading ) : ?>
          <h2 class="certifications__heading">
            <?= wp_kses_post( $heading ); ?>
          </h2>
        <?php endif; ?>

        <?php if ( $gallery ) : ?>
          <div class="certifications__gallery">
            <?php foreach ( $gallery as $certification ) :
              $image = $certification['image'];
              ?>
              <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                   alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                   loading="lazy"
                   class="certifications__image"
                />
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>