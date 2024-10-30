<?php
/*
Plugin Name: Module for Gravity Forms in Divi Builder
Description: Module for Gravity Forms in Divi Builder allows you to use and style Gravity Forms in the Divi Visual Builder.
Version:     1.01
Author:      Tree Star Marketing LLC
Author URI:  https://treestarmarketing.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: gfdbm-module-for-gravity-forms-in-divi-builderZ
Domain Path: /languages

Module for Gravity Forms in Divi Builder is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Module for Gravity Forms in Divi Builder is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with Module for Gravity Forms in Divi Builder. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'gfdbm_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.00
 */
function gfdbm_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/GravityformsDiviBuilderModule.php';
}
add_action( 'divi_extensions_init', 'gfdbm_initialize_extension' );
endif;

/**
 * Filters the next, previous and submit buttons.
 * Replaces the forms <input> buttons with <button> while maintaining attributes from original <input>.
 *
 * @param string $button Contains the <input> tag to be filtered.
 * @param object $form Contains all the properties of the current form.
 *
 * @return string The filtered button.
 */
add_filter( 'gform_next_button', 'gfdbm_input_to_next_button', 10, 2 );
add_filter( 'gform_previous_button', 'gfdbm_input_to_previous_button', 10, 2 );
add_filter( 'gform_submit_button', 'gfdbm_input_to_submit_button', 10, 2 );
function gfdbm_input_to_next_button( $html, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	$input = $dom->getElementsByTagName( 'input' )->item(0);

	$div = $dom->createElement( 'div' );
	$div->setAttribute( 'class', 'next_button et_pb_button_wrapper' );

	$button = $dom->createElement( 'button' );
	$button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) ) );
	$input->removeAttribute( 'value' );

	$classes = $input->getAttribute( 'class' );
	if ( empty( $classes ) ) {
		$classes = 'et_pb_button';
	} else {
		$classes .= ' et_pb_button';
	}
	$button->setAttribute( 'class', $classes );
	$input->removeAttribute( 'class' );

	foreach( $input->attributes as $attribute ) {
		$button->setAttribute( $attribute->name, $attribute->value );
	}

	$div->appendChild( $button );

	$input->parentNode->replaceChild( $div, $input );

	return $dom->saveHtml( $div );
}

function gfdbm_input_to_previous_button( $html, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	$input = $dom->getElementsByTagName( 'input' )->item(0);

	$div = $dom->createElement( 'div' );
	$div->setAttribute( 'class', 'previous_button et_pb_button_wrapper' );

	$button = $dom->createElement( 'button' );
	$button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) ) );
	$input->removeAttribute( 'value' );

	$classes = $input->getAttribute( 'class' );
	if ( empty( $classes ) ) {
		$classes = 'et_pb_button';
	} else {
		$classes .= ' et_pb_button';
	}
	$button->setAttribute( 'class', $classes );
	$input->removeAttribute( 'class' );

	foreach( $input->attributes as $attribute ) {
		$button->setAttribute( $attribute->name, $attribute->value );
	}

	$div->appendChild( $button );

	$input->parentNode->replaceChild( $div, $input );

	return $dom->saveHtml( $div );
}

function gfdbm_input_to_submit_button( $html, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	$input = $dom->getElementsByTagName( 'input' )->item(0);

	$div = $dom->createElement( 'div' );
	$div->setAttribute( 'class', 'submit_button et_pb_button_wrapper' );

	$button = $dom->createElement( 'button' );
	$button->appendChild( $dom->createTextNode( $input->getAttribute( 'value' ) ) );
	$input->removeAttribute( 'value' );

	$classes = $input->getAttribute( 'class' );
	if ( empty( $classes ) ) {
		$classes = 'et_pb_button';
	} else {
		$classes .= ' et_pb_button';
	}
	$button->setAttribute( 'class', $classes );
	$input->removeAttribute( 'class' );

	foreach( $input->attributes as $attribute ) {
		$button->setAttribute( $attribute->name, $attribute->value );
	}

	$div->appendChild( $button );

	$input->parentNode->replaceChild( $div, $input );

	return $dom->saveHtml( $div );
}

add_action( 'wp_enqueue_scripts', function() {
	global $wp_query;

	if ( !class_exists( 'GFForms' ) ) {
		return;
	}

	if ( isset( $wp_query->posts ) && is_array( $wp_query->posts ) ) {
		foreach ( $wp_query->posts as $post ) {
			if ( ! $post instanceof WP_Post ) {
				continue;
			}

			$forms = array();

			$content = $post->post_content;
			if ( function_exists( 'et_theme_builder_get_template_layouts' ) ) {
				$layouts = et_theme_builder_get_template_layouts();

				if ( ! empty( $layouts ) ) {
					if ( $layouts[ ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE ]['override'] && $layouts[ ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE ]['enabled'] ) {
						$layout = get_post( $layouts[ ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE ]['id'] );
						if ( $layout instanceof WP_Post ) {
							$content .= $layout->post_content;
						}
					}

					if ( $layouts[ ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ]['override'] && $layouts[ ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ]['enabled'] ) {
						$layout = get_post( $layouts[ ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE ]['id'] );
						if ( $layout instanceof WP_Post ) {
							$content .= $layout->post_content;
						}
					}

					if ( $layouts[ ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE ]['override'] && $layouts[ ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE ]['enabled'] ) {
						$layout = get_post( $layouts[ ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE ]['id'] );
						if ( $layout instanceof WP_Post ) {
							$content .= $layout->post_content;
						}
					}
				}
			}

			if ( preg_match_all( '/\[gfdbm_gravity_form +.*?(gravityform_id=.+?)\]/is', $content, $matches, PREG_SET_ORDER ) ) {
				foreach ( $matches as $match ) {
					//parsing shortcode attributes
					$attr    = shortcode_parse_atts( $match[1] );
					$form_id = str_replace( 'gf-', '', rgar( $attr, 'gravityform_id' ) );

					if ( ! empty( $form_id ) ){
						$forms[] = array(
							'meta' => RGFormsModel::get_form_meta( $form_id ),
							'ajax' => isset( $attr['ajax'] ) && strtolower( substr( $attr['ajax'], 0, 2 ) ) == 'on'
						);
					}
				}
			}

			foreach ( $forms as $form ) {
				if ( isset( $form['meta']['id'] ) ) {
					GFFormDisplay::enqueue_form_scripts( $form['meta'], $form['ajax'] );
				}
			}
		}
	}
}, 12 );

