<?php
/**
 * Post Grid Block
 *
 * @package BlocksMonster
 * @since 1.0.0
 */

namespace BlocksMonster\Elementor\Block\Post;

use WP_Query;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Post Grid
 *
 * @since 1.0.0
 */
class Grid extends Widget_Base {

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
		wp_enqueue_style( 'blocks_monster-el-post-grid', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/post-grid/style.css', [], BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get script dependencies
	 */
	public function get_script_depends() {
		return [ 'blocks_monster-el-post-grid' ];
	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'blocks_monster-el-post-grid' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'blocks_monster-post-grid';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Post Grid', 'blocks-monster' );
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
		return [ 'post', 'grid' ];
	}

	/**
	 * Get page tree
	 *
	 * @param int $page_id Page ID.
	 */
	private function get_page_tree( $page_id = 0 ) {

		if ( ! $page_id ) {
			return [];
		}

		$post_status = 'publish';
		$pages       = get_pages(
			[
				'child_of'     => $page_id,
				'hierarchical' => false,
				'post_status'  => $post_status,
			]
		);

		if ( empty( $pages ) ) {
			return [];
		}

		$new_pages = array_map(
			function( $item ) {
				$title = get_post_meta( $item->ID, 'title', true );
				if ( empty( $title ) ) {
					$title = $item->post_title;
				}
				return [
					'ID'            => $item->ID,
					'post_title'    => $title,
					'post_status'   => $item->post_status,
					'post_parent'   => $item->post_parent,
					'post_date'     => $item->post_date,
					'post_modified' => $item->post_modified,
					'link'          => get_permalink( $item->ID ),
				];
			},
			$pages
		);

		return $this->build_page_tree( $new_pages, $page_id );
	}

	/**
	 * Build page tree
	 *
	 * @param array $elements Page elements.
	 * @param int   $parent_id Parent ID.
	 */
	private function build_page_tree( $elements = [], $parent_id = 0 ) {
		$branch = [];
		foreach ( $elements as $element_id => $element ) {
			$element = (array) $element;
			if ( $element['post_parent'] === $parent_id ) {
				$children = $this->build_page_tree( $elements, $element['ID'] );
				if ( $children ) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}

		return $branch;
	}

	/**
	 * Get page flat list
	 *
	 * @param int $parent Parent ID.
	 */
	private function get_page_flat_list( $parent ) {
		$tree = $this->get_page_tree( $parent );

		$list = [];

		$this->get_page_flat_list_recursivly( $tree, $list );

		return $list;
	}

	/**
	 * Get page flat list
	 *
	 * @param array $tree Page tree.
	 * @param array $list Page list.
	 */
	private function get_page_flat_list_recursivly( $tree, &$list ) {
		foreach ( $tree as $item ) {
			$list[] = $item['ID'];
			if ( ! empty( $item['children'] ) ) {
				$this->get_page_flat_list_recursivly( $item['children'], $list );
			}
		}
	}

	/**
	 * Render
	 */
	public function render() {
		$post_type      = $this->get_settings_for_display( 'post_type' );
		$count          = $this->get_settings_for_display( 'count' );
		$order_by       = $this->get_settings_for_display( 'order_by' );
		$order          = $this->get_settings_for_display( 'order' );
		$offset         = $this->get_settings_for_display( 'offset' );
		$exclude        = $this->get_settings_for_display( 'exclude' );
		$include        = $this->get_settings_for_display( 'include' );
		$parent         = $this->get_settings_for_display( 'parent' );
		$heading        = $this->get_settings_for_display( 'heading' );
		$read_more_text = $this->get_settings_for_display( 'read_more_text' );
		$with_icon      = $this->get_settings_for_display( 'read_more_with_icon' );
		$icon           = $this->get_settings_for_display( 'read_more_icon' );

		$list = [];
		if ( $parent ) {
			$list = $this->get_page_flat_list( $parent );

			// Exclude.
			if ( $exclude ) {
				$exclude = explode( ',', $exclude );
				$list    = array_diff( $list, $exclude );
			}

			// Limit.
			if ( $count ) {
				$list = array_slice( $list, 0, $count );
			}
		} else {
			$args = [
				'post_type'      => $post_type,
				'posts_per_page' => $count,
				'orderby'        => $order_by,
				'order'          => $order,
				'offset'         => $offset,
				'exclude'        => $exclude,
				'include'        => $include,
				'post_parent'    => $parent,
			];

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$list[] = get_the_ID();
				}
			}
		}

		if ( $list ) { ?>
			<div class="blocks_monster-post-grid">
				<div class='blocks_monster-post-grid__heading'>
					<h2><?php echo esc_html( $heading ); ?></h2>
				</div>
				<div class="blocks_monster-post-grid-items">
					<?php
					foreach ( $list as $single_id ) {
						$excerpt = get_post_meta( $single_id, 'excerpt', true );
						if ( ! $excerpt ) {
							$excerpt = get_the_excerpt( $single_id );
						}
						$excerpt = wpautop( $excerpt );

						// Calculate reading time.
						$words   = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $single_id ) ) );
						$minutes = floor( $words / 120 );

