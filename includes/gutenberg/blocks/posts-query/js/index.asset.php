<?php
/**
 * Block script dependencies.
 *
 * @since      1.0.0
 * @package    BlocksMonster
 * @author     BlocksMonster <dev@blocks.monster>
 */

$block_json = file_get_contents( __DIR__ . '/../block.json' );
$block_json = json_decode( $block_json, true );

return [
	'dependencies' => [
		'wp-blocks',
		'wp-block-editor',
		'wp-core-data',
		'wp-element',
		'wp-components',
		'wp-data',
		'wp-i18n',
	],
	'version' => $block_json['version'],
];
