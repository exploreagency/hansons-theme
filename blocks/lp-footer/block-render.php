<?php
/**
 * LP Footer Block
 */

$sticky_cta  = get_field( 'sticky_cta' );
$copyright   = get_field( 'copyright' );
$legal_links = get_field( 'legal_links' );
?>

<footer <?php echo vt_block_attributes( 'lp-footer', $block ); ?>>
  <?php if ( $sticky_cta ) :
    
    ?>
    <a href=""
       class="lp-footer__sticky-cta"
      >

    </a> 
  <?php endif; ?>

  <div class="container">

  </div>
</footer>