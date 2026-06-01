<?php
/**
 * LP Header Block
 */

$company_logo = get_field( 'company_logo' );
$phone        = get_field( 'phone_number' );
$phone_mob    = get_field( 'phone_mobile_text' );
$cta          = get_field( 'cta' );
?>

<header <?php echo vt_block_attributes( 'lp-header', $block ); ?>>
  <div class="lp-header__wrapper">
    <div class="container--fluid">
      <div class="lp-header__inner">
        <img src="<?= esc_url( wp_get_attachment_image_src( $company_logo, 'full' )[0] ); ?>"
             alt="<?= esc_attr( get_post_meta( $company_logo, '_wp_attachment_image_alt', TRUE ) ); ?>"
             class=""
          />

        <div class="lp-header__cta-buttons">
          <?php if ( $phone_number ) :
            
            ?>
            <a href=""
               aria-label=""
               class="lp-header__cta__phone--mobile"
              >

            </a>
            <a href=""
               aria-label=""
               class="lp-header__cta__phone--desktop"
              >

            </a>
          <?php endif; ?>

          <?php if ( $cta ) :
            
            ?>
            <a href=""
               aria-label=""
               class="lp-header__cta__form"
              >

            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>