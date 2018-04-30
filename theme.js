/** JAVASCRIPT for the Tregenza-one Wilson's Trade child theme **/

	/** Doucment READY - Automaticly run */ 
	jQuery( document ).ready(function() {



		/** Monitor WooCommerce Ajax functions for cleaning **/
		jQuery( document ).ajaxComplete(function( event, xhr, settings ) {

			/* Clean junk whitepace output by woocommerce */
			jQuery(".component_table_item_indent").each(function() {

				jQuery(this).html(jQuery(this).html().replace(/&nbsp;/g, ''));
			} );

		} );

	} );

