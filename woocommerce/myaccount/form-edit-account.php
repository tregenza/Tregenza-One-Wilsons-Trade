<?php
/****  
*
*				MODIFIED VERSION OF WOOCOMMERCE TEMPLATE TO INCLUDE CUSTOM FIELDS AND APPLY BETTER HTML STRUCTURE FOR CSS
*		
*
*****/



/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<fieldset>
		<legend><?php _e( 'Contact Details', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" required />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
			<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>"  required />
		</p>
		<div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-first">
			<label for="billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>"  required />
		</p>
		<div class="clear"></div>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>"  required />
		</p>
	</fieldset>

	<fieldset>
		<legend><?php _e( 'Address', 'woocommerce' ); ?></legend>

		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_company"><?php _e( 'Company Name', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_company" id="billing_company" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_company', true )); ?>"  required />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_address_1"><?php _e( 'Billing Address 1', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1" id="billing_address_1" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_address_1', true )); ?>" required  />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_address_2"><?php _e( 'Billing Address 2', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_2" id="billing_address_2" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_address_2', true )); ?>"  required />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_city"><?php _e( 'Billing City', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_city" id="billing_city" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_city', true )); ?>"  required />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_state"><?php _e( 'Billing County', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_state" id="billing_state" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_state', true )); ?>"  required />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-first">
			<label for="billing_postcode"><?php _e( 'Billing Postcode', 'theme_domain_slug' ); ?> <span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_postcode" id="billing_postcode" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_postcode', true )); ?>"  required />
		</p>

	</fieldset>

	<fieldset>
		<legend><?php _e( 'Additional', 'woocommerce' ); ?></legend>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="user_url"><?php _e( 'Website', 'theme_domain_slug' ); ?> <span class="required"></span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="user_url" id="user_url" placeholder="" value="<?php echo esc_attr( $user->user_url ); ?>" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-wide">
			<label for="billing_vat_num"><?php _e( 'VAT Number', 'theme_domain_slug' ); ?> <span class="required"></span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_vat_num" id="billing_vat_num" placeholder="" value="<?php echo esc_attr(get_user_meta( $user->ID, 'billing_vat_num', true )); ?>" />
		</p>
	</fieldset>

	<fieldset>
		<legend><?php _e( 'Password change', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current"><?php _e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1"><?php _e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2"><?php _e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
