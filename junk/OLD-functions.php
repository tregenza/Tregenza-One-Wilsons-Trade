<?php
/**   

	Wilson's Trade Child Theme Functions

**/


/** Setup Classes / Namespace for REST API **/
//require __DIR__ . '/vendor/autoload.php';
//use Automattic\WooCommerce\Client;




/****  Wilson's Trade ******/

/**  Trade / Public Customer Roles **/

function wilsons_add_role_function() {
	$result = add_role( 'trade-verified', __(
	'Trade Customer (Verified)' ),
	array( ) );
	
	$result = add_role( 'trade-applied', __(
	'Trade Customer (Applied)' ),
	array( ) );

	$result = add_role( 'wilsons-staff', __(
	"Wilson's Trade Staff" ),
	array( ) );

	$result = add_role( 'non-trade', __(
	"Non-Trade" ),
	array( ) );
}

add_action('after_setup_theme','wilsons_add_role_function');


/**** WooCommerce ---- Add Trade Price Field ****/
/*
define("WILSONS_TRADE_PRICE_FIELD", '_wilsons_trade_price_field');
define("WILSONS_COST_PRICE_FIELD", '_wilsons_cost_price_field');
*/

/*** Enable field on Woocommerice Add / Edit Product admin page ***/
function wilsons_custom_woocommerce_fields() {
/*	 
	$description = sanitize_text_field( 'Trade Price, leave blank if no trade discount.' );
	$placeholder = sanitize_text_field( '' );
	 
	$args = array(
		'id'            => WILSONS_TRADE_PRICE_FIELD,
		'label'         => sanitize_text_field( 'Trade Price' ). ' (' . get_woocommerce_currency_symbol() . ')',
		'placeholder'   => $placeholder,
		'data_type'   		=> 'price',
		'class'			=> 'wc_input_price',
		'desc_tip'      => true,
		'description'   => $description,

		);
	woocommerce_wp_text_input( $args );
*/
/*	$description = sanitize_text_field( 'Cost Price, leave blank if no trade discount.' );
	$placeholder = sanitize_text_field( '' );
	 
	$args = array(
		'id'            => WILSONS_COST_PRICE_FIELD,
		'label'         => sanitize_text_field( 'Cost Price' ). ' (' . get_woocommerce_currency_symbol() . ')',
		'placeholder'   => $placeholder,
		'data_type'   		=> 'price',
		'class'			=> 'wc_input_price',
		'desc_tip'      => true,
		'description'   => $description,

		);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_pricing', 'wilsons_custom_woocommerce_fields' );
*/

/*** Save field on Woocommerice Add / Edit Product admin page ***/
function add_custom_woocommerce_fields_save( $post_id ) {
	 
/*
	if ( ! ( isset( $_POST['woocommerce_meta_nonce'], $_POST[ WILSONS_TRADE_PRICE_FIELD ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
		return false;
	}
	 
	$trade_price = sanitize_text_field(
		wp_unslash( $_POST[ WILSONS_TRADE_PRICE_FIELD ] )
	);
	 
	update_post_meta(
		$post_id,
		WILSONS_TRADE_PRICE_FIELD,
		esc_attr( $trade_price )
	);
*/
/*
	if ( ! ( isset( $_POST['woocommerce_meta_nonce'], $_POST[ WILSONS_COST_PRICE_FIELD ] ) || wp_verify_nonce( sanitize_key( $_POST['woocommerce_meta_nonce'] ), 'woocommerce_save_data' ) ) ) {
		return false;
	} 
	 
	$trade_price = sanitize_text_field(
		wp_unslash( $_POST[ WILSONS_COST_PRICE_FIELD ] )
	);
	 
	update_post_meta(
		$post_id,
		WILSONS_COST_PRICE_FIELD,
		esc_attr( $trade_price )
	);
*/
}
/*add_action( 'woocommerce_process_product_meta', 'add_custom_woocommerce_fields_save' ); */



/** Woocommerce - Filter Price for Trade customers **/
/*
function wilsons_check_trade_price($price, $product_id) {

	if (is_wilsons_trade_account()) {

		global $post;

		$price = "999999.99";		/* Set obviously false price incase something goes wrong */
/*
		$price = get_post_meta( $post->ID, WILSONS_TRADE_PRICE_FIELD, true );


    }
    return $price;
}
add_filter('woocommerce_get_price', 'wilsons_check_trade_price', 10, 2);
*/

/** Woocommerce - Return true is current user has a valid trade account **/
function is_wilsons_trade_account($user_id = null){

	$return = false;

	$trade_account_roles = array( 'trade-verified', 'wilsons-staff', 'administrator', 'editor', 'author' );

    if ( is_numeric( $user_id ) ) { 
        $user = get_user_by( 'id',$user_id );
    } else if (is_user_logged_in()) {
		$user = wp_get_current_user();
    }

	if ( $user ) {
		$match = array_intersect($trade_account_roles , $user->roles );
		if ( !empty($match) ) {
			$return = true;
		}
    }

    return $return;
}

/**  Register new status BASED ON http://www.sellwithwp.com/woocommerce-custom-order-status-2/  **/
/*
function register_order_statuses() {
    register_post_status( 'wc-quote', array(
        'label'                     => 'Quote',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => false,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Quotes <span class="count">(%s)</span>', 'Quotes <span class="count">(%s)</span>' )
    ) );


}
add_action( 'init', 'register_order_statuses' );
*/

/* Add to list of WC Order statuses */
/*
function add_new_order_statuses( $order_statuses ) {

    $new_order_statuses = array();
	$new_order_statuses['wc-quote'] = 'Quote';  /* Make sure it is first in the list */
/*
    // add new order status after processing
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_new_order_statuses' );
*/

/* Set Default order status */
/*
function filter_woocommerce_default_order_status( $orig_status) { 
    // make filter magic happen here... 

    return 'quote'; 
}; 
         
// add the filter 
add_filter( 'woocommerce_default_order_status', 'filter_woocommerce_default_order_status', 10, 1  );
*/


/*** --- SHORT CODES --- ***/
// Add Shortcode
/* Create quote Order */
/*function create_quote() {
	global $woocommerce;
	$current_user = wp_get_current_user();

	if (isset( $woocommerce ) ) {

		if ( isset( $woocommerce->customer ) && $current_user->user_login ==$woocommerce->customer->get_username() ) {

			$current_user_id = get_current_user_id();
			$args = array(
					'customer_id'   => $current_user_id,
					'created_via'   => "Wilson's Trade Quote",
					'status'		=> "quote"
			);
			$order = wc_create_order($args);
		
			$ship_address = array(
			      'first_name' => '',
			      'last_name'  => '',
			      'company'    => '',
			      'email'      => '',
			      'phone'      => '',
			      'address_1'  => '',
			      'address_2'  => '',
			      'city'       => '',
			      'state'      => '',
			      'postcode'   => '',
			      'country'    => 'UK'
			  );
	
		
			$billing_address = array(
			      'first_name' => $woocommerce->customer->get_billing_first_name(),
			      'last_name'  => $woocommerce->customer->get_billing_last_name(),
			      'company'    => $woocommerce->customer->get_billing_company(),
			      'email'      => $woocommerce->customer->get_billing_email(),
			      'phone'      => $woocommerce->customer->get_billing_phone(),
			      'address_1'  => $woocommerce->customer->get_billing_address_1(),
			      'address_2'  => $woocommerce->customer->get_billing_address_2(),
			      'city'       => $woocommerce->customer->get_billing_city(),
			      'state'      => $woocommerce->customer->get_billing_state(),
			      'postcode'   => $woocommerce->customer->get_billing_postcode(),
			      'country'    => $woocommerce->customer->get_billing_country
		 
			);
		
			$order->set_address( $ship_address, 'shipping' );
			$order->set_address( $billing_address, 'billing' );
		
			$customer_country = $woocommerce->customer->get_country();
		
			$order->save();

		} else {
			echo "Not Woocommerce User";
		}

	} else { 
		echo "ERROR";
	}
	
}
add_shortcode( 'createquote', 'create_quote' );
*/

/* Orders in a quote status have to be editable */
/*
function order_statuses_to_editable ($editable, $order) {
	if ( $order->get_status() == 'quote' ) {
        $editable = true;
    }

	return $editable;
}
add_filter ( 'wc_order_is_editable', 'order_statuses_to_editable', 10, 2  );
*/

/** ---- My Account Pages --- */
/*
function  account_menu_items( $items ) {
 
	$myorder = array(
		'dashboard' => __( 'Dashboard', 'woocommerce' ),
		'quotes-list' => 'Quotes',
		'orders' => __( 'Orders', 'woocommerce' ),
		'edit-account' => __( 'Login Details', 'woocommerce' ),
		'edit-address' => __( 'Business Details', 'woocommerce' ),
		'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
		'customer-logout' => __( 'Logout', 'woocommerce' ),
	);

 
    return $myorder;
 
}
add_filter( 'woocommerce_account_menu_items', 'account_menu_items', 10, 1 );
*/

/**
 * Add endpoint
 */
/*
function add_account_endpoints() {
 
    add_rewrite_endpoint( 'quotes-list', EP_ROOT | EP_PAGES );
 
}
add_action( 'init', 'add_account_endpoints' );
*/

/* Query var for end point */
/*
function add_account_query_vars( $vars ) {
    $vars[] = 'quotes-list';
    return $vars;

}
add_filter( 'query_vars', 'add_account_query_vars', 0 );
*/
/*
function add_quotes_list_content() {
	echo do_shortcode( '[my_quotes]' );
	echo do_shortcode( '[new_quote_button]');
}
add_action( 'woocommerce_account_quotes-list_endpoint', 'add_quotes_list_content' );
*/

/* Shortcode for displaying only quotes */
/*
function shortcode_my_quotes( $atts ) {
	
	/* Uses the standard orders endpoint and relies on the woocommerce_my_account_my_orders_query / my_orders_hide_quotes filtering to hide non-quotes */
/*	return do_action('woocommerce_account_orders_endpoint');

}
add_shortcode('my_quotes', 'shortcode_my_quotes'); 
*/

/* Shortcode for starting new quote */
/*
function shortcode_new_quote_button( $atts ) {

	ob_start();
	?> <a href='/trade-account/quote/'>NEW QUOTE</a> <?php
	return ob_get_clean();

}
add_shortcode('new_quote_button', 'shortcode_new_quote_button'); 
*/

/* Shortcode for quote details */
/*
function quote_details_form( $atts ) {
	
	echo "QUOTE DETAILS";

	wc_get_template('wilsonstrade/quote-form.php');

}
add_shortcode('quote_details_form', 'quote_details_form'); 
*/

/* Filter quotes in or out depending on the endpoint being displayed */
/*
function my_orders_hide_quotes($args){
//var_dump($args);

	if ( is_wc_endpoint_url('orders') ) {
		$statuses = wc_get_order_statuses();
		unset($statuses['wc-quote']);
		$args['post_status'] = array_keys($statuses);
	} else {
		global $wp_query;
		if ( isset( $wp_query->query_vars['quotes-list'] ) ){
			$args['post_status'] = array('wc-quote');
		}

	}
	return $args;

}
add_filter( 'woocommerce_my_account_my_orders_query', 'my_orders_hide_quotes' );
*/

/*** Filter Fields ***/
function custom_shipping_fields($fields) {
	$fields['shipping']['customer-phone'] = array(
		'label' => __('Customer Phone', 'woocommerce'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true
	);

	$fields['shipping']['customer-email'] = array(
		'label' => __('Customer Email', 'woocommerce'),
		'required' => false,
		'class' => array('form-row-wide'),
		'clear' => true
	);

	$first = array(
	   'customer-reference' => array(
	      'label' => __('Customer Reference', 'woocommerce'),
	      'required' => false,
	      'class' => array('form-row-wide'),
	      'clear' => true
	   )
	);

	$fields['shipping'] = $first + $fields['shipping'];
	return $fields;
}
add_filter('woocommerce_checkout_fields','custom_shipping_fields');
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true');  /* Always shipping to customer. CSS hide's checkbox */

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
		}
	}

  return $translated_text;
}
add_filter('gettext', 'custom_strings', 20, 3);

