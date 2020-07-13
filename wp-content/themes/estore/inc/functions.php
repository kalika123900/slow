<?php
/**
 * eStore functionality
 *
 * @package ThemeGrill
 * @subpackage estore
 * @since eStore 1.2.5
 */

/**
 * Header search form
 */
function estore_header_search_box() {
	$search_form = get_theme_mod( 'estore_header_search_option', 'wp_search' );
	?>
	<div class="search-wrapper search-user-block">
		<div class="search-icon">
			<i class="fa fa-search"> </i>
		</div>
		<div class="header-search-box">
			<?php
			// if WC is activated and WC Search is selected in customizer
			if ( function_exists( 'get_product_search_form' ) && $search_form === 'wc_search' ) :
				get_product_search_form();
			else :
				get_search_form();
			endif;
			?>
		</div>
	</div>
	<?php
}

/**
 * estore_product_searchform
 * Overrides default WC search form
 *
 * @since 1.2.5
 */
function estore_product_searchform( $form ) {

	$form = '<form role="search" method="get" class="estore-wc-product-search" action=" ' . esc_url( home_url( '/' ) ) . '">
		<label class="screen-reader-text" for="estore-wc-search-field">' . esc_html__( 'Search for:', 'estore' ) . '</label>
		<input type="search" id="estore-wc-search-field" class="search-field" placeholder="' . esc_attr__( 'Search products ...', 'estore' ) . '" value="' . get_search_query() . '" name="s" />
		<button type="submit" class="searchsubmit" value="' . esc_attr_x( 'Search', 'submit button', 'estore' ) . '">
			<i class="fa fa-search"></i>
		</button>
		<input type="hidden" name="post_type" value="product" />
	</form>';

	return $form;

}

add_filter( 'get_product_search_form', 'estore_product_searchform', 10, 1 );

/*
 * Related posts.
 */
if ( ! function_exists( 'estore_related_posts_function' ) ) {

	function estore_related_posts_function() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => 3,
		);

		// Related by categories.
		if ( get_theme_mod( 'estore_related_posts', 'categories' ) == 'categories' ) {
			$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args['category__in'] = $cats;
		}

		// Related by tags.
		if ( get_theme_mod( 'estore_related_posts', 'categories' ) == 'tags' ) {
			$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$args['tag__in'] = $tags;

			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query();

		return $query;
	}
}

