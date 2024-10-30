<?php
/**
 * Pricing Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use WP_Query;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Pricing
 *
 * @since 1.0.0
 */
class Pricing extends Widget_Base {

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

		// Block.
		wp_enqueue_style( 'bm-el-pricing', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/pricing/style.css', [], BLOCKS_MONSTER_VER, 'all' );
		wp_enqueue_script( 'bm-el-pricing', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/pricing/script.js', [ 'jquery' ], BLOCKS_MONSTER_VER, true );

	}

	/**
	 * Get script dependencies
	 */
	public function get_script_depends() {
		return [ 'bm-el-pricing' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'bm-el-pricing' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-pricing';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Pricing', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-price-table';
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
		return [ 'pricing', 'price', 'table', 'offer', 'blocks monster' ];
	}

	/**
	 * Render
	 */
	public function render() {
		$plans = $this->get_settings_for_display( 'plans' );

		if ( empty( $plans ) ) {
			return;
		}

		$toggle_highlight = $this->get_settings_for_display( 'toggle_highlight' );
		$toggle_buttons   = $this->get_settings_for_display( 'toggle_buttons' );

		$active_index = 0;
		foreach ( $toggle_buttons as $current_index => $toggle_button ) {
			if ( 'yes' === $toggle_button['is_active'] ) {
				$active_index = $current_index;
				break;
			}
		}

		$active = 'bm-pricing__active-' . $active_index;

		?>
		<div class="bm-pricing <?php echo esc_attr( $active ); ?>">

			<div class='bm-pricing-toggle'>
				<div class='bm-pricing__toggle-text'><?php echo wp_kses_post( $toggle_highlight ); ?></div>
				<div class='bm-pricing__toggle-btns'>
					<?php foreach ( $toggle_buttons as $toggle_button ) { ?>
						<div class='bm-pricing__toggle-btn '><?php echo wp_kses_post( $toggle_button['text'] ); ?></div>
					<?php } ?>
				</div>
			</div>

			<div class="bm-pricing__plans">
				<?php

				// Generate the plans markup.
				foreach ( $plans as $plan ) {
					$name            = isset( $plan['name'] ) ? $plan['name'] : '';
					$prices          = isset( $plan['prices'] ) ? $plan['prices'] : [];
					$features        = isset( $plan['features'] ) ? $plan['features'] : [];
					$multiple_prices = ( count( $prices ) > 1 ) ? 'bm-pricing__plan--multi-prices' : 'bm-pricing__plan--single-price';
					?>
					<div class="bm-pricing__plan <?php echo esc_attr( $multiple_prices ); ?>">
						<div class="bm-pricing__plan-name">
							<?php echo wp_kses_post( $name ); ?>
						</div>
						<div class="bm-pricing__plan-prices">
							<?php
							foreach ( $prices as $price ) {
								$description      = isset( $price['description'] ) ? $price['description'] : '';
								$price_value      = isset( $price['price'] ) ? $price['price'] : '';
								$prefix           = isset( $price['prefix'] ) ? $price['prefix'] : '';
								$offer_price      = isset( $price['offer_price'] ) ? $price['offer_price'] : '';
								$offer_prefix     = isset( $price['offer_prefix'] ) ? $price['offer_prefix'] : '';
								$save             = isset( $price['save'] ) ? $price['save'] : '';
								$button           = isset( $price['button'] ) ? $price['button'] : '';
								$link             = isset( $price['link'] ) && isset( $price['link']['url'] ) ? $price['link']['url'] : '';
								$target           = isset( $price['target'] ) ? $price['target'] : '';
								$have_offer_price = ( ! empty( $offer_price ) ) ? 'bm-pricing__plan-have-offer-price' : '';
								?>
							<div class="bm-pricing__plan-price-box <?php echo esc_attr( $have_offer_price ); ?>">
								<div class="bm-pricing__plan-description"><?php echo wp_kses_post( $description ); ?></div>
								<div class="bm-pricing__plan-price">
									<div class="bm-pricing__plan-price-value"><?php echo wp_kses_post( $price_value ); ?></div>
									<div class="bm-pricing__plan-offer-price-value"><?php echo wp_kses_post( $offer_price ); ?></div>
									<div class="bm-pricing__plan-prefix"><?php echo wp_kses_post( $prefix ); ?></div>
								</div>
								<div class='bm-pricing__plan-save'><?php echo wp_kses_post( $save ); ?></div>
								<div class='bm-pricing__plan-button-box'>
									<a class="bm-pricing__plan-button" href="<?php echo esc_attr( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
										<?php echo esc_html( $button ); ?>
									</a>
								</div>
							</div>
							<?php } ?>
						</div>
						<div class="bm-pricing__plan-features">
							<?php
							foreach ( $features as $feature ) {
								$icon        = $feature['icon'];
								$title       = $feature['title'];
								$description = $feature['description'];
								?>
								<div class='bm-pricing__plan-feature'>
									<span class='bm-pricing__plan-feature-icon'><i class="<?php echo esc_attr( $icon ); ?>"></i></span>
									<div class='bm-pricing__plan-feature-title'><?php echo esc_html( $title ); ?></div>
									<div class='bm-pricing__plan-feature-description'><?php echo esc_html( $description ); ?></div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				}

				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {

		// Toggle button section.
		$this->start_controls_section(
			'toggle_buttons_section',
			[
				'label' => esc_html__( 'Toggle Button', 'blocks-monster' ),
			]
		);

		// Toggle highlight text.
		$this->add_control(
			'toggle_highlight',
			[
				'label'       => esc_html__( 'Toggle Highlight Text', 'blocks-monster' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Save 15% on yearly plan!', 'blocks-monster' ),
			]
		);

		// Repeater toggle buttons with just button text.
		$this->add_control(
			'toggle_buttons',
			[
				'label'       => esc_html__( 'Toggle Buttons', 'blocks-monster' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => [
					[
						'name'        => 'text',
						'label'       => esc_html__( 'Text', 'blocks-monster' ),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
					],
					[
						'name'         => 'is_active',
						'label'        => esc_html__( 'Active', 'blocks-monster' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_block'  => true,
						'return_value' => 'no',
					],
				],
				'default'     => [
					[
						'text'      => esc_html__( 'Annual', 'blocks-monster' ),
						'is_active' => 'yes',
					],
					[
						'text' => esc_html__( 'Lifetime', 'blocks-monster' ),
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pricing_content',
			[
				'label' => esc_html__( 'Pricing Plans', 'blocks-monster' ),
			]
		);

		// Pricing plans.
		$this->add_control(
			'plans',
			[
				'label'       => esc_html__( 'Pricing Plans', 'blocks-monster' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => [
					[
						'name'        => 'name',
						'label'       => esc_html__( 'Plan name', 'blocks-monster' ),
						'type'        => Controls_Manager::TEXT,
						'label_block' => true,
					],
					[
						'name'   => 'prices',
						'label'  => esc_html__( 'Plan Prices', 'blocks-monster' ),
						'type'   => Controls_Manager::REPEATER,
						'fields' => [
							[
								'name'        => 'description',
								'label'       => esc_html__( 'Description', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'price',
								'label'       => esc_html__( 'Price', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'prefix',
								'label'       => esc_html__( 'Price Prefix', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'offer_price',
								'label'       => esc_html__( 'Offer Price', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'offer_prefix',
								'label'       => esc_html__( 'Offer Price Prefix', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'save',
								'label'       => esc_html__( 'Save', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'button',
								'label'       => esc_html__( 'Button', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'link',
								'label'       => esc_html__( 'Link', 'blocks-monster' ),
								'type'        => Controls_Manager::URL,
								'label_block' => true,
							],
							[
								'name'    => 'target',
								'label'   => esc_html__( 'Target', 'blocks-monster' ),
								'type'    => Controls_Manager::SELECT,
								'options' => [
									'_blank' => esc_html__( 'New tab', 'blocks-monster' ),
									'_self'  => esc_html__( 'Same tab', 'blocks-monster' ),
								],
								'default' => '_blank',
							],
						],
					],
					[
						'name'   => 'features',
						'label'  => esc_html__( 'Features', 'blocks-monster' ),
						'type'   => Controls_Manager::REPEATER,
						'fields' => [
							[
								'name'        => 'icon',
								'label'       => esc_html__( 'Icon', 'blocks-monster' ),
								'type'        => Controls_Manager::ICON,
								'label_block' => true,
							],
							[
								'name'        => 'title',
								'label'       => esc_html__( 'Title', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXT,
								'label_block' => true,
							],
							[
								'name'        => 'description',
								'label'       => esc_html__( 'Description', 'blocks-monster' ),
								'type'        => Controls_Manager::TEXTAREA,
								'label_block' => true,
							],
						],
					],
				],
				'default'     => [
					[
						'name'     => esc_html__( 'Free', 'blocks-monster' ),
						'prices'   => [
							[
								'description' => esc_html__( 'Best for personal use', 'blocks-monster' ),
								'price'       => esc_html__( '$0', 'blocks-monster' ),
								'prefix'      => esc_html__( '/month', 'blocks-monster' ),
								'button'      => esc_html__( 'Get Started', 'blocks-monster' ),
								'link'        => [
									'url'         => '#',
									'is_external' => 'on',
								],
							],
						],
						'features' => [
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Task Management', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Project Planning', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-window-close',
								'title' => esc_html__( 'Team Collaboration', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-window-close',
								'title' => esc_html__( 'Notifications and Reminders', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-window-close',
								'title' => esc_html__( 'What you get', 'blocks-monster' ),
							],
						],
					],
					[
						'name'     => 'Single Site',
						'prices'   => [
							[
								'description'  => esc_html__( 'Lifetime License/Single Site', 'blocks-monster' ),
								'price'        => esc_html__( '$259', 'blocks-monster' ),
								'prefix'       => esc_html__( '/Lifetime', 'blocks-monster' ),
								'offer_price'  => esc_html__( '$149', 'blocks-monster' ),
								'offer_prefix' => esc_html__( '/Lifetime', 'blocks-monster' ),
								'save'         => esc_html__( 'You save 40%', 'blocks-monster' ),
								'button'       => esc_html__( 'Get Started', 'blocks-monster' ),
								'link'         => [
									'url'         => '#',
									'is_external' => 'on',
								],
							],
							[
								'description'  => esc_html__( '1 Year License/Single Site', 'blocks-monster' ),
								'price'        => esc_html__( '$39', 'blocks-monster' ),
								'prefix'       => esc_html__( '/1 Year', 'blocks-monster' ),
								'offer_price'  => esc_html__( '$29', 'blocks-monster' ),
								'offer_prefix' => esc_html__( '/1 Year', 'blocks-monster' ),
								'save'         => esc_html__( 'You save 20%', 'blocks-monster' ),
								'button'       => esc_html__( 'Get Started', 'blocks-monster' ),
								'link'         => [
									'url'         => '#',
									'is_external' => 'on',
								],
							],
						],
						'features' => [
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Task Management', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Project Planning', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Team Collaboration', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Notifications and Reminders', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-window-close',
								'title' => esc_html__( 'What you get', 'blocks-monster' ),
							],
						],
					],
					[
						'name'     => 'Unlimited Site',
						'prices'   => [
							[
								'description'  => esc_html__( 'Lifetime License/Unlimited Sites', 'blocks-monster' ),
								'price'        => esc_html__( '$449', 'blocks-monster' ),
								'prefix'       => esc_html__( '/Lifetime License', 'blocks-monster' ),
								'offer_price'  => esc_html__( '$249', 'blocks-monster' ),
								'offer_prefix' => esc_html__( '/Lifetime License', 'blocks-monster' ),
								'save'         => esc_html__( 'You save 44%', 'blocks-monster' ),
								'button'       => esc_html__( 'Get Started', 'blocks-monster' ),
								'link'         => [
									'url'         => '#',
									'is_external' => 'on',
								],
							],
							[
								'description'  => esc_html__( 'Annual License/Unlimited Sites', 'blocks-monster' ),
								'price'        => esc_html__( '$149', 'blocks-monster' ),
								'prefix'       => esc_html__( '/1 Year License', 'blocks-monster' ),
								'offer_price'  => esc_html__( '$119', 'blocks-monster' ),
								'offer_prefix' => esc_html__( '/1 Year License', 'blocks-monster' ),
								'save'         => esc_html__( 'You save 20%', 'blocks-monster' ),
								'button'       => esc_html__( 'Get Started', 'blocks-monster' ),
								'link'         => [
									'url'         => '#',
									'is_external' => 'on',
								],
							],
						],
						'features' => [
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Task Management', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Project Planning', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Team Collaboration', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'Notifications and Reminders', 'blocks-monster' ),
							],
							[
								'icon'  => 'fa fa-check',
								'title' => esc_html__( 'What you get', 'blocks-monster' ),
							],
						],
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pricing_style',
			[
				'label' => esc_html__( 'Pricing', 'blocks-monster' ),
			]
		);

		$this->end_controls_section();
	}
}
