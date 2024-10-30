<?php
/**
 * Gutenberg class.
 *
 * @since      1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster;

use WP_HTML_Tag_Processor;
use BlocksMonster\Gutenberg\Blocks\Terms_List;
use BlocksMonster\Gutenberg\Blocks\Term_Title;
use BlocksMonster\Gutenberg\Blocks\Posts_Query;
use BlocksMonster\Gutenberg\Blocks\Copy_to_Clipboard;
use BlocksMonster\Gutenberg\Blocks\Social_Share;
use BlocksMonster\Gutenberg\Blocks\Google_Play_Store;
use BlocksMonster\Gutenberg\Blocks\Apple_App_Store;

defined( 'ABSPATH' ) || exit;

/**
 * Gutenberg class.
 */
class Gutenberg {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'block_categories_all', [ $this, 'register_category' ], 10, 2 );

		$this->register_blocks();

		// Register block assets.
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );

		// Extend blocks.
		add_filter( 'block_type_metadata', [ $this, 'extend_block_type_metadata' ] );
		add_filter( 'render_block', [ $this, 'extend_render_block' ], 20, 2 );
		add_filter( 'render_block', [ $this, 'render_post_content' ], 20, 2 );
	}

	/**
	 * Register blocks
	 */
	public function register_blocks() {
		new Terms_List();
		new Term_Title();
		new Posts_Query();
		new Copy_to_Clipboard();
		new Social_Share();
		new Google_Play_Store();
		new Apple_App_Store();
	}

	/**
	 * Extend render block.
	 *
	 * @param string $block_content Block content.
	 * @param array  $block         Block data.
	 *
	 * @return string
	 */
	public function extend_render_block( $block_content, $block ) {
		$data = $block['attrs']['bm'] ?? [];
		if ( ! isset( $data ) || ! is_array( $data ) || empty( $data ) ) {
			return $block_content;
		}

		$processor = new WP_HTML_Tag_Processor( $block_content );

		if ( $processor->next_tag() ) {
			$responsive = isset( $data['responsive'] ) ? $data['responsive'] : '';
			if ( $responsive ) {
				if ( isset( $responsive['desktop'] ) && $responsive['desktop'] ) {
					$processor->add_class( 'bm-hide-on-desktop' );
				}
				if ( isset( $responsive['tablet'] ) && $responsive['tablet'] ) {
					$processor->add_class( 'bm-hide-on-tablet' );
				}
				if ( isset( $responsive['mobile'] ) && $responsive['mobile'] ) {
					$processor->add_class( 'bm-hide-on-mobile' );
				}
			}

			// Add position attribute.
			$position_type = isset( $data['position'] ) && isset( $data['position']['type'] ) ? $data['position']['type'] : '';
			if ( $position_type ) {
				$processor->add_class( 'bm-position-' . $position_type );
			}

			// Add position values.
			$position_value = isset( $data['position'] ) && isset( $data['position']['value'] ) ? $data['position']['value'] : '';
			if ( $position_value ) {
				$existing_style = $processor->get_attribute( 'style' );
				if ( ! empty( $existing_style ) ) {
					$updated_style = $existing_style;
					if ( ! str_ends_with( $existing_style, ';' ) ) {
						$updated_style .= ';';
					}
				}

				$css  = isset( $position_value['top'] ) ? 'top: ' . $position_value['top'] . 'px;' : '';
				$css .= isset( $position_value['right'] ) ? 'right: ' . $position_value['right'] . 'px;' : '';
				$css .= isset( $position_value['bottom'] ) ? 'bottom: ' . $position_value['bottom'] . 'px;' : '';
				$css .= isset( $position_value['left'] ) ? 'left: ' . $position_value['left'] . 'px;' : '';

				$updated_style .= $css;
				$processor->set_attribute( 'style', $updated_style );
			}
		}

		return $processor->get_updated_html();
	}

	/**
	 * Render post content.
	 *
	 * @param string $block_content Block content.
	 * @param array  $block         Block data.
	 *
	 * @return string
	 */
	public function render_post_content( $block_content, $block ) {
		if ( isset( $block['attrs']['addLinkToBlock'] ) && $block['attrs']['addLinkToBlock'] ) {
			$link = get_permalink( $block['context']['postId'] );
			if ( ! $link ) {
				return $block_content;
			}

			$block_content = sprintf(
				'<a href="%s" class="bm-post-content-link">%s</a>',
				esc_url( $link ),
				$block_content
			);
		}

		return $block_content;
	}

	/**
	 * Extend blocks metadata.
	 *
	 * @param array  $metadata Block metadata.
	 * @return array
	 */
	public function extend_block_type_metadata( $metadata = [] ) {
		$metadata['attributes']['bm']['type'] = 'object';
		$metadata['attributes']['bm']['default'] = [
			'responsive' => [
				'desktop' => false,
				'tablet'  => false,
				'mobile'  => false,
			],
			'addLinkToBlock' => false,
			'positionType' => '',
			'positionValues' => '',
		];

		return $metadata;
	}

	/**
	 * Register block assets.
	 */
	public function enqueue_block_assets() {
		wp_enqueue_script( 'blocks-monster-core-variations', BLOCKS_MONSTER_GUTENBERG_URI . '/assets/js/core-variations.js', [ 'wp-element', 'wp-hooks' ], BLOCKS_MONSTER_VER, true );
		wp_enqueue_script( 'blocks-monster-extend-blocks', BLOCKS_MONSTER_GUTENBERG_URI . '/assets/js/extend-blocks.js', [ 'wp-i18n', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-hooks' ], BLOCKS_MONSTER_VER, true );

		// Styles.
		wp_enqueue_style( 'blocks-monster-extend-blocks', BLOCKS_MONSTER_GUTENBERG_URI . '/assets/css/extend-blocks.css', [], BLOCKS_MONSTER_VER, 'all' );
	}

	/**
	 * Register category
	 *
	 * @param array  $categories Block categories.
	 * @param object $post       Post object.
	 * @return array
	 */
	public function register_category( $categories, $post ) {
		$categories[] = [
			'slug'  => 'blocks-monster',
			'title' => esc_html__( 'Blocks Monster', 'blocks-monster' ),
			'icon'  => 'wordpress',
		];
		return $categories;
	}
}
