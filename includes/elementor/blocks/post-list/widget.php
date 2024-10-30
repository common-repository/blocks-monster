<?php
/**
 * Post List Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block;

use WP_Query;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use BlocksMonster\Elementor\Helpers;

/**
 * Post List
 *
 * @since 1.0.0
 */
class Post_List extends Widget_Base {

	/**
	 * Constructor
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget args.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		// Block.
		wp_enqueue_style( 'bm-el-post-list', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/post-list/style.css', [], BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'bm-el-post-list' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'bm-post-list';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Post List', 'blocks-monster' );
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
		return [ 'blocks-monster' ];
	}

	/**
	 * Get keywords
	 */
	public function get_keywords() {
		return [ 'post', 'list' ];
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Post Type', 'blocks-monster' ),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => Helpers::get_post_types(),
			]
		);

		$this->add_control(
			'taxonomy',
			[
				'label'   => esc_html__( 'Taxonomy', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'category',
				'options' => Helpers::get_taxonomies(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'blocks-monster' ),
			]
		);

		$this->add_control(
			'posts_offset',
			[
				'label'   => esc_html__( 'Posts Offset', 'blocks-monster' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->add_control(
			'posts__in',
			[
				'label'   => esc_html__( 'Post Includes', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'posts__not_in',
			[
				'label'   => esc_html__( 'Post Excludes', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'terms__in',
			[
				'label'   => esc_html__( 'Term Includes', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'terms__not_in',
			[
				'label'   => esc_html__( 'Term Excludes', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'blocks-monster' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Date', 'blocks-monster' ),
					'title'         => esc_html__( 'Title', 'blocks-monster' ),
					'modified'      => esc_html__( 'Modified', 'blocks-monster' ),
					'rand'          => esc_html__( 'Random', 'blocks-monster' ),
					'comment_count' => esc_html__( 'Comment Count', 'blocks-monster' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'ASC', 'blocks-monster' ),
					'desc' => esc_html__( 'DESC', 'blocks-monster' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hide_title',
			[
				'label'        => esc_html__( 'Hide Title', 'blocks-monster' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'blocks-monster' ),
				'label_off'    => esc_html__( 'No', 'blocks-monster' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render
	 */
	public function render() {
		$hide_title = $this->get_settings( 'hide_title' );
		$post_type  = $this->get_settings( 'post_type' );
		$hide_copy_button = $this->get_settings( 'hide_copy_button' );

		$query_args = [
			'post_type'      => $post_type,
			'posts_per_page' => $this->get_settings( 'posts_per_page' ),
			'orderby'        => $this->get_settings( 'orderby' ),
			'order'          => $this->get_settings( 'order' ),
		];

		// Taxonomy.
		$taxonomy = $this->get_settings( 'taxonomy' );
		if ( $taxonomy ) {
			$query_args['tax_query'] = [
				[
					'taxonomy' => $this->get_settings( 'taxonomy' ),
					'field'    => 'term_id',
					'terms'    => $this->get_settings( 'terms__in' ),
					'operator' => 'IN',
				],
			];
		}

		// Include terms.
		$terms_in = $this->get_settings( 'terms__in' );
		if ( $terms_in ) {
			$query_args['tax_query'][0]['operator'] = 'IN';
			$query_args['tax_query'][0]['terms']    = explode( ',', $terms_in );
		}

		// Exclude terms.
		if ( $this->get_settings( 'terms__not_in' ) ) {
			$query_args['tax_query'][0]['operator'] = 'NOT IN';
			$query_args['tax_query'][0]['terms']    = explode( ',', $this->get_settings( 'terms__not_in' ) );
		}

		// Offset.
		if ( $this->get_settings( 'posts_offset' ) ) {
			$query_args['offset'] = $this->get_settings( 'posts_offset' );
		}

		// Include posts.
		if ( $this->get_settings( 'posts__in' ) ) {
			$query_args['post__in'] = explode( ',', $this->get_settings( 'posts__in' ) );
		}

		// Exclude posts.
		if ( $this->get_settings( 'posts__not_in' ) ) {
			$query_args['post__not_in'] = explode( ',', $this->get_settings( 'posts__not_in' ) );
		}

		// Query.
		$query = new WP_Query( $query_args );
		if ( ! $query->have_posts() ) {
			return;
		}

		$term_names = '';
		if ( $terms_in ) {
			$term_ids  = explode( ',', $terms_in );
			$term = get_term( $term_ids[0], $taxonomy );
			$term_link = get_term_link( $term );
			$terms = get_terms( $taxonomy, [ 'include' => $term_ids ] );
			if ( ! is_wp_error( $terms ) ) {
				$term_names = wp_list_pluck( $terms, 'name' );
				$term_names = implode( ', ', $term_names );
			}
		}
		?>
		<div class="bm-post-list">
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div class="bm-post-list__item">
					<?php if ( ! $hide_title ) : ?>
						<h2 class="bm-post-list__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
					<?php endif; ?>
					<div class="bm-post-list__excerpt">
						<?php the_content(); ?>
					</div>
				</div>
				<?php
				wp_reset_postdata();
			}
			?>

			<?php if ( ! empty( $term_names ) ) : ?>
				<div class="bm-post-list__see-all">
					<a href="<?php echo $term_link; ?>">
						<?php echo sprintf( esc_html__( 'See all %ss from "%s" category', 'blocks-monster' ), ucwords( $post_type ), $term_names ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

}
