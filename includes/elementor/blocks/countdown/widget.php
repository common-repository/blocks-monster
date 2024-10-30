<?php
/**
 * Countdown Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Countdown
 *
 * @since 1.0.0
 */
class Countdown extends Widget_Base {

	/**
	 * Constructor
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget args.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		wp_register_script( 'blocks_monster-el-countdown-jquery', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/countdown/jquery.countdown.js', [ 'jquery' ], BLOCKS_MONSTER_VER, true );

		// Block.
		wp_enqueue_style( 'blocks_monster-el-countdown', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/countdown/style.css', [], BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get script dependencies
	 */
	public function get_script_depends() {
		return [ 'blocks_monster-el-countdown-jquery' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'blocks_monster-el-countdown' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'blocks_monster-countdown';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Countdown', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'blocks_monster-icon blocks_monster-icon-countdown';
	}

	/**
	 * Get categories
	 */
	public function get_categories() {
		return [ 'blocks-monster' ];
	}

	/**
	 * Get keywords
	 */
	public function get_keywords() {
		return [ 'countdown', 'offer', 'timer' ];
	}

	/**
	 * Render
	 */
	public function render() {
		$timer = $this->get_settings_for_display( 'timer' );
		if ( ! $timer ) {
			return;
		}

		?>
		<div class="blocks_monster-countdown">
			<ul class="blocks_monster-countdown-timer" data-countdown="<?php echo esc_attr( $timer ); ?>"></ul>
		</div>
		<?php
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		// Countdown timer.
		$this->start_controls_section(
			'timer_section',
			[
				'label' => esc_html__( 'Countdown Time', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Current WordPress website time.
		$this->add_control(
			'timer',
			[
				'label'       => esc_html__( 'Countdown Time', 'blocks-monster' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => wp_date( 'Y/m/d H:i', strtotime( '+7 days', time() ) ),
				'placeholder' => esc_html__( 'Enter your countdown time', 'blocks-monster' ),
			]
		);

		// Add hide/show toggle control for 'days', 'hours', 'minutes', 'seconds'.
		$this->add_control(
			'show_days',
			[
				'label'        => esc_html__( 'Days', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'        => esc_html__( 'Hours', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label'        => esc_html__( 'Minutes', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[
				'label'        => esc_html__( 'Seconds', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		// Add the gap between each number.
		$this->add_control(
			'gap',
			[
				'label'     => esc_html__( 'Gap', 'blocks-monster' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'min'       => 0,
				'max'       => 100,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-countdown-timer' => 'gap: {{VALUE}}px;',
				],
			]
		);

		// Toggle Vertical number and label alignment.
		$this->add_control(
			'number_direction',
			[
				'label'        => esc_html__( 'Number Direction', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Vertical', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Horizontal', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Style
		 */
		$this->start_controls_section(
			'box_style_section',
			[
				'label' => esc_html__( 'Style', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_color',
			[
				'label'     => esc_html__( 'Box Text Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'white',
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-countdown-timer > li' => 'color: {{VALUE}};',
				],
			]
		);

		// Box.
		$this->add_control(
			'box_bg_color',
			[
				'label'     => esc_html__( 'Box Background Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'blue',
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-countdown-timer > li' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Border.
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'box_border',
				'label'    => esc_html__( 'Border', 'blocks-monster' ),
				'selector' => '{{WRAPPER}} .blocks_monster-countdown-timer > li',
			]
		);

		// Border radius.
		$this->add_responsive_control(
			'box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-countdown-timer > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Number Style
		 */
		$this->start_controls_section(
			'number_style_section',
			[
				'label' => esc_html__( 'Number Style', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'label'    => esc_html__( 'Typography', 'blocks-monster' ),
				'selector' => '{{WRAPPER}} .blocks_monster-countdown-timer .count',
				'default'  => [
					'font-weight' => 'bold',
					'line-height' => '1em',
					'font-size'   => '16px',
				],
			]
		);

		// Margin.
		$this->add_responsive_control(
			'number_margin',
			[
				'label'      => esc_html__( 'Margin', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-countdown-timer .count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '2px',
					'left'   => '0',
					'unit'   => 'px',
				],
			]
		);

		// Padding.
		$this->add_responsive_control(
			'number_padding',
			[
				'label'      => esc_html__( 'Padding', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-countdown-timer .count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Label Style
		 */
		$this->start_controls_section(
			'label_style_section',
			[
				'label' => esc_html__( 'Label Style', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => esc_html__( 'Typography', 'blocks-monster' ),
				'selector' => '{{WRAPPER}} .blocks_monster-countdown-timer span:last-child',
				'default'  => [
					'line-height' => '1em',
					'font-size'   => '12px',
				],
			]
		);

		// Color.
		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Label Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-countdown-timer span:last-child' => 'color: {{VALUE}};',
				],
			]
		);

		// Background color.
		$this->add_control(
			'label_bg_color',
			[
				'label'     => esc_html__( 'Label Background Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-countdown-timer span:last-child' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Margin.
		$this->add_responsive_control(
			'label_margin',
			[
				'label'      => esc_html__( 'Margin', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-countdown-timer span:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Padding.
		$this->add_responsive_control(
			'label_padding',
			[
				'label'      => esc_html__( 'Padding', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-countdown-timer span:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}
}
