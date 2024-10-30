<?php
/**
 * Logo Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use BlocksMonster\Elementor\Helpers;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Logo Block
 *
 * @since 1.0.0
 */
class Logo extends Widget_Base {

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
		wp_enqueue_style( 'bm-el-blockquote', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/logo/style.css', array(), BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return array( 'bm-el-logo' );
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-logo';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Logo', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-logo';
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
		return Helpers::get_keywords( array( 'logo', 'brand', 'image' ) );
	}

	/**
	 * Render
	 */
	public function render() {
		$display_logo    = $this->get_settings( 'display_logo' );
		$display_title   = $this->get_settings( 'display_title' );
		$display_tagline = $this->get_settings( 'display_tagline' );
		?>
		<div class="bm-block bm-logo">
			<?php
			if ( has_custom_logo() && 'yes' === $display_logo ) {
				?>
				<div class="site-logo">
					<?php the_custom_logo(); ?>
				</div>
				<?php
			}
			?>
			<?php if ( 'yes' === $display_title ) : ?>
				<div class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></div>
			<?php endif; ?>
			<?php if ( 'yes' === $display_tagline ) : ?>
				<div class="site-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_logo',
			array(
				'label' => esc_html__( 'Logo', 'blocks-monster' ),
			)
		);

		// Display site logo.
		$this->add_control(
			'display_logo',
			array(
				'label'        => esc_html__( 'Display Site Logo', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		// Display site title.
		$this->add_control(
			'display_title',
			array(
				'label'        => esc_html__( 'Display Site Title', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		// Display site tagline.
		$this->add_control(
			'display_tagline',
			array(
				'label'        => esc_html__( 'Display Site Tagline', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'blocks-monster' ),
				'label_off'    => esc_html__( 'Hide', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

}
