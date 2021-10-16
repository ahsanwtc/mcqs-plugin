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
class ProductCard extends Widget_Base {
  /**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct($data = array(), $args = null) {
		parent::__construct($data, $args);

		wp_register_style('product-card-style', PLUGIN_URL . 'build/product-card.css', [], rand());
		wp_register_script('product-card-script', PLUGIN_URL . 'build/product-card.js', ['jquery'], rand(), true);
	}

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
		return 'product-card';
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
		return esc_html__('Product Card', 'elementor-mcqs');
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
		return array('product-card-style');
	}

	/**
	 * Enqueue scripts.
	 */
	public function get_script_depends() {
		return array('product-card-script');
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
     * Image Settings
     */
		$this->start_controls_section(
			'image_section',
			array(
				'label' => __('Image', 'elementor-mcqs'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			)
		);

		$this->add_control(
			'image',
			array(
				'label'   => __('Choose image', 'elementor-mcqs'),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src()
				]
			)
		);

		$this->add_control(
			'show_image_link',
			[
				'label' => __('Show image link', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'elementor-mcqs'),
				'label_off' => __( 'Hide', 'elementor-mcqs'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image_link',
			[
				'label' => __('Image ink', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elementor-mcqs'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => [
					'show_image_link' => 'yes'
				]
			]
		);

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

		/**
     * Content Settings
     */
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __('Content', 'elementor-mcqs'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			)
		);

		$this->add_control(
			'card_title',
			[
				'label' => __('Title', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Default title', 'elementor-mcqs'),
				'label_block' => true,
				'placeholder' => __('Type your title here', 'elementor-mcqs'),
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label' => __('Show Divider', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'elementor-mcqs'),
				'label_off' => __( 'Hide', 'elementor-mcqs'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'card_description',
			[
				'label' => __('Description', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __('Default description', 'elementor-mcqs'),
				'placeholder' => __('Type your description here', 'elementor-mcqs'),
			]
		);

		$this->end_controls_section();

		/**
     * Badge Settings
     */
		$this->start_controls_section(
			'badge_section',
			array(
				'label' => __('Badge', 'elementor-mcqs'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			)
		);

		// Top Badge
		$this->add_control(
			'show_top_badge',
			[
				'label' => __('Show top Badge', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'elementor-mcqs'),
				'label_off' => __( 'Hide', 'elementor-mcqs'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'top_badge_text',
			[
				'label' => __('Top badge text', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('19.99', 'elementor-mcqs'),
				'label_block' => true,
				'placeholder' => __('Type your title here', 'elementor-mcqs'),
				'condition' => [
					'show_top_badge' => 'yes'
				]
			]
		);

		// Middle Badge
		$this->add_control(
			'show_middle_badge',
			[
				'label' => __('Show middle badge', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'elementor-mcqs'),
				'label_off' => __( 'Hide', 'elementor-mcqs'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'middle_badge_text',
			[
				'label' => __('Middle badge text', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('19.99', 'elementor-mcqs'),
				'label_block' => true,
				'placeholder' => __('Type your title here', 'elementor-mcqs'),
				'condition' => [
					'show_middle_badge' => 'yes'
				]
			]
		);
		
		// Bottom Badge
		$this->add_control(
			'show_bottom_badge',
			[
				'label' => __('Show bottom badge', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'elementor-mcqs'),
				'label_off' => __( 'Hide', 'elementor-mcqs'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'bottom_badge_text',
			[
				'label' => __('Bottom badge text', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('19.99', 'elementor-mcqs'),
				'label_block' => true,
				'placeholder' => __('Type your title here', 'elementor-mcqs'),
				'condition' => [
					'show_bottom_badge' => 'yes'
				]
			]
		);

		$this->end_controls_section();


		/**
     * Button Section
     */
		$this->start_controls_section(
			'button_section',
			array(
				'label' => __('Button', 'elementor-mcqs'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			)
		);

		$this->add_control(
			'button_title',
			[
				'label' => __('Text', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Default text', 'elementor-mcqs'),
				'label_block' => true,
				'placeholder' => __('Type your title here', 'elementor-mcqs'),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __('Link', 'elementor-mcqs'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'elementor-mcqs'),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				]
			]
		);

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
		
		// Image
		$image_target = $settings['image_link']['is_external'] ? ' target="_blank"' : '';
		$image_nofollow = $settings['image_link']['nofollow'] ? ' rel="nofollow"' : '';

		// Button
		$button_target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
		$button_nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';

		?>
    <div class="image-card">
			<div class="image" style="background-image: url(<?php echo esc_url($settings['image']['url']); ?>);">
				<?php if ('yes' == $settings['show_image_link']) { ?>
					<a href="<?php echo $settings['image_link']['url']; ?>" <?php echo $image_target;?> <?php echo $image_nofollow;?> ></a>
				<?php } ?>
				<?php if ('yes' == $settings['show_top_badge']) { ?>
					<span class="top-price-badge badge-blue"><?php echo $settings['top_badge_text']; ?></span>
				<?php } ?>
				<?php if ('yes' == $settings['show_middle_badge']) { ?>
					<span class="middle-price-badge badge-blue"><?php echo $settings['middle_badge_text']; ?></span>
				<?php } ?>
			</div>
			<div class="content">
				<div class="title">
					<h2><?php echo $settings['card_title']; ?></h2>
				</div>
				<?php if ('yes' == $settings['show_divider']) { ?>
					<div class="divider"></div>
				<?php } ?>
				<div class="excerpt">
						<p><?php echo $settings['card_description']; ?></p>
				</div>
				<div class="readmore">
						<a href="<?php echo $settings['button_link']['url']; ?>" 
							class="button button-readmore" <?php echo $button_target;?> <?php echo $button_nofollow;?>
						>
							<?php echo $settings['button_title']; ?>
						</a>
						<?php if ('yes' == $settings['show_bottom_badge']) { ?>
							<span class="bottom-price-badge badge-blue"><?php echo $settings['bottom_badge_text']; ?></span>
						<?php } ?>
				</div>
			</div>
		</div>
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

Plugin::instance()->widgets_manager->register_widget_type(new ProductCard());