						?>
						<div class="blocks_monster-post-grid-item">
							<?php if ( has_post_thumbnail( $single_id ) ) { ?>
								<div class="blocks_monster-post-grid-item__thumbnail">
									<a href="<?php the_permalink( $single_id ); ?>">
										<?php the_post_thumbnail( 'large', $single_id ); ?>
									</a>
								</div>
							<?php } ?>
							<div class='blocks_monster-post-grid-item__content'>
								<h2>
									<a href="<?php the_permalink( $single_id ); ?>">
										<?php echo esc_html( get_the_title( $single_id ) ); ?>
									</a>
								</h2>
								<div class='blocks_monster-post-grid-item__meta'>
									<span class='blocks_monster-post-grid-item__author'>
										<a href="<?php echo esc_html( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
											<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
										</a>
									</span>
									<span class='blocks_monster-post-grid-item__meta__reading-time'>
										<?php
										echo sprintf(
											/* translators: %s: minutes */
											esc_html( _n( '%s minute', '%s minutes', $minutes, 'blocks-monster' ) ),
											esc_html( $minutes )
										);
										?>
									</span>
								</div>
								<div class='blocks_monster-post-grid-item__excerpt'><?php echo wp_kses_post( $excerpt ); ?></div>
								<div class='blocks_monster-post-grid-item__read-more'>
									<a href="<?php the_permalink( $single_id ); ?>">
										<?php echo esc_html( $read_more_text ); ?>
										<?php if ( 'yes' === $with_icon ) { ?>
											<span class="blocks_monster-icon">
												<?php \Elementor\Icons_Manager::render_icon( $icon ); ?>
											</span>
										<?php } ?> 
									</a>
								</div>
								<?php if ( is_user_logged_in() ) { ?>
									<div class='blocks_monster-post-grid-item__edit-link'>
										<a href="<?php echo esc_html( get_edit_post_link( $single_id ) ); ?>">
											<?php esc_html_e( 'Edit', 'blocks-monster' ); ?>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {
		$post_types_obj = get_post_types( [ 'public' => true ], 'objects' );
		$post_types     = [];

		foreach ( $post_types_obj as $post_type ) {
			$post_types[ $post_type->name ] = $post_type->label;
		}

		// Grid heading.
		$this->start_controls_section(
			'heading_section',
			[
				'label' => esc_html__( 'Heading', 'blocks-monster' ),
			]
		);

		// Heading.
		$this->add_control(
			'heading',
			[
				'label'   => esc_html__( 'Heading', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Latest Posts', 'blocks-monster' ),
			]
		);

		$this->end_controls_section();

		// Post Grid.
		$this->start_controls_section(
			'post_grid',
			[
				'label' => esc_html__( 'Grid Query', 'blocks-monster' ),
			]
		);

		// Post Type.
		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $post_types,
			]
		);

		// Post Count.
		$this->add_control(
			'count',
			[
				'label'   => esc_html__( 'Post Count', 'blocks-monster' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		// Post Order By.
		$this->add_control(
			'order_by',
			[
				'label'   => esc_html__( 'Post Order By', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => esc_html__( 'Date', 'blocks-monster' ),
					'title' => esc_html__( 'Title', 'blocks-monster' ),
					'rand'  => esc_html__( 'Random', 'blocks-monster' ),
				],
			]
		);

		// Post Order.
		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Post Order', 'blocks-monster' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'blocks-monster' ),
					'desc' => esc_html__( 'Descending', 'blocks-monster' ),
				],
			]
		);

		// Post Offset.
		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Post Offset', 'blocks-monster' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		// Post Exclude.
		$this->add_control(
			'exclude',
			[
				'label'       => esc_html__( 'Post Exclude', 'blocks-monster' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Enter post IDs separated by comma to exclude from the list.', 'blocks-monster' ),
			]
		);

		// Post Include.
		$this->add_control(
			'include',
			[
				'label'       => esc_html__( 'Post Include', 'blocks-monster' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Enter post IDs separated by comma to include from the list.', 'blocks-monster' ),
			]
		);

		// Post Parent.
		$this->add_control(
			'parent',
			[
				'label'   => esc_html__( 'Post Parent', 'blocks-monster' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->end_controls_section();

		// Read more.
		$this->start_controls_section(
			'read_more_section',
			[
				'label' => esc_html__( 'Read More', 'blocks-monster' ),
			]
		);

		// Read more text.
		$this->add_control(
			'read_more_text',
			[
				'label'   => esc_html__( 'Read More Text', 'blocks-monster' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'blocks-monster' ),
			]
		);

		// with icon.
		$this->add_control(
			'read_more_with_icon',
			[
				'label'   => esc_html__( 'With Icon', 'blocks-monster' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		// Icon.
		$this->add_control(
			'read_more_icon',
			[
				'label'     => esc_html__( 'Icon', 'blocks-monster' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'read_more_with_icon' => 'yes',
				],
			]
		);

		// Icon Spacing.
		$this->add_responsive_control(
			'read_more_icon_spacing',
			[
				'label'     => esc_html__( 'Icon Spacing', 'blocks-monster' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-post-grid-item__read-more .blocks_monster-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'read_more_with_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->style();

	}

	/**
	 * Style
	 */
	private function style() {

		// Grid Style.
		$this->start_controls_section(
			'grid_style_section',
			[
				'label' => esc_html__( 'Grid', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Grid Item Gap.
		$this->add_responsive_control(
			'grid_item_gap',
			[
				'label'      => esc_html__( 'Grid Item Gap', 'blocks-monster' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-post-grid-items' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Heading Style.
		$this->start_controls_section(
			'heading_style_section',
			[
				'label' => esc_html__( 'Heading', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Heading Color.
		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Heading Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-post-grid__heading h2' => 'color: {{VALUE}}',
				],
			]
		);

		// Heading Typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Heading Typography', 'blocks-monster' ),
				'selector' => '{{WRAPPER}} .blocks_monster-post-grid__heading h2',
			]
		);

		// Heading Margin.
		$this->add_responsive_control(
			'heading_margin',
			[
				'label'      => esc_html__( 'Heading Margin', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-post-grid__heading h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Heading Padding.
		$this->add_responsive_control(
			'heading_padding',
			[
				'label'      => esc_html__( 'Heading Padding', 'blocks-monster' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-post-grid__heading h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Excerpt Style.
		$this->start_controls_section(
			'excerpt_style_section',
			[
				'label' => esc_html__( 'Excerpt', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Excerpt Line Spacing.
		$this->add_responsive_control(
			'excerpt_line_spacing',
			[
				'label'      => esc_html__( 'Excerpt Line Spacing', 'blocks-monster' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 15,
				],
				'size_units' => [ 'px', 'em', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .blocks_monster-post-grid-item__excerpt p:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Read More Style.
		$this->start_controls_section(
			'read_more_style_section',
			[
				'label' => esc_html__( 'Read More', 'blocks-monster' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Read More Color.
		$this->add_control(
			'read_more_color',
			[
				'label'     => esc_html__( 'Read More Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-post-grid-item__read-more a' => 'color: {{VALUE}}',
				],
			]
		);

		// Read More Typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'read_more_typography',
				'label'    => esc_html__( 'Read More Typography', 'blocks-monster' ),
				'selector' => '{{WRAPPER}} .blocks_monster-post-grid-item__read-more a',
			]
		);

		// Read More Icon Color.
		$this->add_control(
			'read_more_icon_color',
			[
				'label'     => esc_html__( 'Read More Icon Color', 'blocks-monster' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blocks_monster-post-grid-item__read-more .blocks_monster-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'read_more_with_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}
}
