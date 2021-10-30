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


  $cpid = get_the_ID();
  $excludes[] = $cpid;
  $related_posts_array = array();

  if (function_exists('yarpp_get_related')) {
    $related_posts = yarpp_get_related(array(), $cpid);
  } else {
    return;
  }

  foreach ($related_posts as $posts) {
      $related_posts_array[] = $posts->ID;
  }

  $excludes = array_merge($excludes, $related_posts_array);

  $args = array(
          'post_type'      => 'post',
          'post_status' 	 => 'publish',
          'posts_per_page' => '4',
          'post__not_in'   => $excludes,
          'order'          => 'DESC'
  );
  $i = 0;
  $the_query = new WP_Query($args); ?>

<div class="teaserbox-wrapper recentpostsbox">
<div class="teaserbox" style="display: block;">
  <h3 class="teaserbox-headline"><em>Neue Beiträge</em></h3>
  <div class="teaserbox-items teaserbox-items-visual teaserbox-grid ">
  <?php while ($the_query->have_posts()) :
    $the_query->the_post();
    if (has_post_thumbnail()):?>
    <?php
    $size = "yarpp";
    $size_retina = "yarpp-retina"; ?>
    <?php $permalink = get_the_permalink(); ?>
          <div class="teaserbox-post teaserbox-post<?php echo $i?> teaserbox-post-thumbs">
              <a class="teaserbox-post-a" href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>" rel="nofollow" >
              <img loading="lazy" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>" width="300" height="130" src="<?php the_post_thumbnail_url($size); ?>" srcset="<?php the_post_thumbnail_url($size_retina); ?> 2x">
              </a>
              <h4 data-date="<?php the_date(); ?>" class="teaserbox-post-title">
                  <a class="teaserbox-post-a" href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
              </h4>
          </div>
      <?php $i++ ?>
    <?php endif; ?>
 <?php if( $i > 3 ) { break; } ?>
 <?php endwhile; ?>
 <?php wp_reset_postdata(); ?>
 </div>
</div>
</div>




  return '<ul class="wp-block-latest-posts__list is-grid columns-3 alignwide wp-block-latest-posts"><li><a href="http://localhost/2022-testartikel/">2022 Test</a></li>
  <li><div class="wp-block-latest-posts__featured-image"><a href="http://localhost/anbernic-handheld-einsteiger-tutorial/"><img width="260" height="113" src="https://marc.tv/media/2021/05/anbernic-faq-tutorial-260x113.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="FAQ: Anbernic Tutorial" loading="lazy" style="" srcset="https://marc.tv/media/2021/05/anbernic-faq-tutorial-260x113.jpg 260w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-510x222.jpg 510w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1568x683.jpg 1568w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1536x669.jpg 1536w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1416x617.jpg 1416w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-460x200.jpg 460w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-920x400.jpg 920w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1320x575.jpg 1320w, https://marc.tv/media/2021/05/anbernic-faq-tutorial.jpg 1920w" sizes="(max-width: 260px) 100vw, 260px"></a></div><a href="http://localhost/anbernic-handheld-einsteiger-tutorial/">Anbernic Handheld Einsteiger Tutorial</a></li>
  <li><div class="wp-block-latest-posts__featured-image"><a href="http://localhost/brieftasche-mit-apple-airtag-fach/"><img width="260" height="113" src="https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-260x113.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="Brieftasche mit extra Fach für den AirTag" loading="lazy" style="" srcset="https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-260x113.jpg 260w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-510x222.jpg 510w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1568x683.jpg 1568w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1536x669.jpg 1536w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1416x617.jpg 1416w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-460x200.jpg 460w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-920x400.jpg 920w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1320x575.jpg 1320w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach.jpg 1920w" sizes="(max-width: 260px) 100vw, 260px"></a></div><a href="http://localhost/brieftasche-mit-apple-airtag-fach/">Gibt es eine Brieftasche mit AirTag Fach?</a></li>
  </ul><ul class="wp-block-latest-posts__list is-grid columns-3 alignwide wp-block-latest-posts"><li><a href="http://localhost/2022-testartikel/">2022 Test</a></li>
  <li><div class="wp-block-latest-posts__featured-image"><a href="http://localhost/anbernic-handheld-einsteiger-tutorial/"><img width="260" height="113" src="https://marc.tv/media/2021/05/anbernic-faq-tutorial-260x113.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="FAQ: Anbernic Tutorial" loading="lazy" style="" srcset="https://marc.tv/media/2021/05/anbernic-faq-tutorial-260x113.jpg 260w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-510x222.jpg 510w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1568x683.jpg 1568w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1536x669.jpg 1536w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1416x617.jpg 1416w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-460x200.jpg 460w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-920x400.jpg 920w, https://marc.tv/media/2021/05/anbernic-faq-tutorial-1320x575.jpg 1320w, https://marc.tv/media/2021/05/anbernic-faq-tutorial.jpg 1920w" sizes="(max-width: 260px) 100vw, 260px"></a></div><a href="http://localhost/anbernic-handheld-einsteiger-tutorial/">Anbernic Handheld Einsteiger Tutorial</a></li>
  <li><div class="wp-block-latest-posts__featured-image"><a href="http://localhost/brieftasche-mit-apple-airtag-fach/"><img width="260" height="113" src="https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-260x113.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="Brieftasche mit extra Fach für den AirTag" loading="lazy" style="" srcset="https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-260x113.jpg 260w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-510x222.jpg 510w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1568x683.jpg 1568w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1536x669.jpg 1536w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1416x617.jpg 1416w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-460x200.jpg 460w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-920x400.jpg 920w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach-1320x575.jpg 1320w, https://marc.tv/media/2021/05/portemonnaie-mit-airtag-fach.jpg 1920w" sizes="(max-width: 260px) 100vw, 260px"></a></div><a href="http://localhost/brieftasche-mit-apple-airtag-fach/">Gibt es eine Brieftasche mit AirTag Fach?</a></li>
  </ul>';
}


function filter_block($block_content, $block) {
  $className = '';

  if ($block['blockName'] !== 'core/heading') {
      return $block_content;
  }

  return $block_content;
}


 