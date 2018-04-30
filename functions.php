<?php
/**   

	Wilson's Trade Child Theme Functions

**/




/****  Wilson's Trade ******/


/********** START - Woocommerce / Wordpress - Config **********/


	/* ---------- Load standard Javascript ----------- */
	function load_scripts_child() {
		wp_enqueue_script( 'themeJS', get_stylesheet_directory_uri() . '/theme.js');	
	}
	add_action( 'wp_enqueue_scripts', 'load_scripts_child' );

	/* Remove unwanted woocommerce wishlist style sheets */
	function wt_dequeue_styles(  ) {
		wp_dequeue_style('woocommerce-wishlists');	// wishlist
		return ;
	}
	add_filter( 'wp_enqueue_scripts', 'wt_dequeue_styles',100 );
	

	/**  Trade / Public Customer Roles **/
	function wilsons_add_role_function() {
		$result = add_role( 'trade-applied', __(
		'Trade Customer (Applied)' ),
		array( ) );
	
		$result = add_role( 'wilsons-staff', __(
			"Wilson's Trade Staff" ), array());
		/* Add capabilities (Easier to add/ammend capabilities this way */
	    $role = get_role( 'wilsons-staff' );
	    $role->add_cap( 'read' );
	    $role->add_cap( 'create_posts' );
	    $role->add_cap( 'edit_posts' );
	    $role->add_cap( 'edit_others_posts' );
	    $role->add_cap( 'publish_posts' );
	    $role->add_cap( 'edit_pages' );
	    $role->add_cap( 'edit_others_pages' );
	    $role->add_cap( 'edit_published_pages' );
	    $role->add_cap( 'publish_pages' );
	    $role->add_cap( 'moderate_comments' );
	    $role->add_cap( 'delete_others_pages' );
	    $role->add_cap( 'delete_others_posts' );
	    $role->add_cap( 'edit_published_posts' );
	    $role->add_cap( 'delete_published_posts' );
	    $role->add_cap( 'delete_posts' );
	    $role->add_cap( 'create_users' );
	    $role->add_cap( 'upload_files' );
	    $role->add_cap( 'promote_users' );
	    $role->add_cap( 'delete_users' );
	    $role->add_cap( 'list_users' );
	    $role->add_cap( 'promote_users' );
	    $role->add_cap( 'edit_users' );
	    $role->add_cap( 'manage_network_users' );		/* This is needed in a multi-site environment to allow user editing */
	
		/** Woocommerce specific capabilties */
	    $role->add_cap( 'view_woocommerce_reports');
	    $role->add_cap( 'manage_woocommerce_orders');
	    $role->add_cap( 'manage_woocommerce_coupons');
	    $role->add_cap( 'manage_woocommerce_products');
		$role->add_cap( 'manage_woocommerce_taxonomies' );
		$role->add_cap('edit_product');
		$role->add_cap('read_product');
		$role->add_cap('delete_product');
		$role->add_cap('edit_products');
		$role->add_cap('edit_others_products');
		$role->add_cap('publish_products');
		$role->add_cap('read_private_products');
		$role->add_cap('delete_products');
		$role->add_cap('delete_private_products');
		$role->add_cap('delete_published_products');
		$role->add_cap('delete_others_products');
		$role->add_cap('edit_private_products');
		$role->add_cap('edit_published_products');
		$role->add_cap('manage_product_terms');
		$role->add_cap('edit_product_terms');
		$role->add_cap('delete_product_terms');
		$role->add_cap('assign_product_terms');
		$role->add_cap('edit_shop_order');
		$role->add_cap('read_shop_order');
		$role->add_cap('delete_shop_order');
		$role->add_cap('edit_shop_orders');
		$role->add_cap('edit_others_shop_orders');
		$role->add_cap('publish_shop_orders');
		$role->add_cap('read_private_shop_orders');
		$role->add_cap('delete_shop_orders');
		$role->add_cap('delete_private_shop_orders');
		$role->add_cap('delete_published_shop_orders');
		$role->add_cap('delete_others_shop_orders');
		$role->add_cap('edit_private_shop_orders');
		$role->add_cap('edit_published_shop_orders');
		$role->add_cap('manage_shop_order_terms');
		$role->add_cap('edit_shop_order_terms');
		$role->add_cap('delete_shop_order_terms');
		$role->add_cap('assign_shop_order_terms');
		$role->add_cap('edit_shop_coupon');
		$role->add_cap('read_shop_coupon');
		$role->add_cap('delete_shop_coupon');
		$role->add_cap('edit_shop_coupons');
		$role->add_cap('edit_others_shop_coupons');
		$role->add_cap('publish_shop_coupons');
		$role->add_cap('read_private_shop_coupons');
		$role->add_cap('delete_shop_coupons');
		$role->add_cap('delete_private_shop_coupons');
		$role->add_cap('delete_published_shop_coupons');
		$role->add_cap('delete_others_shop_coupons');
		$role->add_cap('edit_private_shop_coupons');
		$role->add_cap('edit_published_shop_coupons');
		$role->add_cap('manage_shop_coupon_terms');
		$role->add_cap('edit_shop_coupon_terms');
		$role->add_cap('delete_shop_coupon_terms');
		$role->add_cap('assign_shop_coupon_terms');
		$role->add_cap('edit_shop_webhook');
		$role->add_cap('read_shop_webhook');
		$role->add_cap('delete_shop_webhook');
		$role->add_cap('edit_shop_webhooks');
		$role->add_cap('edit_others_shop_webhooks');
		$role->add_cap('publish_shop_webhooks');
		$role->add_cap('read_private_shop_webhooks');
		$role->add_cap('delete_shop_webhooks');
		$role->add_cap('delete_private_shop_webhooks');
		$role->add_cap('delete_published_shop_webhooks');
		$role->add_cap('delete_others_shop_webhooks');
		$role->add_cap('edit_private_shop_webhooks');
		$role->add_cap('edit_published_shop_webhooks');
		$role->add_cap('manage_shop_webhook_terms');
		$role->add_cap('edit_shop_webhook_terms');
		$role->add_cap('delete_shop_webhook_terms');
		$role->add_cap('assign_shop_webhook_terms');

/*
JUNK DEVELOPMENT CODE
    $MY_other_role = get_role("shop_manager");
	foreach($MY_other_role->capabilities as $key=>$value) { 
		echo '$role->add_cap('."'".$key."');"."<br/>";
	}
die;
	$role->remove_cap( 'manage_woocommerce');
END JUNK DEVELOPMENT CODE
*/

		$result = add_role( 'non-trade', __(
		"Non-Trade" ),
		array( ) );
	}
	add_action('after_setup_theme','wilsons_add_role_function');


	/* Only show customer related roles on wp-admin user-edit page */ 	
	function filterRoles($all_roles) {
		$user = wp_get_current_user();
		$new_roles = array();
		if ( $user->roles[0] == 'wilsons-staff') {
			$new_roles['trade-applied'] = $all_roles['trade-applied'];
			$new_roles['customer'] = $all_roles['customer'];
		} else {
			$new_roles = $all_roles;
		}
		return $new_roles;

	}
	add_filter('editable_roles', 'filterRoles');


	/* Get rid of unwanted wp-admin menu items for certain roles */
	function removeUnwantedAdmin() {
		if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {
			remove_menu_page( 'jetpack' );
		}
	    remove_menu_page( 'wpcf7' ); 
	    remove_menu_page( 'tools.php' ); 
	}
	add_action( 'admin_init', 'removeUnwantedAdmin' );


	/* Load and initaite custom Woocmmerce functions */
	function includeWoocommerceMods() {
	    require( get_stylesheet_directory() . '/includes/woocommerceFunctions.php' );
	}
	add_action( 'init', 'includeWoocommerceMods' );


	/* Remove Addresses option from my account */
	function custom_my_account_menu_items( $items ) {
	    unset($items['edit-address']);
	    unset($items['downloads']);
	    return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );

	/* Update admin pages body tag with user role */
	function add_admin_body_class_role( $classes ) {
		$user_info = wp_get_current_user();
		$newclass= "";
		if (isset($user_info) ){
			$newclass = $user_info->roles[0];
		}
		return "$classes $newclass";
	}
	add_filter( 'admin_body_class', 'add_admin_body_class_role' );

	/* Update body tag with user role */
	function add_body_class_role( $classes ) {
		$user_info = wp_get_current_user();
		if (isset($user_info) ){
			$classes[] = $user_info->roles[0];
		} 

		return $classes;
	}
	add_filter( 'body_class', 'add_body_class_role' );


	/* Remove standard my-account page nav */
	function tregenzaOneNavMods() {
		remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
	}
	add_action( 'init', 'tregenzaOneNavMods' );

	/* Add my-account nav or login / register to page nav  */
	function myAccountNav() {

		if (is_user_logged_in()  ) {

			do_action( 'woocommerce_before_account_navigation' );
	?>
			<nav class="blockCollapse woocommerce-MyAccount-navigation">
				<p class="blockCollapseHeader">My Account</p>
				<div class="blockCollapseContent">
					<ul class="menu">
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
							<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?> navOne-fg navThree-bg navTwo-hover menu-item">
								<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</nav>
	<?php		
			do_action( 'woocommerce_after_account_navigation' ); 

		} else {
			echo '<div class="blockCollapse">';
			echo '<p class="blockCollapseHeader">Login</p>';
			echo '<div class="blockCollapseContent">';
			echo do_shortcode('[content_block slug=trade-login]');
			echo '</div>';
			echo '</div>';

		}

	}
	add_action('tregenzaOneCollapsibleHeaderContent', 'myAccountNav',20);


	/** Deactive network active plugins which are unnneeded **/
	function deactivate_plugin_conditional() {
	    $deactivated_plugin_name = 'smpl-shortcodes/smpl-shortcodes.php';  /** loads CSS which causes problems **/
//	    deactivate_plugins($deactivated_plugin_name, false, true);
	}
	add_action( 'init', 'deactivate_plugin_conditional' );


