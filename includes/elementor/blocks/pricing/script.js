(function ($) {
	const BlocksMonsterPricing = {
		/**
		 * Init
		 */
		init: function () {
			$( document ).on( 'click', '.bm-pricing__toggle-btn' , this.togglePricing );
		},

		/**
		 * Toggle Pricing
		 */
		togglePricing: function () {
			const self   = this
			const parent = $( self ).closest( '.bm-pricing' );
			const index  = $( self ).index();

			parent.removeClass( 'bm-pricing__active-0 bm-pricing__active-1 bm-pricing__active-2 bm-pricing__active-3 bm-pricing__active-4 bm-pricing__active-5' );

			parent.addClass( 'bm-pricing__active-' + index );
		}
	};

	/**
	 * Initialization
	 */
	$(
		function () {
			BlocksMonsterPricing.init();
		}
	);

})( jQuery );
