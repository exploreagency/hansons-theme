import EmblaCarousel from "embla-carousel";

import { addPrevNextBtnsClickHandlers } from "./EmblaCarouselPrevNextButton";
import { addDotBtnsClickHandlers } from "./EmblaCarouselDotButton";
import {
  addThumbBtnsClickHandlers,
  addToggleThumbBtnsActive
} from "./EmblaCarouselThumbButton";

document.addEventListener( 'DOMContentLoaded', () => {
  document.querySelectorAll( '[data-embla]' ).forEach( ( emblaNode ) => {
    try {
      const emblaThumbsNode = emblaNode.querySelector( '[data-embla-thumbs]' );
      let emblaThumbsOptions = {};
      let emblaThumbsViewport = null;

      const emblaOptions = emblaNode.dataset.options ?
        JSON.parse( emblaNode.dataset.options ) :
        {};

      if ( emblaThumbsNode && emblaThumbsNode.dataset.thumbsOptions ) {
        emblaThumbsOptions = JSON.parse( emblaThumbsNode.dataset.thumbsOptions );
        emblaThumbsViewport = emblaThumbsNode.querySelector( '.embla-thumbs__viewport' );
      }

      const emblaViewport = emblaNode.querySelector( '.embla__viewport' );
      const emblaPrevBtnNode = emblaNode.querySelector( '.embla__button--prev' );
      const emblaNextBtnNode = emblaNode.querySelector( '.embla__button--next' );
      const emblaDotsNode = emblaNode.querySelector( '.embla__dots' );

      const emblaApi = EmblaCarousel( emblaViewport, emblaOptions );

      const emblaThumbsApi = emblaThumbsNode !== null ?
        EmblaCarousel( emblaThumbsViewport, emblaThumbsOptions ) :
        null;

      const emblaRemovePrevNextBtnsClickHandlers = ( emblaPrevBtnNode !== null && emblaNextBtnNode !== null ) ?
        addPrevNextBtnsClickHandlers( emblaApi, emblaPrevBtnNode, emblaNextBtnNode ) :
        null;
      const emblaRemoveDotBtnsClickHandlers = emblaDotsNode !== null ?
        addDotBtnsClickHandlers( emblaApi, emblaDotsNode ) :
        null;
      const emblaRemoveThumbBtnsClickHandlers = emblaThumbsViewport !== null ?
        addThumbBtnsClickHandlers( emblaApi, emblaThumbsApi ) :
        null;
      const emblaRemoveToggleThumbBtnsActive = emblaThumbsViewport !== null ?
        addToggleThumbBtnsActive( emblaApi, emblaThumbsApi ) :
        null;

      if ( emblaApi !== null ) {
        if ( emblaNextBtnNode !== null && emblaPrevBtnNode !== null ) emblaApi.on( 'destroy', emblaRemovePrevNextBtnsClickHandlers );
        if ( emblaDotsNode !== null ) emblaApi.on( 'destroy', emblaRemoveDotBtnsClickHandlers );

        if ( emblaThumbsNode !== null ) {
          emblaApi.on( 'destroy', emblaRemoveThumbBtnsClickHandlers );
          emblaApi.on( 'destroy', emblaRemoveToggleThumbBtnsActive );
        }        
      }

      if ( emblaThumbsApi !== null ) {
        if ( emblaThumbsNode !== null ) {
          emblaThumbsApi.on( 'destroy', emblaRemoveThumbBtnsClickHandlers );
          emblaThumbsApi.on( 'destroy', emblaRemoveToggleThumbBtnsActive );
        }
      }
    } catch ( error ) {
      console.error( 'Error parsing options for carousel: ', emblaNode, error );
    }
  });
});