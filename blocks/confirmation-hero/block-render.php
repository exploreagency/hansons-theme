<?php
/**
 * Confirmation Hero Block
 */

$content = get_field( 'content' );
?>

<section <?php echo vt_block_attributes( 'confirmation-hero', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--left"
             data-orientation="column"
          >
          <?php if ( $content ) : ?>
            <div class="confirmation-hero__content js-thank-you-scheduler">
              <?= wp_kses_post( $content ); ?>

              <a href="#"
                 class="confirmation-hero__scheduler-button js-add-to-calendar"
                 download
                >
                Add To Calendar
              </a>
              <a href="#"
                 class="confirmation-hero__scheduler-button js-add-to-google-calendar"
                 target="_blank"
                 rel="noopener"
                >
                Add To Google Calendar
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>