<?php

/**
 * Plugin Name: List YARPP Block
 * Plugin URI: https://marc.tv/
 * Description: YARPP Block 
 * Version: 1.6
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
function init()
{
  wp_register_script(
    'yarpp-block-js',
    plugins_url('build/index.js', __FILE__),
    ['wp-i18n', 'wp-blocks', 'wp-editor', 'wp-element', 'wp-server-side-render'],
    filemtime(plugin_dir_path(__FILE__) . 'build/index.js')
  );


  wp_register_style(
    'yarpp-block-frontend',
    plugins_url('style.css', __FILE__),
    array(),
    filemtime(plugin_dir_path(__FILE__) . 'style.css')
  );

  wp_set_script_translations('yarpp-block-js', 'yarpp-block');
}


/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 */

function register_block()
{
  if (!function_exists('register_block_type')) {
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
      'headline' => array(
        'type' => 'string',
        'default' => 'Related posts',
      ),
      'level' => array(
        'type' => 'string',
        'default' => 'h3',
      ),
      'targetblank' => array(
        'type' => 'boolean',
        'default' => false,
      ),
      'imgsize' => array(
        'type' => 'number',
        'default' => 320,
      ),
    )
  ]);
}

/**
 * Render block output 
 *
 */

function render_callback($attributes, $content)
{

  $block = getBlocks($attributes);

  return $block;
}

function getBlocks($attributes)
{

  $blocktype = $attributes['blocktype'];
  $align = $attributes['align'];
  $headline = $attributes['headline'];
  $level = $attributes['level'];

  $alignclass = '';
  $cpid = get_the_ID();
  $excludes[] = $cpid;
  $related_posts_array = array();
  $html_related = '';
  $heading = '';
  $is_backend = defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === filter_input(INPUT_GET, 'context', FILTER_SANITIZE_STRING);
 

  if ($align != '') {
    $alignclass = 'align' . $align;
  }

  if ($headline != '') {
    $heading = '<' . $level . ' class="' . $alignclass .  '">' . $headline . '</' . $level . '>';
  }

  /* Is YARPP installed?  */
  if ( function_exists( 'yarpp_get_related' ) ) {
    $posts = yarpp_get_related( array('limit' => 3), $cpid );
  } else {
    if( $is_backend ){
      return '<p class="notice">' . __('YARPP plugin is not installed and activated. ', 'yarpp-block') . '</p>';
    } else {
      return '';
    }
  }

  /* Enough posts available?  */
  if ( $posts != false && count( $posts ) > 2 ) {
    $html_related = $heading;
    $html_related .= '<ul class="' . $alignclass .  ' wp-block-latest-posts__list is-grid columns-3 wp-block-latest-posts">';

    foreach ($posts as $posts) {
      $related_posts_array[] = $posts->ID;
      $html_related .= render_listitem( $posts->ID, $attributes );
    }

    $html_related .= '</ul>';

  } else {
    if( $is_backend ){
      return '<p class="notice">' . __('Less than 3 related posts found.', 'yarpp-block') . '</p>';
    } else {
      return '';
    }

  }

  if ($blocktype == 'related') {
    return $html_related;
  }

  $excludes = array_merge($excludes, $related_posts_array);

  $args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => '6',
    'post__not_in'   => $excludes,
    'order'          => 'DESC'
  );

  $the_query = new \WP_Query($args);

  $html_latestposts = $heading;

  $html_latestposts .= '<ul class="' . $alignclass .  ' wp-block-latest-posts__list is-grid columns-3 wp-block-latest-posts">';

  $i = 0;
  while ($the_query->have_posts()) :

    $the_query->the_post();
    if (has_post_thumbnail()) :
      $html_latestposts .= render_listitem(get_the_ID(), $attributes);
      $i++;
    endif;
    if ($i > 2) {
      break;
    }

  endwhile;

  $html_latestposts .= '</ul>';
  wp_reset_postdata();

  if ($blocktype == 'latest') {
    return $html_latestposts;
  }
}

function render_listitem($pid, $attributes)
{
  $html = '<li>';
  $params = '';
  $is_backend = defined('REST_REQUEST') && true === REST_REQUEST && 'edit' === filter_input(INPUT_GET, 'context', FILTER_SANITIZE_STRING);
  $tag = 'a';
  $url = get_the_permalink( $pid );

  if ($is_backend) {
    $tag = 'span';
  }

  if ($attributes['targetblank']) {
    $params = ' target="_blank" rel="noopener"';
  }

  $title = get_the_title($pid);
  $img = get_the_post_thumbnail( $pid, array( 320, 0) );
  $html .= '<div class="wp-block-latest-posts__featured-image"><a href="' . $url .'"'. $params . '>' . $img . '</a></div>';
  $html .= '<'.$tag.' href="' . $url .  $params . '">' . $title . '</'.$tag.'>';
  $html .= '</li>';

  return $html;
}
