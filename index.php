<?php
/**
 * Plugin Name: MCQs Plugin
 * Plugin URI: https://github.com/ahsanwtc/mcqs-plugin
 * Description: A simple plugin for adding mcqs blocks to posts.
 * Version: 1.0
 * Author: jsan
 * Author URI: https://iamahsan.dev
 * Text Domain: elementor-mcqs
 */

define('ELEMENTOR_MCQS', __FILE__);

/**
 * Include the Elementor_MCQs class
 */
require plugin_dir_path(ELEMENTOR_MCQS) . 'class-elementor-mcqs.php';