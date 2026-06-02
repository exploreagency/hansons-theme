<?php
/**
 * Problem Definition Block
 */

$heading       = get_field( 'heading' );
$description   = get_field( 'description' );
$problems_list = get_field( 'problems_list' );
$footnote      = get_field( 'footnote' );
?>

<section <?php echo vt_block_attributes( 'problem-definition', $block ); ?>>
  <div class="section">
    <div class="container">
      <div class="section__wrapper">
        <?php if ( $heading ) : ?>
          <h2 class="problem-definition__heading">
            <?= wp_kses_post( $heading ); ?>
          </h2>
        <?php endif; ?>

        <?php if ( $description ) : ?>
          <div class="problem-definition__description">
            <?= wp_kses_post( $description ); ?>
          </div>  
        <?php endif; ?>

        <?php if ( $problems_list ) : ?>
          <div class="problem-definition__problems-grid">
            <?php foreach ( $problems_list as $problem ) :
              $image = $problem['image'];
              $description = $problem['description'];
              ?>
              <div class="problem-definition__problem">
                <img src="<?= esc_url( wp_get_attachment_image_src( $image, 'full' )[0] ); ?>"
                    alt="<?= esc_attr( get_post_meta( $image, '_wp_attachment_image_alt', TRUE ) ); ?>"
                    loading="lazy"
                    class="problem-definition__problem__image"
                  />
                <p class="problem-definition__problem__description">
                  <?= wp_kses_post( $description ); ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ( $footnote ) : ?>
          <div class="problem-definition__footnote">
            <?= wp_kses_post( $footnote ); ?>
          </div>  
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>