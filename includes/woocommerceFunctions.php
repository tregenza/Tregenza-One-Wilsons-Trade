<?php
/**
*
*	Custom WooCommerce functionality loaded via functions.php. 
*
*/

/********** START - General Config **********/

	
	/* Change Terminology */
	function custom_strings( $translated_text, $text, $domain ) {
	
		if ($domain === "woocommerce" ) {
			switch ( $translated_text ) {
				case 'Deliver to a different address?' : 
					$translated_text =  "Customer Details"; 
					break;
				case 'Checkout' : 
					$translated_text =  "Place Order"; 
					break;
				case 'Length' : 
					$translated_text =  "Depth"; 
					break;
				case 'Please enter a valid postcode / ZIP.' : 
					$translated_text =  "Please enter a valid <strong>Postcode</strong>."; 
					break;
			}
		}
	
	  return $translated_text;
	}
	add_filter('gettext', 'custom_strings', 20, 3);
		
		
	/* Disable prices on dropdowns */
	function wt_composite_dropdown_price_true() {
		return true;
	}
	add_filter( 'woocommerce_composite_component_option_prices_hide', 'wt_composite_dropdown_price_true' );
	
	/* Disable price range on composite */
	add_filter( 'woocommerce_composite_force_old_style_price_html', '__return_true' );
	
	/* Hide related products on product page */
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	
	
	/** Replace 'customer' role (WooCommerce use by default) with your own one. **/
	function wc_assign_custom_role($args) {
		$args['role'] = 'trade-applied';
		return $args;
	}
	add_filter('woocommerce_new_customer_data', 'wc_assign_custom_role', 10, 1);

	/* Set Default country code - Only applies to checkout pages */
	function change_default_checkout_country() {
	  return 'UK'; // country code
	}
	add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );


 
	/* Hide add to basket button if not logged in */
	/* NOTE: 	The Tregenza-One functions theme rewrites the sequence / priorty of various WC functions. This function needs to 
				be fired after it an take into account its changes 
	*/
	function hide_not_logged_in() { 
		if ( !is_user_logged_in() ) {       
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); 

		}
	}
	add_action('init', 'hide_not_logged_in', 30); 

	/* Hide Prices */	 
	function not_logged_in_get_price_html( $price, $product ){
		$return = "";
		if ( !is_user_logged_in() ) {       
			if ( is_product() ) {
				/* Display link to registration page */
				$return = '<span  class="priceHidden"><a href="' . get_permalink(659) . '">Register</a> or <a href="'. get_permalink(wc_get_page_id('myaccount')) .'">Login</a> to view prices.</span>';
			} else {
				$return = '<span  class="priceHidden">Register or Login to view prices.</span>';
			}
		} else {
			if ( is_wilsons_trade_account() ) {
				$return = $price;
			} else {
				$return = '<span  class="priceHidden">Trade Account Pending</span>';
			}
		}
		return $return;
	}
	add_filter( 'woocommerce_get_price_html', 'not_logged_in_get_price_html', 100, 2 );

/********** END- General Config **********/


/****


	NOTE:  A lot of this PHP file relates to adding fields to billing and shiiping address. 
	Unfortunently woocommerce does make this easy and there is different code / hooks / filters for all the different ways
	woocommerce us them. 

	*Standard WooCommerce Billing Fields*
    billing_first_name
    billing_last_name
    billing_company
    billing_address_1
    billing_address_2
    billing_city
    billing_postcode
    billing_country
    billing_state
    billing_email
    billing_phone

	*Wilsons Trade Additional Billing Fields *
	billing_website
	billing_vat_numistration

	*Wilsons Trade Changes *
	Make all standard fields mandorty except billing_country
	Hide/remove billing_country (or set to UK)   (done via CSS on some forms)


****/



/********** START - Registration Fields / Forms **********/

/** 
	Woocommerce doesn't provide any convient hooks / functions to manage the registration form other than a couple in form-login.php so html and 
	code for validation of the extra fields needs to be done manually.
	The validation is very basic (an is it there check only) but data will be validated properly when the user places an order. 

*/