/********** END - Wordpress Roles / Capabilties - Config **********/



/********** START - Woocommerce / Wordpress - Config **********/
	// Update CSS within in Admin
	function admin_style() {
		wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/style-admin.css');
	}
	add_action('admin_enqueue_scripts', 'admin_style');


	/**
	 * Change text strings
	 */
	function my_text_strings( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
			case 'Option subtotal' :
				$translated_text = __( 'Subtotal', 'woocommerce' );
				break;
		}
		return $translated_text;
	}
	add_filter( 'gettext', 'my_text_strings', 20, 3 );
	

	/**
	*	Only show specific category on main shop page 
	**/
//	function shop_filter_cat($query) {
		/** Only filter on the main shop page not category specific pages etc **/
//		if (! is_admin() && $query->is_main_query() && is_shop() && !is_product_category() && !is_product_tag() ) {

			/* Parent Category */
//			$filterCat ='wt-options';	/* Slug */
//			$filterCats = getSubCats($filterCat);

//			$tax_query = (array) $query->get( 'tax_query' );

//			$tax_query[] = array ('taxonomy' => 'product_cat',
//					'field' => 'slug',
//					'terms' => $filterCats,
//					'operator' => 'NOT IN' 		);   
//
//		    $query->set( 'tax_query', $tax_query );
//		}
		

