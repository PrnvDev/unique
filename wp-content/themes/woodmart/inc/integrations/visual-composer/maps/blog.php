<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
*  Blog element map
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_get_vc_map_blog' ) ) {
	function woodmart_get_vc_map_blog() {
		$post_types_list   = array();
		$post_types_list[] = array( 'post', esc_html__( 'Post', 'woodmart' ) );
		$post_types_list[] = array( 'ids', esc_html__( 'List of IDs', 'woodmart' ) );

		return array(
			'name'        => esc_html__( 'Blog', 'woodmart' ),
			'base'        => 'woodmart_blog',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Show your blog posts on the page', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/blog.svg',
			'params'      => array(
				/**
				 * Post source
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Post source', 'woodmart' ),
					'param_name' => 'source_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Data source', 'woodmart' ),
					'param_name'       => 'post_type',
					'value'            => $post_types_list,
					'hint'             => esc_html__( 'Select content type for your grid.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'autocomplete',
					'heading'          => esc_html__( 'Include only', 'woodmart' ),
					'param_name'       => 'include',
					'hint'             => esc_html__( 'Add posts, pages, etc. by title.', 'woodmart' ),
					'settings'         => array(
						'multiple' => true,
						'sortable' => true,
						'groups'   => true,
					),
					'dependency'       => array(
						'element' => 'post_type',
						'value'   => array( 'ids' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				// Custom query tab
				array(
					'type'             => 'textarea_safe',
					'heading'          => esc_html__( 'Custom query', 'woodmart' ),
					'param_name'       => 'custom_query',
					'hint'             => wp_kses(
						__( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'woodmart' ),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
							),
						)
					),
					'dependency'       => array(
						'element' => 'post_type',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'               => 'autocomplete',
					'heading'            => esc_html__( 'Narrow data source', 'woodmart' ),
					'param_name'         => 'taxonomies',
					'settings'           => array(
						'multiple'       => true,
						// is multiple values allowed? default false
						// 'sortable' => true, // is values are sortable? default false
						'min_length'     => 1,
						// min length to start search -> default 2
						// 'no_hide' => true, // In UI after select doesn't hide an select list, default false
						'groups'         => true,
						// In UI show results grouped by groups, default false
						'unique_values'  => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay'          => 500,
						// delay for search. default 500
						'auto_focus'     => true,
						// auto focus input, default true
						// 'values' => $taxonomies_for_filter,
					),
					'param_holder_class' => 'vc_not-for-custom',
					'hint'               => esc_html__( 'Enter categories, tags or custom taxonomies.', 'woodmart' ),
					'dependency'         => array(
						'element'            => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Pagination
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Pagination', 'woodmart' ),
					'param_name' => 'pagination_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Items per page', 'woodmart' ),
					'param_name'       => 'items_per_page',
					'hint'             => esc_html__( 'Number of items to show per page.', 'woodmart' ),
					'value'            => '10',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Pagination', 'woodmart' ),
					'param_name'       => 'pagination',
					'value'            => array(
						'' => '',
						esc_html__( 'Pagination', 'woodmart' ) => 'pagination',
						wp_kses( __( 'Load more button', 'woodmart' ), 'entities' ) => 'more-btn',
						esc_html__( 'Infinit scrolling', 'woodmart' ) => 'infinit',
					),
					'dependency'       => array(
						'element'            => 'blog_design',
						'value_not_equal_to' => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Design
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Design', 'woodmart' ),
					'group'      => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'design_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Blog design', 'woodmart' ),
					'param_name'       => 'blog_design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Default alternative', 'woodmart' ) => 'default-alt',
						esc_html__( 'Small images', 'woodmart' ) => 'small-images',
						esc_html__( 'Chess', 'woodmart' ) => 'chess',
						esc_html__( 'Masonry grid', 'woodmart' ) => 'masonry',
						esc_html__( 'Mask on image', 'woodmart' ) => 'mask',
						esc_html__( 'Meta on image', 'woodmart' ) => 'meta-image',
						esc_html__( 'Carousel', 'woodmart' ) => 'carousel',
						esc_html__( 'List', 'woodmart' ) => 'list',
					),
					'hint'             => esc_html__( 'You can use different design for your blog styled for the theme', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Blog carousel design', 'woodmart' ),
					'param_name'       => 'blog_carousel_design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'masonry',
						esc_html__( 'Small images', 'woodmart' ) => 'small-images',
						esc_html__( 'Mask on image', 'woodmart' ) => 'mask',
						esc_html__( 'Meta on image', 'woodmart' ) => 'meta-image',
					),
					'hint'             => esc_html__( 'You can use different design for your blog carousel', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Images size', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Columns', 'woodmart' ),
					'hint'             => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'columns_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'masonry', 'mask', 'meta-image' ),
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'blog_columns',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'value'            => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
					),
					'std'              => '3',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'masonry', 'mask', 'meta-image' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'desktop' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'blog_columns_tablet',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
					),
					'std'              => 'auto',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'masonry', 'mask', 'meta-image' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'tablet' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'blog_columns_mobile',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
					),
					'std'              => 'auto',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'masonry', 'mask', 'meta-image' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'mobile' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Space between posts', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'blog_spacing',
					'value'            => array(
						'',
						0,
						2,
						6,
						10,
						20,
						30,
					),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'mask', 'masonry', 'carousel', 'meta-image' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Carousel
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Carousel', 'woodmart' ),
					'group'      => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'carousel_divider',
					'dependency' => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Slides per view', 'woodmart' ),
					'hint'             => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'slides_per_view_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view',
					'value'            => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
					),
					'std'              => '3',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'desktop' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view_tablet',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
					),
					'std'              => 'auto',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'tablet' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view_mobile',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
					),
					'std'              => 'auto',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'mobile' ),
					),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Scroll per page', 'woodmart' ),
					'param_name'       => 'scroll_per_page',
					'hint'             => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'yes',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Slider autoplay', 'woodmart' ),
					'param_name'       => 'autoplay',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'hint'             => esc_html__( 'Enables autoplay mode.', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Slider speed', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'speed',
					'value'            => '5000',
					'hint'             => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Slider loop', 'woodmart' ),
					'param_name'       => 'wrap',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'hint'             => esc_html__( 'Enables loop mode.', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name'       => 'hide_pagination_control',
					'hint'             => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name'       => 'hide_prev_next_buttons',
					'hint'             => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Elements visibility
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Elements visibility', 'woodmart' ),
					'group'      => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'visibility_divider',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Title for posts', 'woodmart' ),
					'param_name'       => 'parts_title',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Meta information', 'woodmart' ),
					'param_name'       => 'parts_meta',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Post text', 'woodmart' ),
					'param_name'       => 'parts_text',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Read more button', 'woodmart' ),
					'param_name'       => 'parts_btn',
					'group'            => esc_html__( 'Design', 'woodmart' ),
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				// Data settings
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Data settings', 'woodmart' ),
					'group'      => esc_html__( 'Data Settings', 'woodmart' ),
					'param_name' => 'data_tab_divider',
				),
				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Order by', 'woodmart' ),
					'param_name'         => 'orderby',
					'value'              => array(
						esc_html__( 'Date', 'woodmart' )   => 'date',
						esc_html__( 'Order by post ID', 'woodmart' ) => 'ID',
						esc_html__( 'Author', 'woodmart' ) => 'author',
						esc_html__( 'Title', 'woodmart' )  => 'title',
						esc_html__( 'Last modified date', 'woodmart' ) => 'modified',
						esc_html__( 'Post/page parent ID', 'woodmart' ) => 'parent',
						esc_html__( 'Number of comments', 'woodmart' ) => 'comment_count',
						esc_html__( 'Menu order/Page Order', 'woodmart' ) => 'menu_order',
						esc_html__( 'Meta value', 'woodmart' ) => 'meta_value',
						esc_html__( 'Meta value number', 'woodmart' ) => 'meta_value_num',
						esc_html__( 'Random order', 'woodmart' ) => 'rand',
						esc_html__( 'List of IDS', 'woodmart' ) => 'post__in',
					),
					'hint'               => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'woodmart' ),
					'group'              => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Sorting', 'woodmart' ),
					'param_name'         => 'order',
					'group'              => esc_html__( 'Data Settings', 'woodmart' ),
					'value'              => array(
						esc_html__( 'Descending', 'woodmart' ) => 'DESC',
						esc_html__( 'Ascending', 'woodmart' ) => 'ASC',
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'hint'               => esc_html__( 'Select sorting order.', 'woodmart' ),
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__( 'Meta key', 'woodmart' ),
					'param_name'         => 'meta_key',
					'hint'               => esc_html__( 'Input meta key for grid ordering.', 'woodmart' ),
					'group'              => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency'         => array(
						'element' => 'orderby',
						'value'   => array( 'meta_value', 'meta_value_num' ),
					),
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'               => 'textfield',
					'heading'            => esc_html__( 'Offset', 'woodmart' ),
					'param_name'         => 'offset',
					'hint'               => esc_html__( 'Number of grid elements to displace or pass over.', 'woodmart' ),
					'group'              => esc_html__( 'Data Settings', 'woodmart' ),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency'         => array(
						'element'            => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
					),
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'               => 'autocomplete',
					'heading'            => esc_html__( 'Exclude', 'woodmart' ),
					'param_name'         => 'exclude',
					'hint'               => esc_html__( 'Exclude posts, pages, etc. by title.', 'woodmart' ),
					'group'              => esc_html__( 'Data Settings', 'woodmart' ),
					'settings'           => array(
						'multiple' => true,
					),
					'param_holder_class' => 'vc_grid-data-type-not-ids',
					'dependency'         => array(
						'element'            => 'post_type',
						'value_not_equal_to' => array( 'ids', 'custom' ),
						'callback'           => 'vc_grid_exclude_dependency_callback',
					),
					'edit_field_class'   => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Extra
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Lazy loading for images', 'woodmart' ),
					'hint'             => esc_html__( 'Enable lazy loading for images for this element.', 'woodmart' ),
					'param_name'       => 'lazy_loading',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Init carousel on scroll', 'woodmart' ),
					'hint'             => esc_html__( 'This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.', 'woodmart' ),
					'param_name'       => 'scroll_carousel_init',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'blog_design',
						'value'   => array( 'carousel' ),
					),
				),
			),
		);
	}
}

// Necessary hooks for blog autocomplete fields
add_filter( 'vc_autocomplete_woodmart_blog_include_callback', 'vc_include_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter(
	'vc_autocomplete_woodmart_blog_include_render',
	'vc_include_field_render',
	10,
	1
); // Render exact product. Must return an array (label,value)

// Narrow data taxonomies
add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_woodmart_blog_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

// Narrow data taxonomies for exclude_filter
add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_woodmart_blog_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

add_filter( 'vc_autocomplete_woodmart_blog_exclude_callback', 'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_woodmart_blog_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)
