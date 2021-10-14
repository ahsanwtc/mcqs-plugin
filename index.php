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
    add_action('enqueue_block_assets', array($this, 'adminAssets'));
  }

  function adminAssets () {
    wp_enqueue_script('ournewblocktype', plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element'));
  }
}

$mcqsPlugin = new MCQsPlugin();