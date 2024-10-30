<?php
/**
 * Blockquote Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use BlocksMonster\Elementor\Helpers;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Blockquote Block
 *
 * @since 1.0.0
 */
class Blockquote extends Widget_Base {

	/**
	 * Constructor
	 *
	 * @param array $data The data of the block.
	 * @param array $args The arguments of the block.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		// Block.
		wp_enqueue_style( 'blocks_monster-el-blockquote', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/blockquote/style.css', [], BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'blocks_monster-el-blockquote' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'blocks_monster-blockquote';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Blockquote', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-blockquote';
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
		return Helpers::get_keywords( [ 'blockquote', 'quote' ] );
	}

	/**
	 * Render
	 */
	public function render() {
		$blockquote = $this->get_settings_for_display( 'blockquote' );
		$author     = $this->get_settings_for_display( 'author' );
		$with_icon  = 'yes' === $this->get_settings_for_display( 'show_icon' ) ? 'with-icon' : '';

		?>
		<div class="blocks_monster-block blocks_monster-blockquote">
			<div class="blocks_monster-block-content">
				<div class="blocks_monster-blockquote-box">
					<div class="blocks_monster-blockquote-message"><?php echo wp_kses_post( $blockquote ); ?></div>
					<div class="blocks_monster-blockquote-author"><?php echo esc_html( $author ); ?></div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {

		/**
		 * Group: Blockquote Section
		 */
		$this->start_controls_section(
			'blockquote_section',
			[
				'label' => esc_html__( 'Blockquote', 'blocks-monster' ),
			]
		);

		$this->add_control(
			'blockquote',
			[
				'label'   => esc_html__( 'Blockquote', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '"Top improve is to change; to be perfect is to change often."',
				'rows'    => 10,
			]
		);

		$this->add_control(
			'author',
			[
				'label'   => esc_html__( 'Author', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '— WINSTON CHURCHILL',
			]
		);

		$this->end_controls_section();

		// Style.
        // phpcs:disable
		Helpers::register_style_section( $this, 'Quote Box', '.blocks_monster-block-content', [
            'typography' => false,
        ] );

		Helpers::register_style_section( $this, 'Message Box', '.blocks_monster-blockquote-box', [
            'typography'        => false,
            'text_align'        => false,
            'normal_text_color' => false,
        ] );
    
		Helpers::register_style_section( $this, 'Quote', '.blocks_monster-blockquote-message', [
            'typography'        => false,
            'text_align'        => false,
            'normal_text_color' => false,
        ] );

		Helpers::register_style_section( $this, 'Author', '.blocks_monster-blockquote-author' );
        // phpcs:enable

	}

}
