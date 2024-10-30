<?php
/**
 * Posts Query class.
 *
 * @since      1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster\Gutenberg\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Posts Query class.
 */
class Posts_Query {

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
				'variation_callback' => [ $this, 'register_variations' ],
			)
		);
	}

	/**
	 * Register variations.
	 *
	 * @return array
	 */
	public function register_variations() {
		$post_types = get_post_types(
			[
				'public'       => true,
				'show_in_rest' => true,
			],
			'objects'
		);

		$built_ins         = array();
		$custom_variations = array(
			array(
				'name'        => 'posts-query',
				'title'       => __( 'Posts Query', 'blocks-monster' ),
				'description' => __( 'Display a list of posts from the selected post type.', 'blocks-monster' ),
				'attributes'  => array(
					'postType' => 'post',
					'perPage'  => 5,
					'order'    => 'asc',
					'orderBy'  => 'name',
				),
			),
		);

		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type->name, array( 'attachment', 'post' ), true ) ) {
				continue;
			}

			$built_ins[] = array(
				'name'        => 'posts-query-' . $post_type->name,
				'title'       => $post_type->labels->singular_name,
				'description' => sprintf( __( 'Display a list of %s.', 'blocks-monster' ), $post_type->labels->singular_name ),
				'attributes'  => array(
					'postType' => $post_type->name,
					'perPage'  => 5,
					'order'    => 'asc',
					'orderBy'  => 'name',
				),
			);
		}

		return array_merge( $custom_variations, $built_ins );
	}

	/**
	 * Render the block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function render( $attributes = [] ) {
		$post_type = isset( $attributes['postType'] ) ? sanitize_text_field( $attributes['postType'] ) : 'post';
		$per_page = isset( $attributes['perPage'] ) ? sanitize_text_field( $attributes['perPage'] ) : 5;
		$order = isset( $attributes['order'] ) ? sanitize_text_field( $attributes['order'] ) : 'asc';
		$orderby = isset( $attributes['orderBy'] ) ? sanitize_text_field( $attributes['orderBy'] ) : 'name';

		$posts = get_posts(
			[
				'numberposts' => $per_page,
				'post_type'   => $post_type,
				'order'       => $order,
				'orderby'     => $orderby,
			]
		);

		if ( empty( $posts ) ) {
			return '';
		}

		$wrapper_attributes = get_block_wrapper_attributes();

		ob_start();
		?>
		<div <?php echo $wrapper_attributes; ?>>
			<ul class="bm-posts-list__items">
				<?php foreach ( $posts as $post ) : ?>
					<li class="bm-posts-list__item">
						<a href='<?php echo get_permalink( $post->ID ); ?>' target="_blank" rel="noreferrer noopener" class="bm-posts-list__name">
							<?php echo get_the_title( $post->ID ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}

}

