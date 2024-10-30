<?php
/**
 * Helpers class.
 *
 * @since 1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Helpers
 *
 * @since 1.0.0
 */
class Helpers {

	/**
	 * Get categories
	 *
	 * @since 1.0.0
	 */
	public static function get_categories() {
		return [ 'blocks-monster', 'basic' ];
	}

	/**
	 * Get common keywords
	 *
	 * @param array $keywords New keywords.
	 * @since 1.0.0
	 */
	public static function get_keywords( $keywords = [] ) {
		$default = [ 'blocks', 'blocks monster', 'monster' ];

		return array_merge( $default, $keywords );
	}

	/**
	 * Register "Get Pro" Section
	 *
	 * @param object $self Elementor object.
	 * @param array  $label Arguments.
	 */
	public static function register_pro_section( $self, $label ) {
		$id = str_replace( ' ', '-', $label );
		$id = strtolower( $id );

		$self->start_controls_section(
			$id . '_box',
			[
				'label' => $label . ' (Pro)',
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Buy pro.
		$self->add_control(
			$id . '_box_content',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => '<div style="text-align: center;"><h2 style="font-weight: 600;margin: 0 0 10px 0;font-size: 14px;">' . esc_html__( 'Unlock Premium Features!', 'blocks-monster' ) . '</h2><p style="margin: 0 0 10px 0;">' . esc_html__( 'Upgrade to Blocks Monster Pro for enhanced functionality and exclusive benefits.', 'blocks-monster' ) . '</p><p style="margin: 0 0 10px 0;">' . esc_html__( 'Ready to level up your experience?', 'blocks-monster' ) . '</p><a href="https://clipboard.agency/#pricing" class="button button-primary" target="_blank">' . esc_html__( 'See Pricing Plans', 'blocks-monster' ) . '</a></div>',
			]
		);

		$self->end_controls_section();
	}

	/**
	 * Register "Get Pro" Sections
	 *
	 * @param object $self Elementor object.
	 * @param array  $labels Labels.
	 */
	public static function register_pro_sections( $self, $labels = [] ) {
		foreach ( $labels as $label ) {
			self::register_pro_section( $self, $label );
		}
	}

	/**
	 * Register normal and hover styles.
	 *
	 * @param object $self Elementor object.
	 * @param string $label Label.
	 * @param string $selector Selector.
	 * @param array  $args Arguments.
	 */
	public static function register_style_section( $self, $label = '', $selector = '', $args = [] ) {
		$id = 'reusable-' . sanitize_title_with_dashes( $label );

		$size              = isset( $args['size'] ) ? $args['size'] : false;
		$text_decoration   = isset( $args['text_decoration'] ) ? $args['text_decoration'] : false;
		$margin            = isset( $args['margin'] ) ? $args['margin'] : true;
		$padding           = isset( $args['padding'] ) ? $args['padding'] : true;
		$border            = isset( $args['border'] ) ? $args['border'] : false; // Disabled.
		$border_radius     = isset( $args['border_radius'] ) ? $args['border_radius'] : true;
		$background        = isset( $args['background'] ) ? $args['background'] : false; // Disabled.
		$text_color        = isset( $args['text_color'] ) ? $args['text_color'] : false; // Disabled.
		$typography        = isset( $args['typography'] ) ? $args['typography'] : true;
		$text_align        = isset( $args['text_align'] ) ? $args['text_align'] : true;
		$box_shadow        = isset( $args['box_shadow'] ) ? $args['box_shadow'] : false; // Disabled.
		$tabs              = isset( $args['tabs'] ) ? $args['tabs'] : true;
		$normal_background = isset( $args['normal_background'] ) ? $args['normal_background'] : true;
		$normal_text_color = isset( $args['normal_text_color'] ) ? $args['normal_text_color'] : true;
		$normal_typography = isset( $args['normal_typography'] ) ? $args['normal_typography'] : false; // Disabled.
		$normal_border     = isset( $args['normal_border'] ) ? $args['normal_border'] : true;
		$normal_box_shadow = isset( $args['normal_box_shadow'] ) ? $args['normal_box_shadow'] : true;

		// Section.
		$self->start_controls_section(
			$id . '_style_section',
			[
				'label' => $label,
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		if ( $margin ) :
			$self->add_responsive_control(
				$id . '_margin',
				[
					'label'      => esc_html__( 'Margin', 'blocks-monster' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		endif;

		if ( $padding ) :
			$self->add_responsive_control(
				$id . '_padding',
				[
					'label'      => esc_html__( 'Padding', 'blocks-monster' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		endif;

		if ( $border ) :
			$border_selector = '{{WRAPPER}} ' . $selector;
			if ( isset( $args['border'] ) && is_array( $args['border'] ) ) {
				if ( isset( $args['border']['selector'] ) ) {
					$border_selector = $args['border']['selector'];
				}
			}
			$self->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => $id . '_border',
					'selector' => $border_selector,
				]
			);
		endif;

		if ( $border_radius ) :
			$self->add_responsive_control(
				$id . '_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'blocks-monster' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		endif;

		if ( $background ) :
			$self->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => $id . '_background',
					'types'    => [ 'classic', 'gradient', 'image', 'video' ],
					'selector' => '{{WRAPPER}} ' . $selector,
				]
			);
		endif;

		if ( $text_color ) :
			$self->add_control(
				$id . '_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'blocks-monster' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
					],
				]
			);
		endif;

		if ( $typography ) :
			$self->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => $id . '_typography',
					'selector' => '{{WRAPPER}} ' . $selector,
				]
			);
		endif;

		if ( $size ) :
			$size_label     = esc_html__( 'Width', 'blocks-monster' );
			$size_selectors = [
				'{{WRAPPER}} ' . $selector => 'width: {{SIZE}}{{UNIT}};',
			];
			if ( isset( $args['size'] ) && is_array( $args['size'] ) ) {
				if ( isset( $args['size']['selectors'] ) ) {
					$size_selectors = $args['size']['selectors'];
				}
				if ( isset( $args['size']['label'] ) ) {
					$size_label = $args['size']['label'];
				}
			}

			$self->add_responsive_control(
				$id . '_size',
				[
					'label'      => $size_label,
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => $size_selectors,
				]
			);
		endif;

		if ( $text_decoration ) :
			$text_decoration_selectors = [
				'{{WRAPPER}} ' . $selector => 'text-decoration: {{VALUE}};',
			];
			if ( isset( $args['text_decoration'] ) && is_array( $args['text_decoration'] ) ) {
				if ( isset( $args['text_decoration']['selectors'] ) ) {
					$text_decoration_selectors = $args['text_decoration']['selectors'];
				}
			}

			$self->add_control(
				$id . '_text_decoration',
				[
					'label'     => esc_html__( 'Text Decoration', 'blocks-monster' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'none'         => esc_html__( 'None', 'blocks-monster' ),
						'underline'    => esc_html__( 'Underline', 'blocks-monster' ),
						'overline'     => esc_html__( 'Overline', 'blocks-monster' ),
						'line-through' => esc_html__( 'Line Through', 'blocks-monster' ),
					],
					'selectors' => $text_decoration_selectors,
				]
			);
		endif;

		if ( $text_align ) :
			$self->add_responsive_control(
				$id . '_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'blocks-monster' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => esc_html__( 'Left', 'blocks-monster' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'blocks-monster' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'blocks-monster' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}};',
					],
				]
			);
		endif;

		if ( $box_shadow ) :
			$self->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => $id . '_box_shadow',
					'selector' => '{{WRAPPER}} ' . $selector,
				]
			);
		endif;

		if ( $tabs ) :
			// Tabs.
			$self->start_controls_tabs(
				$id . '_style_tabs'
			);

			// Normal.
			$self->start_controls_tab(
				$id . '_style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'blocks-monster' ),
				]
			);

			if ( $normal_background ) :
				$self->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => $id . '_normal_background',
						'types'    => [ 'classic', 'gradient', 'image', 'video' ],
						'selector' => '{{WRAPPER}} ' . $selector,
					]
				);
			endif;

			if ( $normal_text_color ) :
				$normal_text_color_label     = esc_html__( 'Text Color', 'blocks-monster' );
				$normal_text_color_selectors = [
					'{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
				];
				if ( isset( $args['normal_text_color'] ) && is_array( $args['normal_text_color'] ) ) {
					if ( isset( $args['normal_text_color']['selectors'] ) ) {
						$normal_text_color_selectors = $args['normal_text_color']['selectors'];
					}
					if ( isset( $args['normal_text_color']['label'] ) ) {
						$normal_text_color_label = $args['normal_text_color']['label'];
					}
				}
				$self->add_control(
					$id . '_normal_text_color',
					[
						'label'     => $normal_text_color_label,
						'type'      => Controls_Manager::COLOR,
						'selectors' => $normal_text_color_selectors,
					]
				);
			endif;

			if ( $normal_typography ) :
				$self->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => $id . '_normal_typography',
						'selector' => '{{WRAPPER}} ' . $selector,
					]
				);
			endif;

			if ( $normal_border ) :
				$self->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => $id . '_normal_border',
						'default'  => 'red',
						'selector' => '{{WRAPPER}} ' . $selector,
					]
				);
			endif;

			if ( $normal_box_shadow ) :
				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'     => $id . '_normal_box_shadow',
						'selector' => '{{WRAPPER}} ' . $selector,
					]
				);
			endif;

			$self->end_controls_tab();
			// Normal End.

			// Hover.
			$self->start_controls_tab(
				$id . '_style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'blocks-monster' ),
				]
			);

			if ( $normal_background ) :
				$self->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => $id . '_hover_background',
						'types'    => [ 'classic', 'gradient', 'image', 'video' ],
						'selector' => '{{WRAPPER}} ' . $selector . ':hover',
					]
				);
			endif;

			if ( $normal_text_color ) :

				$hover_text_color_label     = esc_html__( 'Text Color', 'blocks-monster' );
				$hover_text_color_selectors = [
					'{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
				];
				if ( isset( $args['hover_text_color'] ) && is_array( $args['hover_text_color'] ) ) {
					if ( isset( $args['hover_text_color']['selectors'] ) ) {
						$hover_text_color_selectors = $args['hover_text_color']['selectors'];
					}
					if ( isset( $args['hover_text_color']['label'] ) ) {
						$hover_text_color_label = $args['hover_text_color']['label'];
					}
				}

				$self->add_control(
					$id . '_hover_text_color',
					[
						'label'     => $hover_text_color_label,
						'type'      => Controls_Manager::COLOR,
						'selectors' => $hover_text_color_selectors,
					]
				);
			endif;

			if ( $normal_border ) :
				$self->add_control(
					$id . '_hover_border',
					[
						'label'     => esc_html__( 'Border Color', 'blocks-monster' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ' . $selector . ':hover' => 'border-color: {{VALUE}};',
						],
					]
				);
			endif;

			if ( $normal_box_shadow ) :
				$self->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'     => $id . '_hover_box_shadow',
						'selector' => '{{WRAPPER}} ' . $selector . ':hover',
					]
				);
			endif;

			$self->end_controls_tab();
			// Hover End.

			$self->end_controls_tabs();
			// Tabs.
		endif;

		$self->end_controls_section();
		// Section End.
	}

	/**
	 * Get menus
	 */
	public static function get_menus() {
		$menus = wp_get_nav_menus();

		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->term_id ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Get taxonomies
	 */
	public static function get_taxonomies() {
		$taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );

		$options = [];
		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	/**
	 * Get post types
	 */
	public static function get_post_types() {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );

		$options = [];
		foreach ( $post_types as $post_type ) {
			$options[ $post_type->name ] = $post_type->label;
		}

		return $options;
	}

}
