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
        'blocktype' => array(
          'type' => 'string',
          'default' => 'related',
        ),
        'align' => array(
          'type' => 'string',
          'default' => '',
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

    $block = getBlocks($attributes['blocktype'], $attributes['align']);
    
    return $block;
    
}

function getBlocks($blocktype,$align) {

  $alignclass = '';
  $cpid = get_the_ID();
  $excludes[] = $cpid;
  $related_posts_array = array();
  $relatedposts_html = '';

  if($align != '') {
    $alignclass = 'align' . $align;
  }

  if (function_exists('yarpp_get_related')) {
    $related_posts = yarpp_get_related(array('limit' => 3), $cpid);
  } else {
    return;
  }

  if( count( $related_posts ) > 2 ){
    $relatedposts_html = '<ul class="' . $alignclass .  ' wp-block-latest-posts__list is-grid columns-3 wp-block-latest-posts">';
    foreach ($related_posts as $posts) {
      $related_posts_array[] = $posts->ID;
      $relatedposts_html .= get_list_item($posts->ID);
    }
    $relatedposts_html .= '</ul>';
  }

  if( $blocktype == 'related' ){
    return $relatedposts_html;
  } 

  $excludes = array_merge($excludes, $related_posts_array);

  $args = array(
          'post_type'      => 'post',
          'post_status' 	 => 'publish',
          'posts_per_page' => '6',
          'post__not_in'   => $excludes,
          'order'          => 'DESC'
  );
  
  $the_query = new \WP_Query($args); 
  $latestposts_html = '<ul class="' . $alignclass .  ' wp-block-latest-posts__list is-grid columns-3 wp-block-latest-posts">';

  $i = 0;
  while ($the_query->have_posts()) :
    
    $the_query->the_post();
    if (has_post_thumbnail()):
      $latestposts_html .= get_list_item(get_the_ID());
      $i++;
    endif; 
    if( $i > 2 ) { break; } 
    
  endwhile; 

  $latestposts_html .= '</ul>';
  wp_reset_postdata(); 

  if( $blocktype == 'latest' ){
    return $latestposts_html;
  } 

}

function get_list_item($pid){
  $html = '<li>';
  $is_backend = defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === filter_input( INPUT_GET, 'context', FILTER_SANITIZE_STRING );
  $size = "yarpp";
  $size_retina = "yarpp-retina"; 
  $href = 'href="' . get_the_permalink($pid) . '"'; 
  if($is_backend){
    $href = '';
  }
  $alt = get_post_meta( get_post_thumbnail_id($pid), '_wp_attachment_image_alt', true );
  $title = get_the_title($pid);
  $img = '<img loading="lazy" alt="' . $alt . '" width="300" height="130" src="' . get_the_post_thumbnail_url($pid,$size) .'" srcset="' . get_the_post_thumbnail_url($pid,$size_retina) .' 2x">';
  $html .= '<div class="wp-block-latest-posts__featured-image"><a '. $href .' >' . $img . '</a></div>';
  $html .= '<a ' . $href . ' >' . $title . '</a>';
  $html .= '</li>';

  return $html;
}

function filter_block($block_content, $block) {
  $className = '';

  return $block_content;
}
