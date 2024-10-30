<?php
/**
 * Terms List class.
 *
 * @since      1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

namespace BlocksMonster\Gutenberg\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Term List class.
 */
class Terms_List {

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
		$taxonomies = get_taxonomies(
			[
				'publicly_queryable' => true,
				'show_in_rest'       => true,
			],
			'objects'
		);

		$built_ins         = array();
		$custom_variations = array(
			array(
				'name'        => 'terms-list',
				'title'       => __( 'Terms List', 'blocks-monster' ),
				'description' => __( 'Display a list of assigned terms from the selected taxonomy.', 'blocks-monster' ),
				'attributes'  => array(
					'taxonomy' => 'category',
				),
				'isDefault'   => true,
				'scope'       => array( 'inserter', 'transform' ),
			),
		);
	
		// Create and register the eligible taxonomies variations.
		foreach ( $taxonomies as $taxonomy ) {
			if ( in_array( $taxonomy->name, array( 'category' ), true ) ) {
				continue;
			}
			$variation = array(
				'name'        => $taxonomy->name,
				'title'       => $taxonomy->label,
				'description' => sprintf(
					/* translators: %s: taxonomy's label */
					__( 'Display a list of assigned terms from the taxonomy: %s', 'blocks-monster' ),
					$taxonomy->label
				),
				'attributes'  => array(
					'taxonomy' => $taxonomy->name,
				),
				'scope'       => array( 'inserter', 'transform' ),
			);
			if ( $taxonomy->_builtin ) {
				$built_ins[] = $variation;
			} else {
				$custom_variations[] = $variation;
			}
		}

		return array_merge( $built_ins, $custom_variations );
	}

	/**
	 * Render the block.
	 * 
	 * @param array $attributes Block attributes.
	 */
	public function render( $attributes = [] ) {
		$per_page = isset( $attributes['perPage'] ) ? sanitize_text_field( $attributes['perPage'] ) : 5;
		$order = isset( $attributes['order'] ) ? sanitize_text_field( $attributes['order'] ) : 'asc';
		$orderby = isset( $attributes['orderBy'] ) ? sanitize_text_field( $attributes['orderBy'] ) : 'name';
		$orientation = isset( $attributes['orientation'] ) ? sanitize_text_field( $attributes['orientation'] ) : 'vertical';
		$sepertor = isset( $attributes['sepertor'] ) ? sanitize_text_field( $attributes['sepertor'] ) : ', ';
		$taxonomy = isset( $attributes['taxonomy'] ) ? sanitize_text_field( $attributes['taxonomy'] ) : 'category';
		$hide_empty = isset( $attributes['hideEmpty'] ) ? sanitize_text_field( $attributes['hideEmpty'] ) : false;
		$show_count = isset( $attributes['showCount'] ) ? sanitize_text_field( $attributes['showCount'] ) : false;
		$terms = get_terms( $taxonomy, [
			'hide_empty' => $hide_empty,
			'number'     => $per_page,
			'order'      => $order,
			'orderby'    => $orderby,
		] );

		if ( is_wp_error( $terms ) ) {
			return '';
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			[
				'class' => 'bm-terms-list--' . $orientation,
			]
		);

		$sepertor_class = 'bm-terms-list__separator';
		if ( $sepertor === ',' ) {
			$sepertor_class .= ' bm-terms-list__separator--comma';
		} elseif ( $sepertor === '|' ) {
			$sepertor_class .= ' bm-terms-list__separator--pipe';
		} elseif ( $sepertor === '/' ) {
			$sepertor_class .= ' bm-terms-list__separator--slash';
		} elseif ( $sepertor === '-' ) {
			$sepertor_class .= ' bm-terms-list__separator--hyphen';
		}
		
		ob_start();
		?>
		<div <?php echo $wrapper_attributes; ?>>
			<ul class='bm-terms-list__items'>
				<?php foreach ( $terms as $term ) : ?>
					<li class="bm-terms-list__item">
						<a href="<?php echo get_term_link( $term ); ?>" target="_blank" rel="noreferrer noopener" class="bm-terms-list__name">
							<?php echo esc_html( $term->name ); ?>
						</a>
						<?php if ( $show_count ) : ?>
							<span class="bm-terms-list__count">(<?php echo esc_html( $term->count ); ?>)</span>
						<?php endif; ?>
						<?php if ( $sepertor && $orientation === 'horizontal' && $term !== end( $terms ) ) : ?>
							<span class="<?php echo esc_attr( $sepertor_class ); ?>"><?php echo esc_html( $sepertor ); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}

}