//	}
//	add_action('pre_get_posts','shop_filter_cat');


	/**
	*	Only show specific category on main shop page 
	**/
	function get_subcategory_terms( $terms, $taxonomies, $args ) {

		// if a product category and on the shop page
		if ( !is_admin() && is_shop() && in_array( 'product_cat', $taxonomies )  ) {
		
			$new_terms = array();
		
			foreach ( $terms as $key => $term ) {
				if ( $term->slug != "wt-options" ) {
					$new_terms[] = $term;
				}
			
			}
			return $new_terms;
	
		}

		return $terms;	

	}
	add_filter( 'get_terms', 'get_subcategory_terms', 10, 3 );



	/**
	*		Recursive Build list of subcategories 
	**/
	function getSubCats( $catSlug ) {
		$retArray = array($catSlug);

		$terms = get_term_by('slug', $catSlug, 'product_cat');
	    $args = array(
		       'hierarchical' => 1,
		       'show_option_none' => '',
		       'hide_empty' => 0,
		       'parent' => $terms->term_id,
		       'taxonomy' => 'product_cat'
		    );
  		$subCats = get_categories($args);

		foreach($subCats as $sc) {
			$subArray = getSubCats($sc->slug);
			$retArray = array_merge($retArray, $subArray);
		}		
		
		return $retArray;

	}



	/**
	*		Filter search to products only 
	**/
	function searchfilter($query) {
	 
	    if ($query->is_search && !is_admin() ) {
	        $query->set('post_type',array('product'));
	    }
	 
	return $query;
	}
	 
	add_filter('pre_get_posts','searchfilter');
	


	/**
	*		Add SKU to product searches 
	**/
	/* Join posts and postmeta tables */
	function product_search_join( $join, $query ) {
	    if ( !  is_search()  ) {
	        return $join;
	    }
	 
	    global $wpdb;
	 
	    $join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";
	    return $join;
	}
	add_filter( 'posts_join', 'product_search_join', 10, 2 );
	
	/* Modify the search query with posts_where. */
	function product_search_where( $where, $query ) {

	    if ( ! is_search() ) {
	        return $where;
	    }
	    global $wpdb;
	 
	    $where = preg_replace(
	        "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
	        "({$wpdb->posts}.post_title LIKE $1) OR (iconic_post_meta.meta_key = '_sku' AND iconic_post_meta.meta_value LIKE $1)", $where );
	    return $where;
	}
	add_filter( 'posts_where', 'product_search_where', 10, 2 );

	/**
	 * Adds 'DISTINCT' to the query that's executing on the search page to stop duplicates.
	 */
	function product_search_distinct( $distinct ) {
	  
		if ( is_admin() || ! is_search() ) {
			return $distinct;
		}
		
		return 'DISTINCT';
	}
	add_filter( 'posts_distinct', 'product_search_distinct' );

	/* DEBUGGING ONLY - Modify the search query with posts_where. */
	function product_search_sql( $request, $query ) {

		echo $request;

	    return $request;
	}
	// add_filter( 'posts_request', 'product_search_sql', 10, 2 );


