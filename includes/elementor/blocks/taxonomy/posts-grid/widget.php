<?php
/**
 * Taxonomy Posts Grid Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block\Taxonomy;

use BlocksMonster\Elementor\Helpers;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Taxonomy Posts Grid Block
 *
 * @since 1.0.0
 */
class Posts_Grid extends Widget_Base {

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
		wp_enqueue_style( 'bm-el-tax-post-grid', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/taxonomy/posts-grid/style.css', array(), BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return array( 'bm-el-tax-post-grid' );
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-tax-posts-grid';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Taxonomy Posts Grid', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
		return Helpers::get_keywords( array( 'taxonomy', 'posts', 'grid' ) );
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		// Select Taxonomy.
		$this->start_controls_section(
			'section_taxonomy',
			array(
				'label' => esc_html__( 'Taxonomy', 'blocks-monster' ),
			)
		);

		$this->add_control(
			'taxonomy',
			array(
				'label'       => esc_html__( 'Taxonomy', 'blocks-monster' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Helpers::get_taxonomies(),
				'default'     => 'category',
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		// Select Post Type.
		$this->start_controls_section(
			'section_post_type',
			array(
				'label' => esc_html__( 'Post Type', 'blocks-monster' ),
			)
		);

		$this->add_control(
			'post_type',
			array(
				'label'       => esc_html__( 'Post Type', 'blocks-monster' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => Helpers::get_post_types(),
				'default'     => 'post',
				'label_block' => true,
			)
		);

		// Show number of posts.
		$this->add_control(
			'posts_per_page',
			array(
				'label'       => esc_html__( 'Number of Posts', 'blocks-monster' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 6,
				'label_block' => true,
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render
	 */
	public function render() {
		$taxonomy 	= $this->get_settings( 'taxonomy' );
		$post_type  = $this->get_settings( 'post_type' );
		$posts_per_page = $this->get_settings( 'posts_per_page' );
		if ( ! $taxonomy || ! $post_type ) {
			return;
		}

		// Cache.
		$cache_key = 'bm-tax-posts-grid-' . $taxonomy . '-' . $post_type . '-' . $posts_per_page;
		$stored = get_transient( $cache_key );
		if ( empty( $stored ) ) {
			$terms = get_terms( $taxonomy );
			if ( ! $terms ) {
				return;
			}

			$stored = [];

			foreach ( $terms as $term ) {
				$term_posts = (array) get_posts(
					array(
						'post_type'      => $post_type,
						'posts_per_page' => $posts_per_page,
						'tax_query'      => array(
							array(
								'taxonomy' => $taxonomy,
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
					)
				);

				if ( ! $term_posts ) {
					continue;
				}

				$term->posts = $term_posts;
				$stored[] 	 = $term;
			}

			// Set transient.
			set_transient( $cache_key, $stored, WEEK_IN_SECONDS );
		}

		if ( empty( $stored ) ) {
			return;
		}

		?>
		<div class="bm-tax-post-grid">
			<?php foreach ( $stored as $term ) : ?>
				<div class="bm-tax-post-grid-item">
					<h2>
						<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
							<?php echo esc_html( $term->name ); ?>
						</a>
					</h2>
					<ul>
						<?php foreach ( $term->posts as $term_post ) : ?>
							<li>
								<div class="bm-tax-post-grid-item-content">
									<?php echo wp_kses_post( $term_post->post_content ); ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

}
