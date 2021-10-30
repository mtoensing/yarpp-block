<?php
/**
 * Plugin Name: YARPP Block
 * Plugin URI: https://marc.tv/
 * Description: YARPP Block 
 * Version: 1.0
 * Author: Marc Tönsing
 * Author URI: https://marc.tv
 * Text Domain: yarpp-block
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace YARPPBlock;

defined('ABSPATH') || exit;

/**
  * Initalise frontend and backend and register block
**/
add_action('init', __NAMESPACE__ . '\\init');
add_action('init', __NAMESPACE__ . '\\register_block');

/* Init yarpp-block */
function init() {
    wp_register_script(
      'yarpp-block-js',
      plugins_url('build/index.js', __FILE__),
      [ 'wp-i18n', 'wp-blocks', 'wp-editor', 'wp-element', 'wp-server-side-render'],
      filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
    );

    
    wp_register_style(
      'yarpp-block-frontend',
      plugins_url( 'style.css', __FILE__ ),
      array( ),
      filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
    );
    /*
    wp_register_style(
      'yarpp-block-editor',
      plugins_url('editor.css', __FILE__),
      array( 'wp-edit-blocks' ),
      filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );
    */

    //wp_set_script_translations('yarpp-block-js', 'yarpp-block');
}


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 */

function register_block() {
    if (! function_exists('register_block_type')) {
        // Gutenberg is not active.
        return;
    }

    register_block_type('yarpp-block/list', [
    'editor_script' => 'yarpp-block-js',
    'editor_style' => 'yarpp-block-editor',
    'style' => 'yarpp-block-frontend',
    'render_callback' => __NAMESPACE__ . '\\render_callback',
    'attributes' => array(
        'use_cache' => array(
          'type' => 'boolean',
          'default' => false,
        ),
        'updated' => array(
          'type' => 'number',
          'default' => 0,
          '_builtIn' => true,
        ),
    )]);
}

/**
 * Render block output 
 *
 */

function render_callback($attributes, $content) {
    //add only if block is used in this post.
    add_filter('render_block', __NAMESPACE__ . '\\filter_block', 10, 2);
  
    if($attributes['use_cache'] == true){
      if ( false === ( $shortscore_transient_link = get_transient( 'yarpp_block_transient_link' ) ) ) {
          // It wasn't there, so regenerate the data and save the transient
          $yarpp_block_transient_link = getBlocks();
          set_transient( 'yarpp_block_transient_link', $yarpp_block_transient_link, 3600 );
      }
    } else {
      $yarpp_block_transient_link = getBlocks();
    }

    return $yarpp_block_transient_link;
    
}

function getBlocks() {
  $html = '';
  $cpid = get_the_ID();
  $excludes[] = $cpid;
  $related_posts_array = array();

  if (function_exists('yarpp_get_related')) {
    $related_posts = yarpp_get_related(array('limit' => 3), $cpid);
  } else {
    return;
  }
  if(count($related_posts) > 2){
    $relatedposts_html = '<h3 class="alignwide" id="related-posts-yarpp-block">'. __("Related posts",'yarpp-block'). '</h3>';
    $relatedposts_html .= '<ul class="wp-block-latest-posts__list is-grid columns-3 alignwide wp-block-latest-posts">';

    foreach ($related_posts as $posts) {
      $related_posts_array[] = $posts->ID;
      $relatedposts_html .= get_list_item($posts->ID);
    }

    $relatedposts_html .= '</ul>';
  }

  $excludes = array_merge($excludes, $related_posts_array);

  $args = array(
          'post_type'      => 'post',
          'post_status' 	 => 'publish',
          'posts_per_page' => '3',
          'post__not_in'   => $excludes,
          'order'          => 'DESC'
  );
  
  $the_query = new \WP_Query($args); 
  $latestposts_html = '<h3 class="alignwide" id="latest-posts-yarpp-block">Latest Posts</h3>';
  $latestposts_html .= '<ul class="wp-block-latest-posts__list is-grid columns-3 alignwide wp-block-latest-posts">';
  while ($the_query->have_posts()) :
    $the_query->the_post();
    if (has_post_thumbnail()):
      $latestposts_html .= get_list_item(get_the_ID());
    endif; 
  endwhile; 

  $latestposts_html .= '</ul>';
  wp_reset_postdata(); 

  return $latestposts_html . $relatedposts_html;
  
}

function get_list_item($pid){
  $html = '<li>';
  $size = "yarpp";
  $size_retina = "yarpp-retina"; 
  $permalink = get_the_permalink($pid); 
  $alt = get_post_meta( get_post_thumbnail_id($pid), '_wp_attachment_image_alt', true );
  $title = get_the_title($pid);
  $img = '<img loading="lazy" alt="' . $alt . '" width="300" height="130" src="' . get_the_post_thumbnail_url($pid,$size) .'" srcset="' . get_the_post_thumbnail_url($pid,$size_retina) .' 2x">';
  $html .= '<div class="wp-block-latest-posts__featured-image"><a href="' . $permalink . '">' . $img . '</a></div>';
  $html .= '<a href="' . $permalink . '">' . $title . '</a>';
  $html .= '</li>';

  return $html;
}

function filter_block($block_content, $block) {
  $className = '';

  if ($block['blockName'] !== 'core/heading') {
      return $block_content;
  }

  return $block_content;
}
