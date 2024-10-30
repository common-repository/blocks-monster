<?php
/**
 * Table Block
 *
 * @package BlocksMonster
 * @since 1.0.1
 */

namespace BlocksMonster\Elementor\Block;

use WP_Query;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Table
 *
 * @since 1.0.1
 */
class Table extends Widget_Base {

	/**
	 * Constructor
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget args.
	 *
	 * @since 1.0.1
	 */
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		// Block.
		wp_enqueue_style( 'blocks_monster-el-table', BLOCKS_MONSTER_URI . 'includes/elementor/blocks/table/style.css', [], BLOCKS_MONSTER_VER, 'all' );

	}

	/**
	 * Get style dependencies
	 */
	public function get_style_depends() {
		return [ 'blocks_monster-el-table' ];
	}

	/**
	 * Get name
	 */
	public function get_name() {
		return 'blocks_monster-table';
	}

	/**
	 * Get title
	 */
	public function get_title() {
		return esc_html__( 'Table', 'blocks-monster' );
	}

	/**
	 * Get icon
	 */
	public function get_icon() {
		return 'eicon-table';
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
		return [ 'table', 'blocks-monster' ];
	}

	/**
	 * Render
	 */
	public function render() {
		$is_horizontal = $this->get_settings_for_display( 'is_horizontal' );
		$content       = $this->get_settings_for_display( 'content' );
		if ( ! $content ) {
			return;
		}

		// Convert the content which is the csv comma seperated values to array.
		$content = explode( "\n", $content );

		// Remove the first element from the array which is the header.
		$header = array_shift( $content );

		// Convert the header to array.
		$header = explode( ',', $header );

		// Convert the content to array.
		$content = array_map(
			function ( $item ) {
				return explode( ',', $item );
			},
			$content
		);

		?>
		<div class="blocks_monster-table">
			<div class="blocks_monster-table-wrap">
				<?php
				if ( 'yes' === $is_horizontal ) {
					$this->render_horizontal( $header, $content );
				} else {
					$this->render_vertical( $header, $content );
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render horizontal
	 *
	 * @param array $header Header.
	 * @param array $content Content.
	 */
	public function render_horizontal( $header, $content ) {
		echo '<table class="blocks_monster-table--horizontal">';

		foreach ( $header as $heading_index => $heading ) {
			echo '<tr>';
			echo '<td class="blocks_monster-table__key">' . esc_html( $heading ) . '</td>';
			foreach ( $content as $row ) {
				echo '<td class="blocks_monster-table__value">' . do_shortcode( esc_html( $row[ $heading_index ] ) ) . '</td>';
			}
			echo '</tr>';
		}

		echo '</table>';
	}

	/**
	 * Render vertical
	 *
	 * @param array $header Header.
	 * @param array $content Content.
	 */
	public function render_vertical( $header, $content ) {
		echo '<table class="blocks_monster-table--vertical">';
		echo '<tr>';

		// Output table headers.
		foreach ( $header as $heading ) {
			echo '<th class="blocks_monster-table__key">' . esc_html( $heading ) . '</th>';
		}

		echo '</tr>';

		// Output table content.
		foreach ( $content as $row ) {
			echo '<tr>';
			foreach ( $row as $value ) {
				echo '<td class="blocks_monster-table__value">' . do_shortcode( esc_html( $value ) ) . '</td>';
			}
			echo '</tr>';
		}

		echo '</table>';
	}

	/**
	 * Register controls
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'table_section',
			[
				'label' => esc_html__( 'Table', 'blocks-monster' ),
			]
		);

		// Repeater toggle buttons with just button text.
		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'blocks-monster' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => 'Processor number, Graphics, Cores/Threads, Graphics (EUs), Cache, Memory, Operating range, Base Freq (GHz), Max Single Core Turbo (GHz; up to), Max All Core Turbo (GHz; up to), Graphics Max Freq (GHz; up to), Intel DL Bost/Intel GMA 2.0
				Intel Core i7-1160G7, Intel Iris X, 4/8, 96, 12MB, LPDDR4x-4266, 7-15W, 1.2, 4.4, 3.6, 1.1, Yes
				Intel Core i5-1130G7, Intel Iris X, 4/8, 80, 8MB, LPDDR4x-4266, 7-15W, 1.1, 4.0, 3.4, 1.1, Yes
				Intel Core i3-1120G4, Intel UHD Graphics, 4/8, 48, 8MB, LPDDR4x-4266, 7-15W, 1.1, 3.5, 3.0, 1.1, Yes
				Intel Core i3-1110G4, Intel UHD Graphics, 2/4, 48, 6MB, LPDDR4x-4266, 7-15W, 1.8, 3.9, 3.9, 1.1, Yes',
				'placeholder' => esc_html__( 'Enter your content here', 'blocks-monster' ),
			]
		);

		$this->end_controls_section();

	}
}
