<?php
/**
 * Booster for WooCommerce - Module - Checkout Custom Fields
 *
 * @version 4.7.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WCJ_Checkout_Custom_Fields' ) ) :

class WCJ_Checkout_Custom_Fields extends WCJ_Module {

	/**
	 * Constructor.
	 *
	 * @version 4.5.0
	 * @todo    (maybe) check if `'wcj_checkout_custom_field_customer_meta_fields_' . $i` option should affect `add_default_checkout_custom_fields`
	 */
	function __construct() {

		$this->id         = 'checkout_custom_fields';
		$this->short_desc = __( 'Checkout Custom Fields', 'woocommerce-jetpack' );
		$this->desc       = __( 'Add custom fields to the checkout page.', 'woocommerce-jetpack' );
		$this->link_slug  = 'woocommerce-checkout-custom-fields';
		parent::__construct();

		if ( $this->is_enabled() ) {
			add_filter( 'woocommerce_checkout_fields',                         array( $this, 'add_custom_checkout_fields' ), PHP_INT_MAX );
			add_filter( 'woocommerce_admin_billing_fields',                    array( $this, 'add_custom_billing_fields_to_admin_order_display' ), PHP_INT_MAX );
			add_filter( 'woocommerce_admin_shipping_fields',                   array( $this, 'add_custom_shipping_fields_to_admin_order_display' ), PHP_INT_MAX );
			add_action( 'woocommerce_admin_order_data_after_shipping_address', array( $this, 'add_custom_order_and_account_fields_to_admin_order_display' ), PHP_INT_MAX );
			if ( 'yes' === get_option( 'wcj_checkout_custom_fields_add_to_order_received', 'yes' ) ) {
				add_action( 'woocommerce_order_details_after_order_table',     array( $this, 'add_custom_fields_to_view_order_and_thankyou_pages' ), PHP_INT_MAX );
			}
			add_action( 'woocommerce_email_after_order_table',                 array( $this, 'add_custom_fields_to_emails' ), PHP_INT_MAX, 2 );
			add_filter( 'woo_ce_order_fields',                                 array( $this, 'add_custom_fields_to_store_exporter' ) );
			add_filter( 'woo_ce_order',                                        array( $this, 'add_custom_fields_to_store_exporter_order' ), PHP_INT_MAX, 2 );
			add_action( 'woocommerce_checkout_update_order_meta',              array( $this, 'update_custom_checkout_fields_order_meta' ) );
			add_filter( 'woocommerce_form_field_' . 'text',                    array( $this, 'woocommerce_form_field_type_number' ), PHP_INT_MAX, 4 );
			add_filter( 'woocommerce_customer_meta_fields',                    array( $this, 'add_checkout_custom_fields_customer_meta_fields' ) );
			for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
				if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {
					$the_section = get_option( 'wcj_checkout_custom_field_section_' . $i );
					$the_key     = 'wcj_checkout_field_' . $i;
					$the_name    = $the_section . '_' . $the_key;
					add_filter( 'default_checkout_' . $the_name,               array( $this, 'add_default_checkout_custom_fields' ), PHP_INT_MAX, 2 );
				}
			}
			// select2 script
			add_action( 'wp_enqueue_scripts',                                  array( $this, 'maybe_enqueue_scripts' ) );

			// Update checkout fields from admin edit order
			add_action( 'save_post_shop_order',                                array( $this, 'update_custom_checkout_fields_order_meta' ) );
		}
	}

	/**
	 * maybe_enqueue_scripts.
	 *
	 * @version 3.6.0
	 * @since   3.2.0
	 */
	function maybe_enqueue_scripts( $fields ) {
		if ( is_checkout() ) {
			$select2_fields = array();
			for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
				if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i, 'no' ) ) {
					if ( 'select' === get_option( 'wcj_checkout_custom_field_type_' . $i, 'text' ) ) {
						if ( 'yes' === get_option( 'wcj_checkout_custom_field_select_select2_' . $i, 'no' ) ) {
							$select2_fields[] = array(
								'field_id'           => get_option( 'wcj_checkout_custom_field_section_' . $i, 'billing' ) . '_' . 'wcj_checkout_field_' . $i,
								'minimumInputLength' => get_option( 'wcj_checkout_custom_field_select_select2_min_input_length' . $i, 0 ),
								'maximumInputLength' => get_option( 'wcj_checkout_custom_field_select_select2_max_input_length' . $i, 0 ),
							);
						}
					}
				}
			}
			if ( ! empty( $select2_fields ) ) {
				wp_enqueue_script(
					'wcj-checkout-custom-fields',
					wcj_plugin_url() . '/includes/js/wcj-checkout-custom-fields.js',
					array( 'jquery' ),
					WCJ()->version,
					true
				);
				wp_localize_script(
					'wcj-checkout-custom-fields',
					'wcj_checkout_custom_fields',
					array(
						'select2_fields' => $select2_fields,
					)
				);
			}
		}
	}

	/**
	 * add_checkout_custom_fields_customer_meta_fields.
	 *
	 * @version 3.2.4
	 * @since   2.4.5
	 */
	function add_checkout_custom_fields_customer_meta_fields( $fields ) {
		for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
			if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {
				if ( 'no' === get_option( 'wcj_checkout_custom_field_customer_meta_fields_' . $i, 'yes' ) ) {
					continue;
				}
				$the_section = get_option( 'wcj_checkout_custom_field_section_' . $i );
				$the_key     = 'wcj_checkout_field_' . $i;
				$the_name    = $the_section . '_' . $the_key;
				$fields[ $the_section ]['fields'][ $the_name ] = array(
					'label'       => get_option( 'wcj_checkout_custom_field_label_' . $i ),
					'description' => '',
				);
			}
		}
		return $fields;
	}

	/**
	 * add_default_checkout_custom_fields.
	 *
	 * @version 2.4.5
	 * @since   2.4.5
	 */
	function add_default_checkout_custom_fields( $default_value, $field_key ) {
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			if ( $meta = get_user_meta( $current_user->ID, $field_key, true ) ) {
				return $meta;
			}
		}
		return $default_value;
	}

	/**
	 * woocommerce_form_field_type_number.
	 *
	 * @version 2.3.0
	 * @since   2.3.0
	 */
	function woocommerce_form_field_type_number( $field, $key, $args, $value ) {
		if ( isset( $args['custom_attributes']['display'] ) && 'number' === $args['custom_attributes']['display'] ) {
			$field = str_replace( '<input type="text" ', '<input type="number" ', $field );
		}
		return $field;
	}

	/**
	 * add_custom_fields_to_store_exporter_order.
	 *
	 * @version 2.3.0
	 * @since   2.2.7
	 */
	function add_custom_fields_to_store_exporter_order( $order, $order_id ) {
		$post_meta = get_post_meta( $order_id );
		foreach( $post_meta as $key => $values ) {
			if ( false !== strpos( $key, 'wcj_checkout_field_' ) && isset( $values[0] ) ) {
				if ( false !== strpos( $key, '_label_' ) ) {
					continue;
				}
				$order->$key = isset( $values[0]['value'] ) ? $values[0]['value'] : $values[0];
			}
		}

		return $order;
	}

	/**
	 * add_custom_fields_to_store_exporter.
	 */
	function add_custom_fields_to_store_exporter( $fields ) {
		for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
			if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {
				$the_section = get_option( 'wcj_checkout_custom_field_section_' . $i );
				$the_key = 'wcj_checkout_field_' . $i;
				$fields[] = array(
					'name'  => $the_section . '_' . $the_key,
					'label' => get_option( 'wcj_checkout_custom_field_label_' . $i ),
				);
			}
		}
		return $fields;
	}

	/**
	 * update_custom_checkout_fields_order_meta.
	 *
	 * @version 4.6.1
	 */
	function update_custom_checkout_fields_order_meta( $order_id ) {
		for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
			if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {
				if ( 'woocommerce_checkout_update_order_meta' === current_filter() && ! $this->is_visible( $i ) ) {
					continue;
				}
				$the_section       = get_option( 'wcj_checkout_custom_field_section_' . $i );
				$the_type          = get_option( 'wcj_checkout_custom_field_type_' . $i );
				$option_name       = $the_section . '_' . 'wcj_checkout_field_'       . $i;
				$option_name_label = $the_section . '_' . 'wcj_checkout_field_label_' . $i;
				$option_name_type  = $the_section . '_' . 'wcj_checkout_field_type_'  . $i;
				$post_value        = isset( $_POST[ $option_name ] ) ? $_POST[ $option_name ] : ( isset( $_POST[ '_' . $option_name ] ) ? $_POST[ '_' . $option_name ] : get_post_meta( $order_id, '_' . $option_name, true ) );
				if ( ! empty( $post_value ) || 'checkbox' === $the_type ) {
					update_post_meta( $order_id, '_' . $option_name_type,  $the_type );
					update_post_meta( $order_id, '_' . $option_name_label, get_option( 'wcj_checkout_custom_field_label_' . $i ) );
					if ( 'checkbox' === $the_type ) {
						$the_value = ! empty( $post_value ) ? 1 : 0;
						update_post_meta( $order_id, '_' . $option_name, $the_value );
						$option_name_checkbox_value  = $the_section . '_' . 'wcj_checkout_field_checkbox_value_' . $i;
						$checkbox_value = ( 1 == $the_value ) ?
							get_option( 'wcj_checkout_custom_field_checkbox_yes_' . $i ) :
							get_option( 'wcj_checkout_custom_field_checkbox_no_' . $i );
						update_post_meta( $order_id, '_' . $option_name_checkbox_value, $checkbox_value );
					} elseif ( 'radio' === $the_type || 'select' === $the_type ) {
						update_post_meta( $order_id, '_' . $option_name, wc_clean( urldecode( $post_value ) ) );
						$option_name_values = $the_section . '_' . 'wcj_checkout_field_select_options_' . $i;
						$the_values = get_option( 'wcj_checkout_custom_field_select_options_' . $i );
						update_post_meta( $order_id, '_' . $option_name_values, $the_values );
					} elseif ( 'textarea' === $the_type && 'no' === get_option( 'wcj_checkout_custom_fields_textarea_clean', 'yes' ) ) {
						update_post_meta( $order_id, '_' . $option_name, urldecode( $post_value ) );
					} else {
						update_post_meta( $order_id, '_' . $option_name, wc_clean( urldecode( $post_value ) ) );
					}
				}
			}
		}
	}

	/**
	 * add_custom_fields_to_emails.
	 *
	 * @version 3.2.2
	 */
	function add_custom_fields_to_emails( $order, $sent_to_admin ) {
		if (
			(   $sent_to_admin && 'yes' === get_option( 'wcj_checkout_custom_fields_email_all_to_admin' ) ) ||
			( ! $sent_to_admin && 'yes' === get_option( 'wcj_checkout_custom_fields_email_all_to_customer' ) )
		) {
			$templates = array(
				'before' => get_option( 'wcj_checkout_custom_fields_emails_template_before', '' ),
				'field'  => get_option( 'wcj_checkout_custom_fields_emails_template_field', '<p><strong>%label%:</strong> %value%</p>' ),
				'after'  => get_option( 'wcj_checkout_custom_fields_emails_template_after', '' ),
			);
			$this->add_custom_fields_to_order_display( $order, '', $templates );
		}
	}

	/**
	 * add_custom_fields_to_view_order_and_thankyou_pages.
	 *
	 * @version 3.2.2
	 * @since   3.2.2
	 */
	function add_custom_fields_to_view_order_and_thankyou_pages( $order ) {
		$templates = array(
			'before' => get_option( 'wcj_checkout_custom_fields_order_received_template_before', '' ),
			'field'  => get_option( 'wcj_checkout_custom_fields_order_received_template_field', '<p><strong>%label%:</strong> %value%</p>' ),
			'after'  => get_option( 'wcj_checkout_custom_fields_order_received_template_after', '' ),
		);
		$this->add_custom_fields_to_order_display( $order, '', $templates );
	}

	/**
	 * add_custom_fields_to_order_display.
	 *
	 * @version 3.8.0
	 * @since   2.3.0
	 * @todo    convert from before version 2.3.0
	 */
	function add_custom_fields_to_order_display( $order, $section = '', $templates ) {
		$post_meta    = get_post_meta( wcj_get_order_id( $order ) );
		$final_output = '';
		foreach( $post_meta as $key => $values ) {
			if ( false !== strpos( $key, 'wcj_checkout_field_' ) && isset( $values[0] ) ) {
				// Checking section (if set)
				if ( '' != $section ) {
					$the_section = strtok( $key, '_' );
					if ( $section !== $the_section ) {
						continue;
					}
				}
				// Skipping unnecessary meta
				if (
					false !== strpos( $key, '_label_' ) ||
					false !== strpos( $key, '_type_' ) ||
					false !== strpos( $key, '_checkbox_value_' ) ||
					false !== strpos( $key, '_select_options_' )
				) {
					continue;
				}
				// Field label
				$label = '';
				$the_label_key = str_replace( 'wcj_checkout_field_', 'wcj_checkout_field_label_', $key );
				if ( isset( $post_meta[ $the_label_key ][0] ) ) {
					$label = $post_meta[ $the_label_key ][0];
				} elseif ( is_array( $values[0] ) && isset( $values[0]['label'] ) ) {
					$label = $values[0]['label'];
				}
				// Field value
				$value    = '';
				$_value   = ( is_array( $values[0] ) && isset( $values[0]['value'] ) ? $values[0]['value'] : $values[0] );
				$type_key = str_replace( 'wcj_checkout_field_', 'wcj_checkout_field_type_', $key );
				if ( isset( $post_meta[ $type_key ][0] ) && 'checkbox' === $post_meta[ $type_key ][0] ) {
					$checkbox_value_key = str_replace( 'wcj_checkout_field_', 'wcj_checkout_field_checkbox_value_', $key );
					$value              = ( isset( $post_meta[ $checkbox_value_key ][0] ) ? $post_meta[ $checkbox_value_key ][0] : $_value );
				} elseif ( isset( $post_meta[ $type_key ][0] ) && ( 'radio' === $post_meta[ $type_key ][0] || 'select' === $post_meta[ $type_key ][0] ) ) {
					$select_values_key = str_replace( 'wcj_checkout_field_', 'wcj_checkout_field_select_options_', $key );
					$select_values     = ( isset( $post_meta[ $select_values_key ][0] ) ) ? $post_meta[ $select_values_key ][0] : '';
					if ( ! empty( $select_values ) ) {
						$select_values_prepared = wcj_get_select_options( $select_values );
						$value = ( isset( $select_values_prepared[ $_value ] ) ? $select_values_prepared[ $_value ] : $_value );
					} else {
						$value = $_value;
					}
				} elseif ( isset( $post_meta[ $type_key ][0] ) && 'textarea' === $post_meta[ $type_key ][0] && 'yes' === get_option( 'wcj_checkout_custom_fields_textarea_replace_line_breaks', 'no' ) ) {
					$value = str_replace( PHP_EOL, '<br>', $_value );
				} else {
					$value = $_value;
				}
				// Adding field to final output
				if ( '' != $label || '' != $value ) {
					$replaced_values = array(
						'%label%' => $label,
						'%value%' => $value,
					);
					$final_output .= str_replace( array_keys( $replaced_values ), $replaced_values, $templates['field'] );
				}
			}
		}
		// Outputting
		if ( '' != $final_output ) {
			echo $templates['before'] . $final_output . $templates['after'];
		}
	}

	/**
	 * add_woocommerce_admin_fields.
	 *
	 * @version 4.7.0
	 * @todo    converting from before version 2.3.0: section?
	 * @todo    add alternative way of displaying fields (e.g. new meta box), so we have more control over displaying fields' values (e.g. line breaks)
	 */
	function add_woocommerce_admin_fields( $fields, $section ) {
		for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {
			if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {
				$the_section = get_option( 'wcj_checkout_custom_field_section_' . $i );
				if ( $section != $the_section ) {
					continue;
				}
				$the_type = get_option( 'wcj_checkout_custom_field_type_' . $i );
				if ( 'select' === $the_type ) {
					$the_class = 'first';
					$options   = wcj_get_select_options( get_option( 'wcj_checkout_custom_field_select_options_' . $i ) );
				} elseif ( 'radio' === $the_type ) {
					$the_options = get_post_meta( get_the_ID(), '_' . $section . '_' . 'wcj_checkout_field_select_options_' . $i, true );
					if ( ! empty( $the_options ) ) {
						$the_type  = 'select';
						$the_class = 'first';
						$options   = wcj_get_select_options( $the_options );
					} else {
						$the_options = wcj_get_select_options( get_option( 'wcj_checkout_custom_field_select_options_' . $i ) );
						if ( ! empty( $the_options ) ) {
							$the_type  = 'select';
							$the_class = 'first';
							$options   = $the_options;
						} else {
							$the_type  = 'text';
							$the_class = 'short';
						}
					}
				} elseif ( 'country' === $the_type ) {
					$the_type  = 'select';
					$the_class = 'js_field-country select short';
					$options   = WC()->countries->get_allowed_countries();
				} else {
					$the_type  = 'text';
					$the_class = 'short';
				}
				$the_key       = 'wcj_checkout_field_' . $i;
				$the_key_label = 'wcj_checkout_field_label_' . $i;
				$the_meta      = get_post_meta( get_the_ID(), '_' . $section . '_' . $the_key, true );
				if ( is_array( $the_meta ) ) {
					// Converting from before version 2.3.0
					if ( isset( $the_meta['value'] ) ) {
						update_post_meta( get_the_ID(), '_' . $section . '_' . $the_key,       $the_meta['value'] );
					}
					if ( isset( $the_meta['label'] ) ) {
						update_post_meta( get_the_ID(), '_' . $section . '_' . $the_key_label, $the_meta['label'] );
					}
				}
				if ( ! isset( $_POST[ '_' . $section . '_' . $the_key ] ) ) {
					$fields[ $the_key ] = array(
						'type'          => $the_type,
						'label'         => ( '' != get_post_meta( get_the_ID(), '_' . $section . '_' . $the_key_label, true ) ) ?
							get_post_meta( get_the_ID(), '_' . $section . '_' . $the_key_label, true ) :
							get_option( 'wcj_checkout_custom_field_label_' . $i ),
						'show'          => true,
						'class'         => $the_class,
						'wrapper_class' => 'form-field-wide',
					);
					if ( ! empty( $the_meta ) && ! is_array( $the_meta ) ) {
						$fields[ $the_key ]['value'] = $the_meta;
					}
					if ( isset( $options ) ) {
						add_filter( "woocommerce_order_get__{$section}_{$the_key}", function ( $name ) use ( $options ) {
							if ( isset( $options[ $name ] ) ) {
								return $options[ $name ];
							}
							return $name;
						} );
						$fields[ $the_key ]['options'] = $options;
					}
				}
			}
		}
		return $fields;
	}

	/**
	 * add_custom_billing_fields_to_admin_order_display.
	 */
	function add_custom_billing_fields_to_admin_order_display( $fields ) {
		return $this->add_woocommerce_admin_fields( $fields, 'billing' );
	}

	/**
	 * add_custom_shipping_fields_to_admin_order_display.
	 */
	function add_custom_shipping_fields_to_admin_order_display( $fields ) {
		return $this->add_woocommerce_admin_fields( $fields, 'shipping' );
	}

	/**
	 * add_custom_order_and_account_fields_to_admin_order_display
	 *
	 * @version 3.2.2
	 */
	function add_custom_order_and_account_fields_to_admin_order_display( $order ) {
		$templates = array(
			'before' => '<div class="clear"></div><p>',
			'field'  => '<strong>%label%: </strong>%value%<br>',
			'after'  => '</p>',
		);
		$this->add_custom_fields_to_order_display( $order, 'order',   $templates );
		$this->add_custom_fields_to_order_display( $order, 'account', $templates );
	}

	/**
	 * is_visible.
	 *
	 * @version 4.2.0
	 * @since   2.6.0
	 * @todo    add "user roles to include/exclude"
	 */
	function is_visible( $i ) {

		if ( apply_filters( 'wcj_checkout_custom_field_always_visible_on_empty_cart', false ) && WC()->cart->is_empty() ) {
			// Added for "One Page Checkout" plugin compatibility.
			return true;
		}

		// Checking categories
		$categories_ex = get_option( 'wcj_checkout_custom_field_categories_ex_' . $i );
		if ( ! empty( $categories_ex ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$product_categories = get_the_terms( $values['product_id'], 'product_cat' );
				if ( empty( $product_categories ) ) {
					continue;
				}
				foreach( $product_categories as $product_category ) {
					if ( in_array( $product_category->term_id, $categories_ex ) ) {
						return false;
					}
				}
			}
		}
		$categories_in = get_option( 'wcj_checkout_custom_field_categories_in_' . $i );
		if ( ! empty( $categories_in ) ) {
			$categories_in_cart = array();
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$product_categories = wp_get_post_terms( $values['product_id'], 'product_cat', array( "fields" => "ids" ) );
				$categories_in_cart = array_merge( $product_categories, $categories_in_cart );
			}
			if ( count( array_intersect( $categories_in, $categories_in_cart ) ) == 0 ) {
				return false;
			}
		}

		// Checking products
		$products_ex = get_option( 'wcj_checkout_custom_field_products_ex_' . $i );
		if ( ! empty( $products_ex ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				if ( in_array( $values['product_id'], $products_ex ) ) {
					return false;
				}
			}
		}
		$products_in = get_option( 'wcj_checkout_custom_field_products_in_' . $i );
		if ( ! empty( $products_in ) ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				if ( in_array( $values['product_id'], $products_in ) ) {
					return true;
				}
			}
			return false;
		}

		// Checking min/max cart amount
		$cart_total = false;
		if ( ( $min_cart_amount = get_option( 'wcj_checkout_custom_field_min_cart_amount_' . $i, 0 ) ) > 0 ) {
			WC()->cart->calculate_totals();
			$cart_total = WC()->cart->total;
			if ( $cart_total < $min_cart_amount ) {
				return false;
			}
		}
		if ( ( $max_cart_amount = get_option( 'wcj_checkout_custom_field_max_cart_amount_' . $i, 0 ) ) > 0 ) {
			if ( false === $cart_total ) {
				WC()->cart->calculate_totals();
				$cart_total = WC()->cart->total;
			}
			if ( $cart_total > $max_cart_amount ) {
				return false;
			}
		}

		// All passed
		return apply_filters( 'wcj_checkout_custom_field_visible', true, $i );
	}

	/**
	 * add_custom_checkout_fields.
	 *
	 * @version 3.8.0
	 * @todo    (maybe) fix - priority seems to not affect tab order (same in Checkout Core Fields module)
	 * @todo    (dev) (maybe) add `do_shortcode` for e.g. `description` etc.
	 */
	function add_custom_checkout_fields( $fields ) {

		for ( $i = 1; $i <= apply_filters( 'booster_option', 1, get_option( 'wcj_checkout_custom_fields_total_number', 1 ) ); $i++ ) {

			if ( 'yes' === get_option( 'wcj_checkout_custom_field_enabled_' . $i ) ) {

				if ( ! $this->is_visible( $i ) ) {
					continue;
				}

				$the_type = get_option( 'wcj_checkout_custom_field_type_' . $i );
				$custom_attributes = array();
				if ( 'datepicker' === $the_type || 'weekpicker' === $the_type || 'timepicker' === $the_type || 'number' === $the_type ) {
					if ( 'datepicker' === $the_type || 'weekpicker' === $the_type ) {
						$datepicker_format_option = get_option( 'wcj_checkout_custom_field_datepicker_format_' . $i, '' );
						$datepicker_format = ( '' == $datepicker_format_option ) ? get_option( 'date_format' ) : $datepicker_format_option;
						$datepicker_format = wcj_date_format_php_to_js( $datepicker_format );
						$custom_attributes['dateformat'] = $datepicker_format;
						$custom_attributes['mindate']    = get_option( 'wcj_checkout_custom_field_datepicker_mindate_' . $i, -365 );
						if ( 0 == $custom_attributes['mindate'] ) {
							$custom_attributes['mindate'] = 'zero';
						}
						$custom_attributes['maxdate']    = get_option( 'wcj_checkout_custom_field_datepicker_maxdate_' . $i,  365 );
						if ( 0 == $custom_attributes['maxdate'] ) {
							$custom_attributes['maxdate'] = 'zero';
						}
						$custom_attributes['firstday']   = get_option( 'wcj_checkout_custom_field_datepicker_firstday_' . $i, 0 );
						if ( 'yes' === get_option( 'wcj_checkout_custom_field_datepicker_changeyear_' . $i, 'yes' ) ) {
							$custom_attributes['changeyear'] = 1;
							$custom_attributes['yearrange']  = get_option( 'wcj_checkout_custom_field_datepicker_yearrange_' . $i, 'c-10:c+10' );
						}
						$custom_attributes['display']    = ( 'datepicker' === $the_type ) ? 'date' : 'week';
					} elseif ( 'timepicker' === $the_type ) {
						$custom_attributes['timeformat'] = get_option( 'wcj_checkout_custom_field_timepicker_format_' . $i, 'hh:mm p' );
						$custom_attributes['interval'] = get_option( 'wcj_checkout_custom_field_timepicker_interval_' . $i, 15 );
						$custom_attributes['display'] = 'time';
					} else { // 'number'
						$custom_attributes['display'] = $the_type;
					}
					$the_type = 'text';
				}
				$the_section = get_option( 'wcj_checkout_custom_field_section_' . $i );
				$the_key = 'wcj_checkout_field_' . $i;

				$the_field = array(
					'type'              => $the_type,
					'label'             => get_option( 'wcj_checkout_custom_field_label_' . $i ),
					'placeholder'       => get_option( 'wcj_checkout_custom_field_placeholder_' . $i ),
					'required'          => ( 'yes' === get_option( 'wcj_checkout_custom_field_required_' . $i ) ),
					'custom_attributes' => $custom_attributes,
					'clear'             => ( 'yes' === get_option( 'wcj_checkout_custom_field_clear_' . $i ) ),
					'class'             => array( get_option( 'wcj_checkout_custom_field_class_' . $i ) ),
					'priority'          => get_option( 'wcj_checkout_custom_field_priority_' . $i, '' ),
					'description'       => get_option( 'wcj_checkout_custom_field_description_' . $i, '' ),
				);

				if ( 'select' === $the_type || 'radio' === $the_type ) {
					$select_options_raw = get_option( 'wcj_checkout_custom_field_select_options_' . $i );
					$select_options = wcj_get_select_options( $select_options_raw );
					if ( 'select' === $the_type ) {
						$placeholder = get_option( 'wcj_checkout_custom_field_placeholder_' . $i );
						if ( '' != $placeholder ) {
							$select_options = array_replace( array( '' => $placeholder ), $select_options );
						}
					}
					$the_field['options'] = $select_options;
					if ( ! empty( $select_options ) ) {
						reset( $select_options );
						$the_field['default'] = key( $select_options );
					}
				}

				if ( 'checkbox' === $the_type ) {
					$the_field['default'] = ( 'yes' === get_option( 'wcj_checkout_custom_field_checkbox_default_' . $i ) ) ? 1 : 0;
				}

				$fields[ $the_section ][ $the_section . '_' . $the_key ] = $the_field;
			}
		}
		return $fields;
	}

}

endif;

return new WCJ_Checkout_Custom_Fields();
