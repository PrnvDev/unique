<?php
if (!defined('ABSPATH')) exit;
if (!isset($settings['readmore_button_size']) || $settings['readmore_button_size'] == 'default') {
	if (isset($settings['thegem_elementor_preset']) && $settings['thegem_elementor_preset'] == 'list') {
		$size = $settings['columns_desktop'] == '1x' ? 'small' : 'tiny';
	} else {
		$size = $settings['columns_desktop'] == '4x' ? 'tiny' : 'small';
	}
} else {
	$size = $settings['readmore_button_size'];
}

$link = !isset($settings['readmore_button_link']) || $settings['readmore_button_link'] == 'default' ? get_the_permalink() : $settings['readmore_button_custom_link']['url'];
$type = isset($settings['readmore_button_type']) ? $settings['readmore_button_type'] : 'outline';
$id = isset($settings['readmore_button_id']) ? $settings['readmore_button_id'] : ''; ?>

<div class="gem-button-container gem-widget-button gem-button-position-inline">
	<a id="<?php echo esc_attr($id); ?>"
	   class="gem-button gem-button-size-<?php echo esc_attr($size); ?> gem-button-style-<?php echo esc_attr($type); ?>"
	   href="<?php echo $link; ?>">
		<span class="gem-inner-wrapper-btn">
			<span class="gem-text-button">
				<?php echo wp_kses($settings['blog_readmore_button_text'], 'post'); ?>
			</span>
		</span>
	</a>
</div>
