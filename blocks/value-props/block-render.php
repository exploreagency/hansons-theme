<?php
/**
 * Value Props Block
 */

$heading          = get_field( 'heading' );
$value_props_list = get_field( 'value_props_list' );
$image            = get_field( 'image' );
?>

<section <?php echo vt_block_attributes( 'value-props', $block ); ?>>
  <div class="container">
    <div class="section__wrapper">
      <?php if ( $heading ) : ?>
        <h2 class="value-props__heading">
          <?= wp_kses_post( $heading ); ?>
        </h2>
      <?php endif; ?>

      <div class="value-props__grid">
        <?php if ( $value_props_list ) : ?>
          <div class="value-props__grid__content">
            <?php foreach ( $value_props_list as $value_prop ) :
              $icon = $value_prop['icon'];
              $heading = $value_prop['heading'];
              $description = $value_prop['description'];
              ?>
              <div class="value-props__grid__value-prop">
                <img src="<?= esc_url( wp_get_attachment_image_src( $icon, 'full' )[0] ); ?>"
                     alt="<?= esc_attr( get_post_meta( $icon, '_wp_attachment_image_alt', TRUE ) ); ?>"
                     loading="lazy"
                     class="value-props__grid__value-prop__icon"
                  />
                <div class="value-props__grid__value-prop__content">
                  <h3 class="value-props__grid__value-prop__heading">
                    <?= wp_kses_post( $heading ); ?>
                  </h3>
                  <p class="value-props__grid__value-prop__description">
                    <?= wp_kses_post( $description ); ?>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ( $image ) : ?>
          <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
               alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
               loading="lazy"
               class="value-props__grid__image"
            />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>