<?php
/*
 * Plugin Name: SnappPay payment gateway
 * Plugin URI: 
 * Description: Add SnappPay payment gateway to your shop
 * Author: Yalda sharafi
 * Author URI: 
 * Version: 1.0.1
 */


 /**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_filter( 'woocommerce_payment_gateways', 'snappay_add_gateway_class' );
    /*
    * Registers WooCommerce payment gateway class
    */
    
    function snappay_add_gateway_class( $gateways ) {
        $gateways[] = 'WC_snappay_Gateway'; 
        return $gateways;
    }
    
    
    add_action( 'plugins_loaded', 'snappay_init_gateway_class' );
    function snappay_init_gateway_class() {
    
        class WC_snappay_Gateway extends WC_Payment_Gateway {
    
                public function __construct() {
    
                $this->id = 'snappay'; 
                $this->method_title = 'SnappPay Payment';
                $this->method_description = 'SnappPay credit payment service'; 
                $this->supports = array(
                    'products'
                );
    
                // Method with all the options fields
                $this->init_form_fields();
    
                // Load the settings.
                $this->init_settings();
                $this->title = $this->get_option( 'title' );
                $this->description = $this->get_option( 'description' );
                $this->enabled = $this->get_option( 'enabled' );
    
                // This action hook saves the settings
                add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
                
            }
    
            public function init_form_fields(){
    
                $this->form_fields = array(
                    'enabled' => array(
                        'title'       => 'Enable/Disable',
                        'label'       => 'Enable SnappPay payment',
                        'type'        => 'checkbox',
                        'description' => '',
                        'default'     => 'no'
                    ),
                    'title' => array(
                        'title'       => 'Title',
                        'type'        => 'text',
                        'description' => 'This controls the title which the user sees during checkout.',
                        'default'     => 'SnappPay',
                        'desc_tip'    => true,
                    ),
                    'description' => array(
                        'title'       => 'Description',
                        'type'        => 'textarea',
                        'description' => 'This controls the description which the user sees during checkout.',
                        'default'     => 'Pay with snappPay Installment payment credit service, buy now, pay later',
                    )
                );
            }
    
    
            public function payment_fields() {
    
                echo '<div class="snapay__sheba-wrapper">' ;
                if ( $this->description ) {
                    echo wpautop( wp_kses_post( $this->description ) );
                }
                echo '<span> IR145698745698745321581564 </span>' ;
                echo '</div>' ;
    
            }
    
            }
    }

} else {
    // WooCommerce is NOT enabled!
}


        
    