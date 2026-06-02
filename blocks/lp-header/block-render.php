<?php
/**
 * LP Header Block
 */

$company_logo   = get_field( 'company_logo' );
$phone_number   = get_field( 'phone_number' );
$phone_mob_text = get_field( 'phone_mobile_text' );
$cta            = get_field( 'cta' );
?>

<header <?php echo vt_block_attributes( 'lp-header', $block ); ?>>
  <div class="lp-header__wrapper">
    <div class="container--fluid">
      <div class="lp-header__inner">
        <img src="<?= esc_url( wp_get_attachment_image_src( $company_logo, 'full' )[0] ); ?>"
             alt="<?= esc_attr( get_post_meta( $company_logo, '_wp_attachment_image_alt', TRUE ) ); ?>"
             class="lp-header__logo"
          />

        <div class="lp-header__cta-buttons">
          <?php if ( $phone_number ) :
            $url = $phone_number['url'];
            $label = $phone_number['title'];
            ?>
            <a href="<?= esc_url( $url ); ?>"
               aria-label="<?= wp_kses_post( $phone_mob_text ); ?>"
               class="lp-header__cta__phone--mobile"
              >
              <?= wp_kses_post( $phone_mob_text ); ?>
            </a>
            <a href="<?= esc_url( $url ); ?>"
               aria-label="<?= wp_kses_post( $phone_mob_text ); ?>"
               class="lp-header__cta__phone--desktop"
              >
              <?= esc_html( $label ); ?>
            </a>
          <?php endif; ?>

          <?php if ( $cta ) :
            $url = $cta['url'];
            $label = $cta['title'];
            ?>
            <a href="<?= esc_url( $url ); ?>"
               aria-label="<?= esc_html( $label ); ?>"
               class="lp-header__cta__form"
              >
              <?= esc_html( $label ); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>