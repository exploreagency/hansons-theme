<?php
/**
 * LP Footer Block
 */

$sticky_cta  = get_field( 'sticky_cta' );
$copyright   = get_field( 'copyright' );
$legal_links = get_field( 'legal_links' );
?>

<?php if ( $sticky_cta ) :
  $url = $sticky_cta['url'];
  $label = $sticky_cta['title'];
  ?>
  <div class="sticky-cta__wrapper">
    <a href="<?= esc_url( $url ); ?>"
      class="sticky-cta__link"
      >
      <?= esc_html( $label ); ?>
    </a> 
  </div>
<?php endif; ?>

<footer <?php echo vt_block_attributes( 'lp-footer', $block ); ?>>
  <div class="container">
    <div class="section__wrapper">
      <?php if ( $copyright ) : ?>
        <p class="lp-footer__copyright">
          <?= $copyright; ?>
        </p>
      <?php endif; ?>

      <?php if ( $legal_links ) : ?>
        <div class="lp-footer__legal-links">
          <?php foreach ( $legal_links as $legal_link ) :
            $url = $legal_link['legal_link']['url'];
            $label = $legal_link['legal_link']['title'];
            ?>
            <a href="<?= esc_url( $url ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="<?= esc_html( $label ); ?>"
               class="lp-footer__legal-link"
              >
              <?= esc_html( $label ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</footer>