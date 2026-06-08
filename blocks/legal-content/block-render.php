<?php
/**
 * Legal Content
 */

$heading = get_field( 'heading' );
$content = get_field( 'content' );
?>

<section <?php echo vt_block_attributes( 'legal-content', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <div class="section__heading section__heading--left"
             data-orientation="column"
          >
          <?php if ( $heading ) : ?>
            <h1 class="legal-content__heading">
              <?= wp_kses_post( $heading ); ?>
            </h1>
          <?php endif; ?>
        </div>

        <?php if ( $content ) : ?>
          <div class="legal-content__content">
            <?= wp_kses_post( $content ); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>