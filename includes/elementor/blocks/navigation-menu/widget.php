<?php
/**
 * Navigation Menu Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use BlocksMonster\Elementor\Helpers;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Navigation Menu Block
 *
 * @since 1.0.0
 */
class Navigation_Menu extends Widget_Base {

	/**
	 * Constructor
	 *
	 * @param array $data The data of the block.
	 * @param array $args The arguments of the block.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		// Block.
		wp_enqueue_style( 'bm-el-navigation-menu', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/navigation-menu/style.css', array(), BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return array( 'bm-el-navigation-menu' );
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-navigation-menu';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Navigation Menu', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
	}

	/**
	 * Get categories
	 */
	public function get_categories() {
		return Helpers::get_categories();
	}

	/**
	 * Get keywords
	 */
	public function get_keywords() {
		return Helpers::get_keywords( array( 'menu', 'navigation', 'nav' ) );
	}

	/**
	 * Render
	 */
	public function render() {
		$nav_menu = $this->get_settings( 'nav_menu' );
		?>
		<div class="bm-block bm-navigation-menu">
			<?php
			if ( ! empty( $nav_menu ) ) {
				wp_nav_menu(
					array(
						'menu' => $nav_menu,
					)
				);
			} else {
				wp_page_menu();
			}
			?>
		</div>
		<?php
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		// Section: Navigation Menu
		$this->start_controls_section(
			'section_navigation_menu',
			array(
				'label' => esc_html__( 'Navigation Menu', 'blocks-monster' ),
			)
		);

		// Select navigation menu
		$this->add_control(
			'nav_menu',
			array(
				'label'   => esc_html__( 'Select Menu', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Helpers::get_menus(),
			)
		);

		// End section
		$this->end_controls_section();

	}

}
