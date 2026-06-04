<?php
/**
 * Page Hero Block
 */

$heading          = get_field( 'heading' );
$offer            = get_field( 'offer' );
$offer_disclosure = get_field( 'offer_disclosure' );
$form_shortcode   = get_field( 'form_shortcode' );
$image            = get_field( 'image' );
?>

<section <?php echo vt_block_attributes( 'page-hero', $block ); ?>>
  <?php if ( $image ) : ?>
    <div class="page-hero__image__wrapper">
      <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
           alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
           loading="eager"
           fetchpriority="high"
           class="page-hero__image"
        />
    </div>
  <?php endif; ?>

  <div class="page-hero__content"
       id="contact"
    >
    <?php if ( $heading ) : ?>
      <h1 class="page-hero__content__heading">
        <?= wp_kses_post( $heading ); ?>
      </h1>  
    <?php endif; ?>

    <?php if ( $offer ) : ?>
      <div class="page-hero__content__offer"
           x-data="disclosureModal"
        >
        <div class="page-hero__content__offer__text">
          <?= wp_kses_post( $offer ); ?>
        </div>

        <?php if ( $offer_disclosure ) : ?>
          <div class="page-hero__content__disclosure-modal"
               x-show="isOpen"
               x-cloak
               @keydown.escape.window="closeModal"
            >
            <div class="page-hero__content__disclosure-modal__overlay" @click="closeModal"></div>

            <div class="page-hero__content__disclosure-modal__panel"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="disclosure-modal-title"
                 x-ref="modalPanel"
              >
              <button type="button"
                      class="page-hero__content__disclosure-modal__close"
                      aria-label="Close disclosure modal"
                      @click="closeModal"
                >
                &times;
              </button>

              <div class="page-hero__content__disclosure-modal__content">
                <?= wp_kses_post( $offer_disclosure ); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>  
    <?php endif; ?>

    <?php if ( $form_shortcode ) : ?>
      <div class="page-hero__content__form"
           x-data="schedulerFormModal"
        >
        <?= do_shortcode( $form_shortcode ); ?>
      </div>  
    <?php endif; ?>
  </div>
</section>