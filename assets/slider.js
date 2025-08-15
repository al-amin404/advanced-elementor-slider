jQuery( document ).ready( function ( $ ) {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/advanced_elementor_slider.default', function ( $element ) {
		elementorFrontend.elementsHandler.addHandler( SliderHandler, { $element } );
	} );

	const SliderHandler = elementorModules.frontend.handlers.Base.extend( {
		updateSliderWidgetContent: function () {
			let settings = {
				direction: 'horizontal',
				slidesPerView: this.getElementSettings( 'slide_per_view' ),
				spaceBetween: 30,
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			};
			if(this.getElementSettings( 'autoplay' ) == 'yes') {
				settings.autoplay = {
					delay: 1200,
					disableOnInteraction: false,
				}
			}
			const swiper = new Swiper( this.$element.find( '.swiper' )[ 0 ], settings);
		},
		onInit: function () {
			this.updateSliderWidgetContent();
		},
		onElementChange: function ( e ) {
			if(e == 'slide_per_view' || e == 'autoplay') {
				this.updateSliderWidgetContent();
			}
		}
	} );
	
} );