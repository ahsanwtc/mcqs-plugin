<?php
/**
 * MCQs class.
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

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * MCQs widget class.
 *
 * @since 1.0.0
 */
class MCQs extends Widget_Base {
  /**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	// public function __construct($data = array(), $args = null) {
	// 	parent::__construct($data, $args);

	// 	wp_register_style('mcqs', plugins_url('/build/index.css', ELEMENTOR_MCQS), array(), '1.0.0');
	// }

  /**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mcqs';
	}

  /**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__('MCQs', 'elementor-mcqs');
	}

  /**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'far fa-list-alt';
	}

  /**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array('mcqs-elementor');
	}

  /**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array('mcqs');
	}

  /**
	 * Adding the style tab
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
  private function style_tab() {}

  /**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

    /**
     * Content Settings
     */
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __('Content Settings', 'elementor-mcqs'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			)
		);

		// $this->add_control(
		// 	'title',
		// 	array(
		// 		'label'   => __('Title', 'elementor-mcqs'),
		// 		'type'    => Controls_Manager::TEXT,
		// 		'default' => __('Title', 'elementor-mcqs'),
		// 	)
		// );

		// $this->add_control(
		// 	'description',
		// 	array(
		// 		'label'   => __('Description', 'elementor-mcqs'),
		// 		'type'    => Controls_Manager::TEXTAREA,
		// 		'default' => __('Description', 'elementor-mcqs'),
		// 	)
		// );

		// $this->add_control(
		// 	'content',
		// 	array(
		// 		'label'   => __('Content', 'elementor-mcqs'),
		// 		'type'    => Controls_Manager::WYSIWYG,
		// 		'default' => __('Content', 'elementor-mcqs'),
		// 	)
		// );

		$this->end_controls_section();

    // $this->start_controls_section(
		// 	'style_section',
		// 	array(
		// 		'label' => __('Style Section', 'elementor-mcqs'),
    //     'tab'   => \Elementor\Controls_Manager::TAB_STYLE
		// 	)
		// );

    // $this->end_controls_section();

    // style tab
    $this->style_tab();
	}

  /**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// $this->add_inline_editing_attributes('title', 'none');
		// $this->add_inline_editing_attributes('description', 'basic');
		// $this->add_inline_editing_attributes('content', 'advanced');
		?>
    <div>
      <h1>This is an example widget.</h1>
    </div>
		<!-- <h2 <?php // echo $this->get_render_attribute_string('title'); ?><?php // echo wp_kses($settings['title'], array()); ?></h2>
		<div <?php // echo $this->get_render_attribute_string('description'); ?><?php // echo wp_kses($settings['description'], array()); ?></div>
		<div <?php // echo $this->get_render_attribute_string('content'); ?><?php // echo wp_kses($settings['content'], array()); ?></div> -->
		<?php
	}

  /**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		  view.addInlineEditingAttributes('title', 'none');
		  view.addInlineEditingAttributes('description', 'basic');
		  view.addInlineEditingAttributes('content', 'advanced');
		#>
		<h2 {{{ view.getRenderAttributeString('title') }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString('description') }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString('content') }}}>{{{ settings.content }}}</div>
		<?php
	}

}

Plugin::instance()->widgets_manager->register_widget_type(new MCQs());