/* Test if we are on the quote page */
/*
function is_quote_page() {

	$value = false;
	if ( get_the_ID() ==  158 ) {
		$value = true;
	}

	return $value;
}
*/

/* hide coupon field on quote page */
/*
function hide_coupon_field_on_quote( $enabled ) {

	if ( is_quote_page()  ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_quote' );

*/



/*** TEST ****/

/**
* Plugin Name: KB - REST API Widget
* Author: Kirsty Burgoine
*/
 
class REST_API_Widget extends WP_Widget {
 
/**
* Sets up the widgets name etc
*/
public function __construct() {
    $widget_ops = array(
        'classname' => 'rest-api-widget',
        'description' => 'A REST API widget that pulls posts from a different website'
    );
    parent::__construct( 'rest_api_widget', 'REST API Widget', $widget_ops );
}

}








/* 
woocommerce_product_thumbnails - Action 
woocommerce_single_product_image_thumbnail_html 	filter
woocommerce_get_image_size_{$image_size} 	filter
*/

add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );



function action_woocommerce_product_thumbnails(  ) { 
    return "ACTION TEST"; 
}; 
         
// add the action 
add_action( 'woocommerce_product_thumbnails', 'action_woocommerce_product_thumbnails', 10, 0 ); 

add_action( 'wp_enqueue_scripts', 'load_scripts_3' );
function load_scripts_3() {
//	wp_enqueue_script( 'three-d-model', get_stylesheet_directory_uri() .'/build/three.min.js' );
	wp_enqueue_script( 'isomer', get_stylesheet_directory_uri() .'/dist-isomer/isomer.js' );

}

