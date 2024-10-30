<?php
/**
 * Term Title Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block\Taxonomy;

use BlocksMonster\Elementor\Helpers;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Term Title Block
 *
 * @since 1.0.0
 */
class Term_Title extends Widget_Base {

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
		wp_enqueue_style( 'bm-el-tax-title', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/taxonomy/term-title/style.css', array(), BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return array( 'bm-el-tax-term-title' );
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-tax-term-title';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Term Title', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-post-title';
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
		return Helpers::get_keywords( array( 'taxonomy', 'term', 'title' ) );
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_term_title',
			array(
				'label' => esc_html__( 'Term Title', 'blocks-monster' ),
			)
		);

		$this->add_control(
			'term_id',
			array(
				'label'       => esc_html__( 'Term ID', 'blocks-monster' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter the term ID.', 'blocks-monster' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'hide_term_description',
			array(
				'label'        => esc_html__( 'Hide Term Description', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'blocks-monster' ),
				'label_off'    => esc_html__( 'No', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render
	 */
	public function render() {
		$term_id = $this->get_settings( 'term_id' );
		if ( ! $term_id ) {
			return;
		}

		$term = get_term( $term_id );
		if ( ! $term ) {
			return;
		}

		$term_link = get_term_link( $term );
		$hide_term_description = $this->get_settings( 'hide_term_description' );
		?>
		<div class="bm-el-tax-term-title">
			<h1 class="bm-el-tax-term-title__value">
				<a href="<?php echo esc_url( $term_link ); ?>">
					<?php echo esc_html( $term->name ); ?>
				</a>
			</h1>
			<?php if ( 'yes' === $hide_term_description ) : ?>
				<div class="bm-el-tax-term-title__description">
					<?php echo wp_kses_post( $term->description ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

}
