<?php
/**
 * Plugin Name: MCQs Plugin
 * Plugin URI: https://github.com/ahsanwtc/mcqs-plugin
 * Description: A simple plugin for adding mcqs blocks to posts.
 * Version: 1.0
 * Author: jsan
 * Author URI: https://iamahsan.dev
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MCQsPlugin {
  function __construct () {
    // add_action('enqueue_block_assets', array($this, 'adminAssets'));
    add_action('init', array($this, 'adminAssets'));
  }

  function adminAssets () {
    // wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element'));
    wp_register_style('mcqseditcss', plugin_dir_url(__FILE__) . 'build/index.css');
    wp_register_script('ournewblocktype', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    register_block_type('mcqs-plugin/mcqs', array(
      'editor_script' => 'ournewblocktype',
      'editor_style' => 'mcqseditcss',
      'render_callback' => array($this, 'htmlRender')
    ));
  }

  function htmlRender ($attributes) {
    // loads only when plugin is in currently rendered page
    if (!is_admin()) {
      wp_enqueue_script('mcqsFrontend', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
      wp_enqueue_style('mcqsFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
    }

    ob_start(); 
    ?>
      <div class="mcqs-div">
        <pre style="display: none;"><?php echo wp_json_encode($attributes); ?></pre>
      </div>
    <?php
    return ob_get_clean();
  }
}

$mcqsPlugin = new MCQsPlugin();