BX.Aspro.Utils.readyDOM(() => {
  BX.bindDelegate(document, 'click', {class: 'accordion-grid-button'}, function(event) {
    if (
      window.matchMedia("(width < 767px)").matches
      && !event?.target?.getAttribute('href')
    ) {
      this.classList.toggle('_active');
    }
  });
});
