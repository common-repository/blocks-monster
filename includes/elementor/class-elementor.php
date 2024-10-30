<?php
/**
 * Elementor class.
 *
 * @since      1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster;

use BlocksMonster\Elementor\Block\Countdown;
use BlocksMonster\Elementor\Block\Post\Grid;
use BlocksMonster\Elementor\Block\Post_List;
use BlocksMonster\Elementor\Block\Pricing;
use BlocksMonster\Elementor\Block\Table;
use BlocksMonster\Elementor\Block\Blockquote;
use BlocksMonster\Elementor\Block\Logo;
use BlocksMonster\Elementor\Block\Navigation_Menu;
use BlocksMonster\Elementor\Block\Taxonomy\Posts_Grid;
use BlocksMonster\Elementor\Block\Taxonomy\Term_Title;

defined( 'ABSPATH' ) || exit;

/**
 * Page class.
 */
class Elementor {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
	}

	/**
	 * Register category
	 *
	 * @param object $elements_manager Elementor elements manager.
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'blocks-monster',
			array(
				'title' => esc_html__( 'Blocks Monster', 'blocks-monster' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Register widgets
	 *
	 * @param object $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		$widgets_manager->register( new Countdown() );
		$widgets_manager->register( new Grid() );
		$widgets_manager->register( new Post_List() );
		$widgets_manager->register( new Pricing() );
		$widgets_manager->register( new Table() );
		$widgets_manager->register( new Blockquote() );
		$widgets_manager->register( new Logo() );
		$widgets_manager->register( new Navigation_Menu() );
		$widgets_manager->register( new Posts_Grid() );
		$widgets_manager->register( new Term_Title() );
	}
}
