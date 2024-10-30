<?php
/**
 * Copy to Clipboard class.
 *
 * @since      1.5.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster\Gutenberg\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Copy to Clipboard class.
 */
class Copy_to_Clipboard {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the block.
	 */
	public function init() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'render_callback'    => [ $this, 'render' ],
			)
		);
	}

	/**
	 * Render the block.
	 * 
	 * @param array $attributes Block attributes.
	 */
	public function render( $attributes = [], $content = '', $block = null ) {
		// Post content.
		$post_id = $block->context['postId'] ?? null;
		$post_content = $post_id ? get_post_field( 'post_content', $post_id ) : null;

		// Block attributes.
		$button_text = $attributes['buttonText'] ?? esc_html__( 'Copy to Clipboard', 'blocks-monster' );
		$content     = $attributes['content'] ? $attributes['content'] : $post_content;
		$button_text_copied = $attributes['buttonTextCopied'] ?? esc_html__( 'Copied!', 'blocks-monster' );
		$wrapper_attributes = get_block_wrapper_attributes(
			[
				'data-copied-text' => $button_text_copied,
			]
		);
		
		ob_start();
		?>
		<span class="bm-copy-to-clipboard-wrap">
			<button <?php echo $wrapper_attributes; ?>>
				<?php echo esc_html( $button_text ); ?>
			</button>
			<textarea class="bm-copy-to-clipboard-textarea" readonly><?php echo $content; ?></textarea>
		</span>
		<?php
		return ob_get_clean();
	}

}