if ( ! function_exists( 'estore_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function estore_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'estore_pingback_header' );


/**
 * Update image attributes for retina logo.
 *
 */
if ( ! function_exists( 'estore_change_logo_attr' ) ) :
	function estore_change_logo_attr( $attr, $attachment, $size ) {
		$custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

		if ( ! empty( $custom_logo ) ) {
			$custom_logo = $custom_logo[0];
		}

		if ( isset( $attr['class'] ) && 'custom-logo' === $attr['class'] ) {

			if ( 1 == get_theme_mod( 'estore_different_retina_logo', 0 ) ) {
				$retina_logo = get_theme_mod( 'estore_retina_logo_upload', '' );

				if ( $retina_logo ) {
					$attr['srcset'] = $custom_logo . ' 1x,' . $retina_logo . ' 2x';
				}
			}
		}

		return $attr;
	}
endif;

add_filter( 'wp_get_attachment_image_attributes', 'estore_change_logo_attr', 10, 3 );

/**
 * Compare user's current version of plugin.
 */
if ( ! function_exists( 'estore_plugin_version_compare' ) ) {
	function estore_plugin_version_compare( $plugin_slug, $version_to_compare ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$installed_plugins = get_plugins();

		// Plugin not installed.
		if ( ! isset( $installed_plugins[ $plugin_slug ] ) ) {
			return false;
		}

		$tdi_user_version = $installed_plugins[ $plugin_slug ]['Version'];

		return version_compare( $tdi_user_version, $version_to_compare, '<' );
	}
}
	add_action( 'init','wdm_register_shipped_order_status');

    /* Register new status*/
function wdm_register_shipped_order_status()
{
			register_post_status( 'wc-shipped', array(
			'label' => _x('Shipped','wdm'),
			'public' => true,
			'exclude_from_search' => false,
			'show_in_admin_all_list' => true,
			'show_in_admin_status_list' => true,
			'label_count' => _n_noop( 'Dispatched <span class="count">(%s)</span>', 'Dispatched <span class="count">(%s)</span>' )
		));
}
add_action( 'woocommerce_order_actions', 'wdm_add_order_meta_box_actions');
function wdm_add_order_meta_box_actions($actions)
{
   $actions['wdm_shipped'] = __( 'Dispatched', 'wdm');
   return $actions; 
}
add_filter( 'wc_order_statuses', 'add_shipped_to_order_statuses');
function add_shipped_to_order_statuses($order_statuses)
{
      $new_order_statuses = array();
      // add new order status after Completed
      foreach ( $order_statuses as $key => $status ) 
      {
         $new_order_statuses[ $key ] = $status;
         if ( 'wc-completed' === $key ) 
         {
            $new_order_statuses['wc-shipped'] = __('Dispatched','wdm');    
         }
      }
   return $new_order_statuses;
}
add_action( 'woocommerce_order_action_wdm_shipped', 'wdm_order_shipped_callback',10,1);
function wdm_order_shipped_callback($order)
{ 	
}
add_action('woocommerce_order_status_shipped','wdm_order_status_shipped_callback',10,1);
function wdm_order_status_shipped_callback($order_id)
{
   global $WC;
		
		$heading = 'Your Order #'.$order_id.' has been dispatched';
		$subject = 'Your Order #'.$order_id.' has been dispatched';
		$order = wc_get_order( $order_id );
		// Get WooCommerce email objects

		$mailer = WC()->mailer()->get_emails();
		
    $mailer['WC_Email_Customer_Completed_Order']->heading = $heading;
		$mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = $heading;
		$mailer['WC_Email_Customer_Completed_Order']->subject = $subject;
		$mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = $subject;
		$mailer['WC_Email_Customer_Completed_Order']->template_html = 'emails/customer-dispatched-order.php';
		$mailer['WC_Email_Customer_Completed_Order']->template_base = get_stylesheet_directory().'/woocommerce/templates/';
		// Send the email with custom heading & subject
		
		$mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id );
}
add_action( 'admin_footer', 'wdm_add_shipped_in_bulk_action',11);
/*
* Add "Mark as Shipped" in Bulk action dropdown
*/
function wdm_add_shipped_in_bulk_action()
{
		global $post_type;

		if ( 'shop_order' == $post_type ) {
		
		wp_register_style('wdm_shipping_icon_css_handler',plugins_url('assets/css/wdm_shipping_icon.css',__FILE__));
				wp_enqueue_style('wdm_shipping_icon_css_handler');
		
		?>
		<script type="text/javascript">
				
				jQuery(function() {
				
						jQuery('<option>').val('mark_shipped').text('<?php _e( 'Mark shipped', 'woocommerce' )?>').appendTo("select[name='action']");
						jQuery('<option>').val('mark_shipped').text('<?php _e( 'Mark shipped', 'woocommerce' )?>').appendTo("select[name='action2']");
						
				//Add icon
				
				title_text = jQuery('.column-order_status .shipped').html()
				jQuery('.column-order_status .shipped').attr('alt',title_text);
				jQuery('.column-order_status .shipped').empty();
				jQuery('.column-order_status .shipped').append('<icon class="icon-local-shipping"></icon>')
				jQuery('.column-order_status .shipped').css('text-indent','0');

				});
		</script>
		
		<?php
		}
	}
	add_action( 'woocommerce_order_status_Dispatched', 'bbloomer_status_custom_notification', 20, 2 );
 
function bbloomer_status_custom_notification( $order_id, $order ) {
     
  
		}
	

?>