/********** END - Woocommerce / Wordpress - Config **********/


/********** START - Woocommerce / Wordpress - Helper Functions **********/

	/** Woocommerce - Return true is current user has a valid trade account **/
	function is_wilsons_trade_account($user_id = null){
	
		$return = false;
	
		$trade_account_roles = array( 'customer', 'wilsons-staff', 'administrator', 'editor', 'author' );
	
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

	/** Generate Descriptive Title for Composite Product **/
	function get_composite_summary($cart_item) {
	
		$desc = "";
	
		if ( wc_cp_is_composite_container_cart_item( $cart_item ) ) {
			foreach ($cart_item['composite_data'] as $subProduct) {
				$id = $subProduct['product_id'];
				$product = wc_get_product( $id );
				$desc .= '<span class="wc_composite_details_cart_summary">'.$product->get_title().'</span>';
	
			}
	
	
		}
	
		return $desc;
	
	}


/********** END - Woocommerce / Wordpress - Helper Functions **********/

/********** Start - Delivery Date Calculator Shortcode **********/

	function addWorkingDays($startDate,$holidays,$wDays) {

	    // using + weekdays excludes weekends
	    $new_date = date('Y-m-d', strtotime("{$startDate} +{$wDays} weekdays"));

		/* Check Holdiays */
		foreach ($holidays as $holiday) {
		    $holiday_ts = strtotime($holiday);
		
		    // if holiday falls between start date and new date, then account for it
		    if ($holiday_ts >= strtotime($startDate) && $holiday_ts <= strtotime($new_date)) {
		
		        // check if the holiday falls on a working day
		        $h = date('w', $holiday_ts);
		            if ($h != 0 && $h != 6 ) {
		            // holiday falls on a working day, add an extra working day
		            $new_date = date('Y-m-d', strtotime("{$new_date} + 1 weekdays"));
		        }
		    }
		}

	    return $new_date;
	}

	function nextDeliveryDate($atts) {

		$workingAtts = shortcode_atts( array(
			'startdate' => null,
			'days' => 5,
		), $atts );
	
		$holidays = getDeliveryHolidays();

		if ( ! isset($workingAtts['startdate']) ) {
				
			$ctime = date('G');
			$dow = date('w');
			$plusDays = 0;

			switch ($dow) {
				case 0:  /* Sunday */
					$plusDays+=1;
					break;
				case 6:  /* Saturday*/
					$plusDays+=2;
					break;
				default: 
					break;
			}

			if ( $plusDays == 0 && $ctime > 16 ) {
				/* Later than 4pm and we are not already shifting the start date */			/* XXXXXX NEEDS WORK FOR BST / GMT SHIFTS XXXXXXXXX */
				$plusDays++;
			}

			$today = date('Y-m-d');
			$workingAtts['startdate'] = date("Y-m-d", strtotime($today." +".$plusDays." days"));

		}
		$delDate = 	addWorkingDays($workingAtts['startdate'], $holidays, $workingAtts['days']);

		$dateString = date('l jS F Y', strtotime($delDate));
	
		return '<span class="deliveryDate">'.$dateString."</span>";	

	}
	/*** Returns dates of publich holidays - Will need updating occasionally ***/
	function getDeliveryHolidays() {

			/** Standard Public Holidays
				New Years Day
				Good Friday
				Easter Monday
				May Day
				Late May
				August
				Christmas 
				Boxing Day ***/

		$holidays = array(
			'2017-12-25',
			'2017-12-26',
			'2018-01-01',
			'2018-03-30',
			'2018-04-02',
			'2018-05-07',
			'2018-05-28',
			'2018-08-27',
			'2018-12-25',
			'2018-12-26',
			'2019-01-01',
			'2019-04-19',
			'2019-04-22',
			'2019-05-06',
			'2019-05-27',
			'2019-08-26',
			'2019-12-25',
			'2019-12-26',
			'2020-01-01'
		);
		return $holidays;

	}
	add_shortcode('deliverydate', 'nextDeliveryDate' );


/********** Start - Woocommerce Checkout **********/

	function tandcmessage() {

		echo do_shortcode( '[content_block slug=checkout-terms-conditions]' );

	}

	add_action('woocommerce_after_checkout_form', 'tandcmessage', 50);

/********** End - Woocommerce Checkout **********/








// define the woocommerce_single_product_image_thumbnail_html callback 
/*function filter_woocommerce_single_product_image_thumbnail_html( $sprintf, $post_id ) { 
    // make filter magic happen here... 
	if ( is_composite_product() ) {
		$svg = get_field("svg_template");
//		echo $svg;
		$fileloc = locate_template("art/".$svg);
//		echo $fileloc;
		$return = "<div class='svgProduct'>";
		$return .= file_get_contents($fileloc);
		$return .= "</div>";

		return $return;
		
	}
    return $sprintf; 
}*/
//add_filter( 'woocommerce_single_product_image_thumbnail_html', 'filter_woocommerce_single_product_image_thumbnail_html', 10, 2 );


/* Add classes to Woocommerce Composite Forms so its handled in css like other parts of the product page */
function tregenza_one_composite_form_classes($classArray) {
	$classArray[] = 'tregenza_one_wc_product_block';
	$classArray[] = 'tregenza_one_composite_form';

	return $classArray;
}
add_filter( 'woocommerce_composite_form_classes', 'tregenza_one_composite_form_classes');


/* WOOCOMMERCE / GRAVITY FORMS */
function gravityFormsPopulate($form) {
// echo "FIRE XXX";

	/* Check name of form matches so we only attempt to popululate forms needed for woocommmerce */
	if ( isset($form) && isset($form["title"] ) ) {	
		$key = substr($form["title"], 0,10);
		$ref = substr($name, 11);
	} else {
		return $form;
	}
 
	foreach($form['fields'] as &$field) {

		if ( isset($field['adminLabel'] ) ) {
			$type = substr($field['adminLabel'], 0,4);
			$criteria = substr($field['adminLabel'], 4);
			$args = array('limit' => -1);

//echo "XX TYPE XX ".$type;
//echo "XX Criteria XX ".$criteria;
			$choices = null;
			switch (strtolower($type)) {
				case "cat-":
					$choices = getWCProductsByCat($criteria, $field);
					break;
				case "att-":
					$choices = getWCAttributes($criteria, $field);
					break;
/*
				case "pro-":
					$choices = getMatchingProducts($form['fields']);
					break;
*/
			}
			
/*			if ( $valid ) {

*/
//echo "XXX<p>";
//var_dump($field['choices']);
//echo "XXX</p>";

			if ( isset($choices) && ! empty($choices ) ) {
		        $field['choices'] = $choices; 
			}

		}
	}
	return $form;
}
add_filter('gform_pre_render', 'gravityFormsPopulate', 10,1);
//Note: when changing drop down values, we also need to use the gform_pre_validation so that the new values are available when validating the field.
add_filter( 'gform_pre_validation', 'gravityFormsPopulate', 10, 1);
//Note: when changing drop down values, we also need to use the gform_admin_pre_render so that the right values are displayed when editing the entry.
add_filter( 'gform_admin_pre_render', 'gravityFormsPopulate', 10,1 );
//Note: this will allow for the labels to be used during the submission process in case values are enabled
add_filter( 'gform_pre_submission_filter', 'gravityFormsPopulate', 10,1 );

/* Get Woocommmerce Attributes for Gravity Form */
function getWCAttributes($slug, $field) {


$attribute_taxonomies = wc_get_attribute_taxonomies();
	$terms = get_terms( "pa_".$slug, array(
	    'hide_empty' => false,
	) );
/* var_dump($terms); */
	$choices = array();
	foreach( $terms as $term ) {
		$choice = array();
		$choice['text'] = $term -> name;
		$choice['value'] = $term -> slug;

/* var_dump($choice); */
		$choices[] = $choice;
	}

	return $choices;
}

/* Get Woocommerce Products from category */
function getWCProductsByCat($catSlug, $field) {
	$args = array('limit' => -1,
					'orderby' => 'name',
				    'order' => 'ASC',
					);
	$args['category'] = array(  'taxonomy' => 'product_cat',
								'field' => 'slug',	
								'terms' => $catSlug,
								'operator' => 'IN'
								 );
	$products = wc_get_products($args);
	$choices = array();
	foreach ($products as $product) {
		$details = array();
		$details['text'] = $product->get_name();
		$details['value'] = $product->get_sku();
		if ( $field["enablePrice"] ) {
			$details['price'] = $product->get_price();
		}
		$choices[] = $details;
	}
//var_dump($choices);
	return $choices;
}


/* Find a matching product based on attribute fields */
function getMatchingProducts($fields) {

	$choices = array();

	$taxArgs = array('relation' => 'AND');
	foreach ($fields as $field) { 
		$type = substr($field['adminLabel'], 0,4);
		$criteria = substr($field['adminLabel'], 4);
		$fieldValue = "";
		if ( $type = "att-" ) {
			/* Product Attribute */
			$tax = 	    array(
	        'taxonomy'      => 'pa_' . $criteria,
	        'terms'         => $fieldValue,
	        'field'         => 'slug',
	        'operator'      => 'IN'
	        );
		}
		$taxArgs[] = $tax;
	}

	$args = array(
	    'post_type' => 'product',
	    'tax_query' => $taxArgs
	);
//var_dump($args);
	$products = query_posts($args);

//	var_dump($products);

}


function testfilter($arga, $argb, $arbc, $arbd, $arge, $argf) {
echo "<p>";
	var_dump($arga);
	var_dump($argb);
	var_dump($argc);
	var_dump($argd);
	var_dump($arge);
	var_dump($argf);
echo "</p>";
echo "<p>-----</p>";
return $arga;
}
//add_filter('woocommerce_composited_product_dropdown_title', 'testfilter', 10 , 6 );
