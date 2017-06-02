<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://cohhe.com
 * @since             1.0
 * @package           shopera_func
 *
 * @wordpress-plugin
 * Plugin Name:       Functionality for Shopera theme
 * Plugin URI:        http://cohhe.com/
 * Description:       This plugin contains Shopera theme core functionality
 * Version:           1.5
 * Author:            Cohhe
 * Author URI:        http://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shopera-functionality
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shopera-functionality-activator.php
 */
function shopera_activate_shopera_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shopera-functionality-activator.php';
	shopera_func_Activator::shopera_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shopera-functionality-deactivator.php
 */
function shopera_deactivate_shopera_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shopera-functionality-deactivator.php';
	shopera_func_Deactivator::shopera_deactivate();
}

register_activation_hook( __FILE__, 'shopera_activate_shopera_func' );
register_deactivation_hook( __FILE__, 'shopera_deactivate_shopera_func' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shopera-functionality.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shopera_func() {

	$plugin = new shopera_func();
	$plugin->shopera_run();

}
run_shopera_func();

function shopera_woo_add_brand_slider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'brand_ids' => ''
	), $atts ) );

	$output = '';

	if ( $brand_ids == '' ) {
		return;
	}

	$brand_ids = explode(',', $brand_ids);

	if ( $title != '' ) {
		$output .= '<h1>' . $title . '</h1>';
	}

	$output .= '
	<div class="brand-carousel-main paint-area">
		<div class="brand-carousel-container">
			<div class="brand-carousel">';
				foreach ($brand_ids as $brand_value) {
					$image_id = $brand_value;
					$link = '';
					if ( strpos($brand_value,':') !== false ) {
						$brand_value = explode(':', $brand_value);
						$image_id = $brand_value['0'];
						$link = get_permalink( $brand_value['1'] );
					}

					$brand_image = wp_get_attachment_image_src( $image_id, 'shopera-brand-image' );

					$output .= '<div class="brand-item">';
						if ( $link == '' ) {
							$output .= '<img class="" src="' . $brand_image['0'] . '" alt="">';
						} else {
							$output .= '<a href="' . $link . '"><img class="" src="' . $brand_image['0'] . '" alt="brand-image"></a>';
						}
									
					$output .= '</div>';
				}
		$output .= '
			</div>
		</div>
	</div>';

	return $output;
}
add_shortcode('woo_brand_slider','shopera_woo_add_brand_slider');

function shopera_woo_featured_categories( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'featured1' => '',
		'featured2' => '',
		'featured3' => ''
	), $atts ) );

	$output = $extra_class = '';

	if ( $featured1 != '' || $featured2 != '' || $featured3 != '' ) {
		$featured_cat_count = 0;
		if ( $featured1 != '' ) {
			$featured_cat_count++;
		}
		if ( $featured2 != '' ) {
			$featured_cat_count++;
		}
		if ( $featured3 != '' ) {
			$featured_cat_count++;
		}

		if ( $featured_cat_count == 1 ) {
			$extra_class = ' one';
		} elseif ( $featured_cat_count == 2 ) {
			$extra_class = ' two';
		} elseif ( $featured_cat_count == 3 ) {
			$extra_class = ' three';
		}

		$output .= '<div class="woo-category-container'.$extra_class.'">';
			if ( $featured1 != '' ) {
				$featured_id_1 = explode(':', $featured1);
				ob_start();
				shopera_get_woo_categories($featured_id_1['1'],$featured_id_1['0']);
				$output .= ob_get_contents();
				ob_end_clean();
			}
			if ( $featured2 != '' ) {
				$featured_id_2 = explode(':', $featured2);
				ob_start();
				shopera_get_woo_categories($featured_id_2['1'],$featured_id_2['0']);
				$output .= ob_get_contents();
				ob_end_clean();
			}
			if ( $featured3 != '' ) {
				$featured_id_3 = explode(':', $featured3);
				ob_start();
				shopera_get_woo_categories($featured_id_3['1'],$featured_id_3['0']);
				$output .= ob_get_contents();
				ob_end_clean();
			}

		$output .= '<div class="clearfix"></div></div>';
	}

	return $output;
}
add_shortcode('woo_featured_categories','shopera_woo_featured_categories');

function shopera_get_woo_categories( $post_id, $category_slug ) {
	if (strpos($post_id,'|') !== false) {
		$cat_data = explode('|', $post_id);
		$cat_excerpt = $cat_data['2'];
		$cat_title = $cat_data['1'];
		$slide_image_url = wp_get_attachment_image_src( $cat_data['0'], 'shopera-huge-width' );
		$cat_img = $slide_image_url[0];
	} else {
		$cat_post = get_post( $post_id );
		$cat_excerpt = $cat_post->post_excerpt;
		$cat_title = get_the_title($post_id);
		$slide_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'shopera-huge-width' );
		$cat_img = $slide_image_url[0];
	}

	$output = '';

	$output .= '<div class="woo-category-item">';
		$output .= '<div class="woo-category-image" style="background-image:url('.$cat_img.');"></div>';
		$output .= '<a href="'.esc_url(site_url()).'/?product_cat='.esc_attr($category_slug).'" class="woo-category-inner">';
			$output .= '<span class="woo-category-title paint-area paint-area--text">'.$cat_title.'</span>';
			$output .= '<span class="woo-category-excerpt paint-area paint-area--text">-'.$cat_excerpt.'-</span>';
		$output .= '</a>';
	$output .= '</div>';

	echo $output;
}

function shopera_woo_testimonial_carousel( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'limit'    => '-1'
	), $atts ) );
	$output = '';

	// For SiteOrigins Page Builder - Because of infinite loops, don't render this shortcode if its inside another loop
	static $depth = 0;
	$depth++;
	if( $depth > 1 ) {
		$depth--;
		return;
	}

	query_posts(array(
		'post_type' => 'testimonial',
		'posts_per_page' => $limit,
		'easy-testimonial-category' => $category

	));

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	$output = '
	<div class="testimonial-container">
		<div id="tbtestimonial-listing">';

	while(have_posts()) {
		the_post();

		$output .= '
		<div class="in-content-testimonial">
			<div class="testimonial-gravatar">';
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
				if ( !empty($img['0']) ) {
					$output .= '<img width="'.$img['1'].'" height="'.$img['2'].'" src="'.$img['0'].'" class="attachment-tbtestimonial_thumbnail wp-post-image" alt="headphones-405854_12802">';
				}
			$output .= '
			</div>
			<div class="testimonial-data">
				<p class="testimonial-content paint-area paint-area--text">'.get_the_excerpt().'</p>';
				if ( get_post_meta(get_the_ID(), '_ikcf_client', true) ) {
					$output .= '<p class="testimonial-author paint-area paint-area--text">—'.get_post_meta(get_the_ID(), '_ikcf_client', true).'</p>';
				}
				if ( get_post_meta(get_the_ID(), '_ikcf_position', true) ) {
					$output .= '<p class="testimonial-company paint-area paint-area--text">'.get_post_meta(get_the_ID(), '_ikcf_position', true).'</p>';
				}
				$output .= '
			</div>
			<div class="clearfix"></div>
		</div>';
	}

	$output .= '</div></div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}
add_shortcode('woo_testimonial_carousel','shopera_woo_testimonial_carousel');