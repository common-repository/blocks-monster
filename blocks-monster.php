<?php // @codingStandardsIgnoreLine
/**
 * Blocks Monster Plugin.
 *
 * @package      Blocks Monster
 * @copyright    Copyright (C) 2014-2023, Dev - dev@blocks.monster
 * @link         https://blocks.monster
 * @since        1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Blocks Monster
 * Version:           1.7.0
 * Plugin URI:        https://blocks.monster/blocks-monster
 * Description:       The library of all the blocks for the Elementor blocks.
 * Author:            Blocks Monster
 * Author URI:        https://blocks.monster/
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       blocks-monster
 * Domain Path:       /languages
 */

defined( 'ABSPATH' ) || exit;

/**
 * BlocksMonster class.
 *
 * @class Main class of the plugin.
 */
final class BlocksMonster {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	public $version = '1.7.0';

	/**
	 * The single instance of the class.
	 *
	 * @var BlocksMonster
	 */
	protected static $instance = null;

	/**
	 * Retrieve main BlocksMonster instance.
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @see blocks_monster()
	 * @return BlocksMonster
	 */
	public static function get() {
		if ( is_null( self::$instance ) && ! ( self::$instance instanceof BlocksMonster ) ) {
			self::$instance = new BlocksMonster();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the plugin.
	 */
	private function setup() {
		// Define plugin constants.
		$this->define_constants();

		// Include required files.
		$this->includes();

		// Initialize.
		$this->initialize();

		// Loaded action.
		do_action( 'blocks_monster/loaded' );
	}

	/**
	 * Define the plugin constants.
	 */
	private function define_constants() {
		define( 'BLOCKS_MONSTER_VER', $this->version );
		define( 'BLOCKS_MONSTER_FILE', __FILE__ );
		define( 'BLOCKS_MONSTER_BASE', plugin_basename( BLOCKS_MONSTER_FILE ) );
		define( 'BLOCKS_MONSTER_DIR', plugin_dir_path( BLOCKS_MONSTER_FILE ) );
		define( 'BLOCKS_MONSTER_URI', plugins_url( '/', BLOCKS_MONSTER_FILE ) );
		define( 'BLOCKS_MONSTER_GUTENBERG_DIR', BLOCKS_MONSTER_DIR . 'includes/gutenberg' );
		define( 'BLOCKS_MONSTER_GUTENBERG_URI', BLOCKS_MONSTER_URI . 'includes/gutenberg' );
		define( 'BLOCKS_MONSTER_ELEMENTOR_DIR', BLOCKS_MONSTER_DIR . 'includes/elementor' );
		define( 'BLOCKS_MONSTER_ELEMENTOR_URI', BLOCKS_MONSTER_URI . 'includes/elementor' );
	}

	/**
	 * Include the required files.
	 */
	private function includes() {
		include dirname( __FILE__ ) . '/vendor/autoload.php';
	}

	/**
	 * Initialize the plugin.
	 */
	private function initialize() {
		new BlocksMonster\Elementor();
		new BlocksMonster\Gutenberg();
	}

}

/**
 * Returns the main instance of BlocksMonster to prevent the need to use globals.
 *
 * @return BlocksMonster
 */
function blocks_monster() {
	return BlocksMonster::get();
}

// Start it.
blocks_monster();
