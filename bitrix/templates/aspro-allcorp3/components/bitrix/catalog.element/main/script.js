$(document).ready(function(){
	setBasketItemsClasses();

	setTimeout(function () {
		function checkStickyPanelContent(){
			if(window.matchMedia('(min-width:992px)').matches){
				$title = $('.catalog-detail__sticky-panel .catalog-detail__title');
				if ($title.length) {
					$right = $('.catalog-detail__right-info');
					if($right.length){
						var bVisible = $title.hasClass('show');
						var headerFixedHeight = $('#headerfixed.fixed').length ? 112 : 32;
						
						if($right[0].getBoundingClientRect().top <= headerFixedHeight){
							if (!bVisible) {						
								$title.addClass('show');
								
								if ($title.data('timer')) { 
									clearTimeout($title.data('timer'));
									$title.data('timer', false);
								}
								
								$title.css('height', '');
								var h = $title.actual('height');
								$title.height(0);
								$title.addClass('active');
								$title.height(h);
	
								$title.data('timer', setTimeout(function () {
									$title.css('height', '');
								}, 2000));
							}
						}
						else{
							if (bVisible) {
								$title.removeClass('show');
	
								if ($title.data('timer')) { 
									clearTimeout($title.data('timer'));
									$title.data('timer', false);
								}
	
								var h = $title.actual('height');
								$title.height(h);
								$title.height(0);
								$title.data('timer', setTimeout(function () {
									$title.removeClass('active');
									$title.css('height', '');
								}, 700));
							}
						}
					}
				}
	
				setTimeout(function () { 
					var $sale = $('.catalog-detail__sticky-panel .catalog-detail__sale:not(.show)');
					if ($sale.length) {
						var h = $sale.actual('height');
						$sale.height(0);
						$sale.addClass('show');
						$sale.height(h);
						setTimeout(function () {
							$sale.css('height', '');
						}, 2000);
					}
				}, 2000);
			}
		}
		checkStickyPanelContent();
	
		$(document).resize(function(){
			checkStickyPanelContent();
		});
		
		$(document).scroll(function(){
			checkStickyPanelContent();
		});
	}, 1000);
});