/**
* Add new fields to WooCommerce registration pages.
*/
function wooc_extra_register_fields() {
?>



	<fieldset>
		<p class="form-row form-row-first">
			<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" required/>
		</p>

		<p class="form-row form-row-last">
			<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="tel" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>"  required/>
		</p>

	</fieldset>

		
	<fieldset>
		<p class="form-row form-row-wide">
			<label for="reg_billing_company"><?php _e( 'Company', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_company" id="reg_billing_company" value="<?php if ( ! empty( $_POST['billing_company'] ) ) esc_attr_e( $_POST['billing_company'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_address_1"><?php _e( 'Address1', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" value="<?php if ( ! empty( $_POST['billing_address_1'] ) ) esc_attr_e( $_POST['billing_address_1'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_address_2"><?php _e( 'Address2', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_address_2" id="reg_billing_address_2" value="<?php if ( ! empty( $_POST['billing_address_2'] ) ) esc_attr_e( $_POST['billing_address_2'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_city"><?php _e( 'Town / City', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_state"><?php _e( 'County', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_state" id="reg_billing_state" value="<?php if ( ! empty( $_POST['billing_state'] ) ) esc_attr_e( $_POST['billing_state'] ); ?>" required/>
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_billing_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?><span class="required">*</span></label>
			<input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php if ( ! empty( $_POST['billing_postcode'] ) ) esc_attr_e( $_POST['billing_postcode'] ); ?>" required/>
		</p>
	</fieldset>


	<fieldset>
		<p class="form-row form-row-wide">
			<label for="user_url"><?php _e( 'Website', 'woocommerce' ); ?><span class="required"></span></label>
			<input type="url" class="input-text" name="user_url" id="user_url" value="<?php if ( ! empty( $_POST['user_url'] ) ) esc_attr_e( $_POST['user_url'] ); ?>" />
		</p>

		<p class="form-row form-row-wide">
			<label for="reg_vat_num"><?php _e( 'Vat Registration', 'woocommerce' ); ?><span class="required"></span></label>
			<input type="text" class="input-text" name="billing_vat_num" id="reg_billing_vat_num" value="<?php if ( ! empty( $_POST['billing_vat_num'] ) ) esc_attr_e( $_POST['billing_vat_num'] ); ?>" />
		</p>
	</fieldset>

<?php 
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );


/**
* Validate the extra register fields.
*/
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {

       if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
              $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
       }

       if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
              $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
       }

       if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
              $validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Phone is required!.', 'woocommerce' ) );
       }

       if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {
              $validation_errors->add( 'billing_company_error', __( '<strong>Error</strong>: A company or trading name is required!.', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
              $validation_errors->add( 'billing_address_1_error', __( '<strong>Error</strong>: Address line 1 is required.', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_address_2'] ) && empty( $_POST['billing_address_2'] ) ) {
              $validation_errors->add( 'billing_address_2_error', __( '<strong>Error</strong>: Address line 2 is required.', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
              $validation_errors->add( 'billing_city_error', __( '<strong>Error</strong>: City is required.', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_state'] ) && empty( $_POST['billing_state'] ) ) {
              $validation_errors->add( 'billing_state_error', __( '<strong>Error</strong>: County is required.', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
              $validation_errors->add( 'billing_postcode_error', __( '<strong>Error</strong>: Postcode is required.', 'woocommerce' ) );
       }


}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

/**
* Save the extra register fields.
*/
function wooc_save_custom_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		
		// WordPress default first name field.
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		
		// WooCommerce billing first name.
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	
	}
	
	if ( isset( $_POST['billing_last_name'] ) ) {
	
		// WordPress default last name field.
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		
		// WooCommerce billing last name.
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	
	}
	
	if ( isset( $_POST['billing_phone'] ) ) {
	// WooCommerce billing phone
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}

	if ( isset( $_POST['billing_company'] ) ) {
	// WooCommerce billing company
		update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
	}
	if ( isset( $_POST['billing_address_1'] ) ) {
	// WooCommerce billing add1
		update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
	}
	if ( isset( $_POST['billing_address_2'] ) ) {
	// WooCommerce billing add2
		update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
	}
	if ( isset( $_POST['billing_city'] ) ) {
	// WooCommerce billing city
		update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
	}
	if ( isset( $_POST['billing_state'] ) ) {
	// WooCommerce billing county
		update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );
	}
	if ( isset( $_POST['billing_postcode'] ) ) {
	// WooCommerce billing postcode
		update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
	}
	
	if ( isset( $_POST['user_url'] ) ) {
		// WORDPRESS Url
		wooc_update_user_url($customer_id);
	}
	if ( isset( $_POST['billing_vat_num'] ) ) {
	// WooCommerce billing vat
		update_user_meta( $customer_id, 'billing_vat_num', sanitize_text_field( $_POST['billing_vat_num'] ) );		
	}
}
add_action( 'woocommerce_created_customer', 'wooc_save_custom_fields', 20, 1 );

/* Special function needed to save URL because its part of the wordpress user and not just metadata */
function wooc_update_user_url($id) {
	$url = esc_url_raw( $_POST['user_url'] );

	if (isset($url) && !empty($url)) {
		$protocols = implode( '|', array_map( 'preg_quote', wp_allowed_protocols() ) );
		$url = preg_match('/^(' . $protocols . '):/is', $url) ? $url : 'http://'.$url;
	
		/* User wp_update_user because update_user_meta doesn't work for unknopwn reasons */
		$user = wp_get_current_user();
	} else {
		$url = "";
	}
	$user_id = wp_update_user( array( 'ID' => $id, 'user_url' => $url ) );



}






/********** END - Registration Fields / Forms **********/


/********** START - Woocommerce My-Account/Trade Account Account Details Extra Fields **********/
/*** 
*		The user account / trade account form are handled by the template form-edit-account.php which is
*		overridden om the Wilson's Trade theme to include extra fields on the output. 
*
*		Validation is limited to checking fields are completed. Additional validation could be 
*		added on the user_profile_update_errors or woocommerce_save_account_details_errors actions.
*
*
***/


	/* Filter the list of required fields to add those we added on the form - form-edit-account.php  */
	function myAccountRequiredFields( $fields ) {
		$fields['billing_company'] = __( 'Company name', 'woocommerce' );
		$fields['billing_address_1'] = __( 'Address Line 1', 'woocommerce' );
		$fields['billing_address_2'] = __( 'Address Line 2', 'woocommerce' );
		$fields['billing_city'] = __( 'City', 'woocommerce' );
		$fields['billing_state'] = __( 'County', 'woocommerce' );
		$fields['billing_postcode'] = __( 'Postcode', 'woocommerce' );
		$fields['billing_phone'] = __( 'Phone', 'woocommerce' );
		return $fields;		
	}
	add_filter('woocommerce_save_account_details_required_fields', 'myAccountRequiredFields');

	/*** When saving account details, call the same function used for customer registration */
	add_action( 'woocommerce_save_account_details', 'wooc_save_custom_fields', 20);




/********** END- Registration Fields / Forms **********/

/********** START - User-Edit Add Woocommerce Fields **********/
/* 
	The default code in WC-Admin-Profile.php only adds address fields to users with 'manage-woocommerce' capabilities.
	This code replaces those code and shows it for anyone with the ability to view / edit users and adds
	custom fields for Wilson's Trade.

	Because of the way woocommerce classes are loaded it is easier to define our own version and then the
	standard woocommerce WC_Admin_Profile class will not be created. See class-wc-admin-profile.php

	Also add Wilson's Trade specific customer account fields
*/


	/**
	 * WC_Admin_Profile Class.
	 */
	class WC_Admin_Profile {
	
		/**
		 * Hook in tabs.
		 */
		public function __construct() {
			add_action( 'show_user_profile', array( $this, 'add_customer_meta_fields' ) );
			add_action( 'edit_user_profile', array( $this, 'add_customer_meta_fields' ) );
	
			add_action( 'personal_options_update', array( $this, 'save_customer_meta_fields' ) );
			add_action( 'edit_user_profile_update', array( $this, 'save_customer_meta_fields' ) );

		}
	
		/**
		 * Get Address Fields for the edit user pages.
		 *
		 * @return array Fields to display which are filtered through woocommerce_customer_meta_fields before being returned
		 */
		public function get_customer_meta_fields() {
			$show_fields = apply_filters('woocommerce_customer_meta_fields', array(
				'billing' => array(
					'title' => __( 'Customer billing address', 'woocommerce' ),
					'fields' => array(

/* START - Always use WP account fields for name  */
						'billing_first_name' => array(
							'label'       => __( 'First name', 'woocommerce' ),
							'description' => '',
						),
						'billing_last_name' => array(
							'label'       => __( 'Last name', 'woocommerce' ),
							'description' => '',
						),
/* END */

						'billing_company' => array(
							'label'       => __( 'Company', 'woocommerce' ),
							'description' => '',
						),
						'billing_address_1' => array(
							'label'       => __( 'Address line 1', 'woocommerce' ),
							'description' => '',
						),
						'billing_address_2' => array(
							'label'       => __( 'Address line 2', 'woocommerce' ),
							'description' => '',
						),
						'billing_city' => array(
							'label'       => __( 'City', 'woocommerce' ),
							'description' => '',
						),
/* START - Change Order of Fields OLD SEQUENCE*/
/*
						'billing_postcode' => array(
							'label'       => __( 'Postcode / ZIP', 'woocommerce' ),
							'description' => '',
						),
						'billing_country' => array(
							'label'       => __( 'Country', 'woocommerce' ),
							'description' => '',
							'class'       => 'js_field-country',
							'type'        => 'select',
							'options'     => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_allowed_countries(),
						),
*/
/* END */
						'billing_state' => array(
							'label'       => __( 'State / County', 'woocommerce' ),
							'description' => __( 'State / County or state code', 'woocommerce' ),
							'class'       => 'js_field-state',
						),
/* START - Change Order of Fields NEW SEQUENCE */

						'billing_postcode' => array(
							'label'       => __( 'Postcode / ZIP', 'woocommerce' ),
							'description' => '',
						),
	/*					'billing_country' => array(
							'label'       => __( 'Country', 'woocommerce' ),
							'description' => '',
							'class'       => 'js_field-country',
							'type'        => 'select',
							'options'     => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_allowed_countries(),
						),
	*/
/* END */
						'billing_phone' => array(
							'label'       => __( 'Phone', 'woocommerce' ),
							'description' => '',
						),
/* START - Always use WP account field for email  */
/*
						'billing_email' => array(
							'label'       => __( 'Email address', 'woocommerce' ),
							'description' => '',
						),
*/
/* END */
/* START - Add VAT Field  */
						'billing_vat_num' => array(
							'label'       => __( 'VAT Number', 'woocommerce' ),
							'description' => '',
						),
					),
				),
				'shipping' => array(
					'title' => __( 'Customer shipping address', 'woocommerce' ),
					'fields' => array(
						'copy_billing' => array(
							'label'       => __( 'Copy from billing address', 'woocommerce' ),
							'description' => '',
							'class'       => 'js_copy-billing',
							'type'        => 'button',
							'text'        => __( 'Copy', 'woocommerce' ),
						),
						'shipping_first_name' => array(
							'label'       => __( 'First name', 'woocommerce' ),
							'description' => '',
						),
						'shipping_last_name' => array(
							'label'       => __( 'Last name', 'woocommerce' ),
							'description' => '',
						),
						'shipping_company' => array(
							'label'       => __( 'Company', 'woocommerce' ),
							'description' => '',
						),
						'shipping_address_1' => array(
							'label'       => __( 'Address line 1', 'woocommerce' ),
							'description' => '',
						),
						'shipping_address_2' => array(
							'label'       => __( 'Address line 2', 'woocommerce' ),
							'description' => '',
						),
						'shipping_city' => array(
							'label'       => __( 'City', 'woocommerce' ),
							'description' => '',
						),
						'shipping_postcode' => array(
							'label'       => __( 'Postcode / ZIP', 'woocommerce' ),
							'description' => '',
						),
						'shipping_country' => array(
							'label'       => __( 'Country', 'woocommerce' ),
							'description' => '',
							'class'       => 'js_field-country',
							'type'        => 'select',
							'options'     => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_allowed_countries(),
						),
						'shipping_state' => array(
							'label'       => __( 'State / County', 'woocommerce' ),
							'description' => __( 'State / County or state code', 'woocommerce' ),
							'class'       => 'js_field-state',
						),
					),
				),
			) );
			return $show_fields;
		}
	
		/**
		 * Show Address Fields on edit user pages.
		 *
		 * @param WP_User $user
		 */
		public function add_customer_meta_fields( $user ) {

/*** START
			THIS CODE IS UNWANTED IN Wilson's Trade 
***/
			/* 
			if ( ! current_user_can( 'manage_woocommerce' ) ) {
				return;
			}
			*/
/*** END ***/	
			$show_fields = $this->get_customer_meta_fields();

/*** START
			Only show billing addresses on customer details. Shipping should only be on the order
**/		
			if ( ! current_user_can( 'manage_woocommerce' ) ) {
				unset ($show_fields['shipping']);
			}
/*** END ***/	

			foreach ( $show_fields as $fieldset_key => $fieldset ) :
				?>
				<h2><?php echo $fieldset['title']; ?></h2>
				<table class="form-table" id="<?php echo esc_attr( 'fieldset-' . $fieldset_key ); ?>">
					<?php
					foreach ( $fieldset['fields'] as $key => $field ) :
						?>
						<tr>
							<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( ! empty( $field['type'] ) && 'select' === $field['type'] ) : ?>
									<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>" style="width: 25em;">
										<?php
											$selected = esc_attr( get_user_meta( $user->ID, $key, true ) );
											foreach ( $field['options'] as $option_key => $option_value ) : ?>
											<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected, $option_key, true ); ?>><?php echo esc_attr( $option_value ); ?></option>
										<?php endforeach; ?>
									</select>
								<?php elseif ( ! empty( $field['type'] ) && 'checkbox' === $field['type'] ) : ?>
									<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="1" class="<?php echo esc_attr( $field['class'] ); ?>" <?php checked( (int) get_user_meta( $user->ID, $key, true ), 1, true ); ?> />
								<?php elseif ( ! empty( $field['type'] ) && 'button' === $field['type'] ) : ?>
									<button id="<?php echo esc_attr( $key ); ?>" class="button <?php echo esc_attr( $field['class'] ); ?>"><?php echo esc_html( $field['text'] ); ?></button>
								<?php else : ?>
									<input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $this->get_user_meta( $user->ID, $key ) ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? esc_attr( $field['class'] ) : 'regular-text' ); ?>" />
								<?php endif; ?>
								<br/>
								<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
							</td>
						</tr>
						<?php
					endforeach;
					?>
				</table>
				<?php
			endforeach;
		}
	
		/**
		 * Save Address Fields on edit user pages.
		 *
		 * @param int $user_id User ID of the user being saved
		 */
		public function save_customer_meta_fields( $user_id ) {
			$save_fields = $this->get_customer_meta_fields();
	
			foreach ( $save_fields as $fieldset ) {
	
				foreach ( $fieldset['fields'] as $key => $field ) {
	
					if ( isset( $field['type'] ) && 'checkbox' === $field['type'] ) {
						update_user_meta( $user_id, $key, isset( $_POST[ $key ] ) );
					} elseif ( isset( $_POST[ $key ] ) ) {
						update_user_meta( $user_id, $key, wc_clean( $_POST[ $key ] ) );
					}
				}
			}
		}
	
		/**
		 * Get user meta for a given key, with fallbacks to core user info for pre-existing fields.
		 *
		 * @since 3.1.0
		 * @param int    $user_id User ID of the user being edited
		 * @param string $key     Key for user meta field
		 * @return string
		 */
		protected function get_user_meta( $user_id, $key ) {
			$value = get_user_meta( $user_id, $key, true );
			$existing_fields = array( 'billing_first_name', 'billing_last_name' );
			if ( ! $value && in_array( $key, $existing_fields ) ) {
				$value = get_user_meta( $user_id, str_replace( 'billing_', '', $key ), true );
			} elseif ( ! $value && ( 'billing_email' === $key ) ) {
				$user = get_userdata( $user_id );
				$value = $user->user_email;
			}
	
			return $value;
		}
	}
	


/********** END - User-Edit Add Woocommerce Fields **********/




/********** START - Checkout / Shipping fields & Forms **********/

/**
*
*		It is relatively easy to ammend / add fields on the checkout forms for billing & shipping addresses. It
*		also haddles validation.
*
*
*/

	

	/*** Customer Shipping  ***/
	function custom_checkout_fields($fields) {

		/* Dump unwanted placeholder text */
		unset($fields['shipping']['shipping_address_1']['placeholder']);
		unset($fields['shipping']['shipping_address_2']['placeholder']);
		unset($fields['order']['order_comments']['placeholder']);


		/* Dump unwanted fields */
		unset($fields['shipping']['shipping_company']);

		/* Tweak Fields */		
		$fields['billing']['billing_address_2']['label']='Address';
		$fields['billing']['billing_address_2']['required']=TRUE;
		$fields['billing']['billing_state']['required']=TRUE;
		$fields['billing']['billing_company']['required']=TRUE;
		$fields['shipping']['shipping_address_2']['label']='Address';
		$fields['shipping']['shipping_address_2']['required']=TRUE;
		$fields['shipping']['shipping_state']['required']=TRUE;

	
		$first = array(
		   'customer-reference' => array(
		      'label' => __('Customer Reference', 'woocommerce'),
		      'required' => false,
		      'class' => array('form-row-wide'),
		      'clear' => true
		   )
		);

		$second = array(
			'customer-phone' => array(
			'label' => __('Customer Phone', 'woocommerce'),
			'required' => false,
			'class' => array('form-row-wide'),
			'clear' => true
		) );


		$third = array(
			'customer-email' => array(
			'label' => __('Customer Email', 'woocommerce'),
			'required' => false,
			'class' => array('form-row-wide'),
			'clear' => true
		) );

		$fields['shipping'] = $first + $second + $third + $fields['shipping'];
		return $fields;
	}
	add_filter('woocommerce_checkout_fields','custom_checkout_fields');
	add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true');  /* Always shipping to different addess. CSS hide's checkbox */ 

/********** END - Checkout / Shipping fields & Forms **********/



