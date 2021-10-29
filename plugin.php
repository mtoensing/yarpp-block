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

    /*
    wp_register_style(
      'random-shortscore-game-frontend',
      plugins_url( 'style.css', __FILE__ ),
      array( ),
      filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
    );

    wp_register_style(
      'random-shortscore-game-editor',
      plugins_url('editor.css', __FILE__),
      array( 'wp-edit-blocks' ),
      filemtime(plugin_dir_path(__FILE__) . 'editor.css')
    );
    */

    //wp_set_script_translations('random-shortscore-game-js', 'random-shortscore-game');
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
  return "<p>Block</p>";
}


function filter_block($block_content, $block) {
  $className = '';

  if ($block['blockName'] !== 'core/heading') {
      return $block_content;
  }

  return $block_content;
}


 