<?php
/**
 * Elementor_MCQs class.
 *
 * @category   Class
 * @package    ElementorMCQs
 * @subpackage WordPress
 * @author     jsan <me@iamahsan.dev>
 * @copyright  2021 jsan
 * @license    https://opensource.org/licenses/MIT
 * @link       link(https://github.com/ahsanwtc/mcqs-plugin/, MCQs Elementor Widget)
 * @since      1.0.0
 * php version 7.3.9
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Main Elementor MCQs Class
 *
 * The init class that runs the Elementor MCQs plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the class-widgets.php file.
 */

final class ElementorMCQs {

  /**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

  /**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

  /**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

  /**
   * Singleton Instance
   * 
   * @since 1.0.0
	 * @var ElementorMCQs Single instance of this class.
   */
  private static $_instance;

  /**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
    // Call constants method
    $this->define_constants();

		// Load the translation.
		add_action('init', array($this, 'i18n'));

		// Initialize the plugin.
		add_action('plugins_loaded', array($this, 'init'));

    add_action('wp_enqueue_scripts', [$this, 'scripts_styles']);
	}

  /**
	 * Singleton Instance method
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public static function instance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
	}

  /**
	 * Define Plugin constants
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function define_constants() {
    define('PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));
    define('PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
	}

  /**
   * Load scripts and styles
   * 
   * @since 1.0.0
   * @access public
   */
  public function scripts_styles() {
    wp_register_style('mcqs-style', PLUGIN_URL . 'build/index.css', [], rand(), 'all');    
    wp_register_script('mcqs-script', PLUGIN_URL . 'build/index.js', ['wp-blocks', 'wp-element', 'wp-editor'], rand());

    wp_enqueue_style('mcqs-style');
    wp_enqueue_script('mcqs-script');    
  }

  /**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain('elementor-mcqs');
	}

  /**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init () {

		// Check if Elementor installed and activated.
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
			return;
		}

		// Check for required Elementor version.
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
			return;
		}

		// Check for required PHP version.
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
			return;
		}

    add_action('elementor/init', [$this, 'init_category']);
    add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);

		// Once we get here, We have passed all validation checks so we can safely include our widgets.
		// require_once 'class-widgets.php';
	}

  /**
   * Initialize widgets
   * 
   * @since 1.0.0
	 * @access public
   */
  public function init_widgets() {
    require_once PLUGIN_PATH . '/widgets/class-mcqs.php';
  }

  /**
   * Initialize category section
   * 
   * @since 1.0.0
	 * @access public
   */
  public function init_category() {
    Elementor\Plugin::instance()->elements_manager->add_category(
      'mcqs-elementor', [
        'title' => 'Elementor MCQs'
      ],
      1
    );
  }

  /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin () {
		deactivate_plugins(plugin_basename(ELEMENTOR_MCQS));

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Elementor MCQs',
			'Elementor'
		);
	}

  /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version () {
		deactivate_plugins(plugin_basename(ELEMENTOR_MCQS));

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Elementor MCQs',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

  /**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version () {
		deactivate_plugins(plugin_basename(ELEMENTOR_MCQS));

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Elementor Awesomesauce',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

}

// Instantiate ElementorMCQs.
ElementorMCQs::instance();