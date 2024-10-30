<?php
/**
 * Apple App Store class.
 *
 * @since      1.5.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster\Gutenberg\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Apple App Store Button class.
 */
class Apple_App_Store {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );
	}

	/**
	 * Enqueue block assets.
	 */
	public function enqueue_block_assets() {
		$block_json = file_get_contents( __DIR__ . '/block.json' );
		$block_json = json_decode( $block_json, true );

		wp_register_script(
			'bm-apple-app-store',
			plugins_url( 'js/index.js', __FILE__ ),
			[
				'wp-block-editor',
				'wp-components',
				'wp-i18n',
			],
			$block_json['version']
		);

		wp_localize_script(
			'bm-apple-app-store',
			'BMAppleAppStore',
			[
				'image_url' => plugins_url( 'images/apple-app-store.png', __FILE__ ),
			]
		);
	}

	/**
	 * Initialize the block.
	 */
	public function init() {
		register_block_type_from_metadata(
			__DIR__,
			[]
		);
	}

}

