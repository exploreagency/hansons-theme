export const addPrevNextBtnsClickHandlers = ( emblaApi, prevBtn, nextBtn ) => {
  if ( emblaApi !== null ) {
    prevBtn.addEventListener( 'click', emblaApi.scrollPrev, false );
    nextBtn.addEventListener( 'click', emblaApi.scrollNext, false );
  }
}