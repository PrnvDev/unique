<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

$thegem_checkout_type = thegem_checkout_get_type();

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
			}
			?>
		</ul>
	<?php endif; ?>
	<div class="form-row place-order">
		<noscript>
			<?php
			/* translators: $1 and $2 opening and closing emphasis tags respectively */
			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
			?>
			<br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<div class="checkout-navigation-buttons">
			<?php
				if($thegem_checkout_type == 'multi-step') {
					thegem_button(array(
						'tag' => 'button',
						'text' => esc_html__( 'Previous step', 'thegem' ),
						'style' => 'outline',
						'size' => 'medium',
						'extra_class' => 'checkout-prev-step',
						'attributes' => array(
							'value' => esc_attr__( 'Previous step', 'thegem' ),
							'type' => 'button',
							'class' => 'gem-button-tablet-size-small'
						)
					), true);
				}
			?>
			<?php
				thegem_button(array(
					'tag' => 'button',
					'text' => esc_attr( $order_button_text ),
					'style' => 'flat',
					'size' => $thegem_checkout_type != 'one-page-modern' ? 'medium' : 'small',
					'position' => $thegem_checkout_type != 'one-page-modern' ? 'inline' : 'fullwidth',
					'extra_class' => 'checkout-place-order',
					'attributes' => array(
						'id' => 'place_order',
						'name' => 'woocommerce_checkout_place_order',
						'value' => esc_attr( $order_button_text ),
						'type' => 'submit',
						'data-value' => esc_attr( $order_button_text ),
						'class' => 'gem-button-tablet-size-small'
					)
				), true);
			?>
		</div>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