add_action( 'woocommerce_after_single_product_summary', 'threedtest', 1);
function threedtest() {

echo <<<EOD
<canvas width="500" height="500" id="art" style="border: 1px solid red;"></canvas>
<script>
var options = { scale:10 };

var iso = new Isomer(document.getElementById("art"), options);
var Shape = Isomer.Shape;
var Point = Isomer.Point;
var Color = Isomer.Color;
var Path = Isomer.Path;

var red = new Color(160, 60, 50);
var blue = new Color(50, 60, 160);
var green = new Color(60, 160, 50);
var grya = new Color(50,50,50);
var gryb = new Color(125,125,125);
var gryc = new Color(200,200,200);


/*

for ( var  lp= 0; lp< 30; lp = lp+2 ) {
	iso.add(new Path([Point(lp,0,0), Point(lp+1,0,0), Point(lp+1,30,0), Point(lp,30,0) ] )  , grya);
}
for ( var  lp= 0; lp< 30; lp = lp+2 ) {
	iso.add(new Path([Point(0, lp,0), Point(0,lp+1, 0), Point(30, lp+1 ,0), Point(30,lp,0) ] )  , gryb);
}

*/
/*
iso.add(Shape.Prism(Point.ORIGIN, 1, 1, 1), green);
iso.add(Shape.Pyramid(Point(0, 2, 1)), red);
iso.add(Shape.Prism(Point(2, 0, 1)), blue);
*/

iso.add(new Path( [ Point(0, 0, 0), Point(30, 0, 0), Point(30, 30, 0), Point(0, 30 ,0) ] ), grya );
iso.add(new Path( [ Point(0, 30, 0), Point(0, 30, 30), Point(30, 30, 30), Point(30, 30 ,0) ] ), gryb );
iso.add(new Path( [ Point(30, 30, 0), Point(30, 30, 30), Point(30, 0, 30), Point(30, 0 ,0) ] ), gryc );

iso.add(Shape.Prism(Point(15,25,0), 5, 5, 5), green);

</script>

EOD;


}

?>