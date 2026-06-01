export const addThumbBtnsClickHandlers = ( emblaApi, emblaApiThumb ) => {
  const slidesThumbs = emblaApiThumb.slideNodes();

  const scrollToIndex = slidesThumbs.map(
    ( _, index ) => () => emblaApi.scrollTo( index )
  )

  slidesThumbs.forEach( ( slideNode, index ) => {
    slideNode.addEventListener( 'click', scrollToIndex[index], false );
  })

  return () => {
    slidesThumbs.forEach( ( slideNode, index ) => {
      slideNode.removeEventListener( 'click', scrollToIndex[index], false );
    })
  }
}

export const addToggleThumbBtnsActive = ( emblaApi, emblaApiThumb ) => {
  const slidesThumbs = emblaApiThumb.slideNodes();

  const toggleThumbBtnsState = () => {
    emblaApiThumb.scrollTo( emblaApi.selectedScrollSnap() );

    const previous = emblaApi.previousScrollSnap();
    const selected = emblaApi.selectedScrollSnap();

    slidesThumbs[previous].removeAttribute( 'data-selected' );
    slidesThumbs[selected].setAttribute( 'data-selected', '' );
  }

  emblaApi.on( 'select', toggleThumbBtnsState );
  emblaApiThumb.on( 'init', toggleThumbBtnsState );

  return () => {
    const selected = emblaApi.selectedScrollSnap();

    slidesThumbs[selected].setAttribute( 'data-selected', '' );
  }
}