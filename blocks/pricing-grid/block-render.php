<?php
/**
 * Pricing Grid Block
 */

$heading      = get_field( 'heading' );
$description  = get_field( 'description' );
$pricing_list = get_field( 'pricing_list' );
$footnote     = get_field( 'footnote' );
$cta          = get_field( 'cta' );
?>

<section <?php echo vt_block_attributes( 'pricing-grid', $block ); ?>>
  <div class="container">
    <div class="section__wrapper">
      <?php if ( $heading ) : ?>
        <h2 class="pricing-grid__heading">
          <?= wp_kses_post( $heading ); ?>
        </h2>
      <?php endif; ?>

      <?php if ( $description ) : ?>
        <div class="pricing-grid__description">
          <?= wp_kses_post( $description ); ?>
        </div>  
      <?php endif; ?>

      <?php if ( $pricing_list ) : ?>
        <div class="pricing-grid__cards">
          <?php foreach ( $pricing_list as $pricing ) :
            $icon = $pricing['icon'];
            $heading = $pricing['heading'];
            $description = $pricing['description'];
            ?>
            <div class="pricing-grid__card">
              <img src="<?= esc_url( wp_get_attachment_image_src( $icon, 'full' )[0] ); ?>"
                   alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                   loading="lazy"
                   class="pricing-grid__card__icon"
                />
              <h3 class="pricing-grid__card__heading">
                <?= wp_kses_post( $heading ); ?>
              </h3>
              <p class="pricing-grid__card__description">
                <?= wp_kses_post( $description ); ?>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if ( $footnote ) : ?>
        <div class="pricing-grid__footnote">
          <?= wp_kses_post( $footnote ); ?>
        </div>  
      <?php endif; ?>

      <?php if ( $cta ) :
        $url = $cta['url'];
        $label = $cta['title'];
        ?>
        <a href="<?= esc_url( $url ); ?>"
           aria-label="<?= esc_html( $label ); ?>"
           class="pricing-grid__cta"
          >
          <?= esc_html( $label );?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>