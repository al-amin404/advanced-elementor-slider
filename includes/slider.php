<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use ElementorPro\Base\Base_Widget;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Slider extends Widget_Base
{
	public function get_name()
	{
		return "advanced_elementor_slider";
	}

	public function get_title()
	{
		return esc_html__('Advanced Elementor Slider', 'aes_slider');
	}

	public function get_icon()
	{
		return "eicon-post-slider";
	}

	public function get_categories(): array
	{
		return ['basic', 'general'];
	}

	public function get_keywords()
	{
		return ['advanced-slider', 'slide', 'slider', 'image-slider'];
	}

	public function get_style_depends(): array
	{
		return ['swiper', 'aes-slider-style'];
	}

	public function get_script_depends(): array
	{
		return ['swiper'];
	}

	public static function get_button_sizes()
	{
		return [
			'xs' => esc_html__('Extra Small', 'aes_slider'),
			'sm' => esc_html__('Small', 'aes_slider'),
			'md' => esc_html__('Medium', 'aes_slider'),
			'lg' => esc_html__('Large', 'aes_slider'),
			'xl' => esc_html__('Extra Large', 'aes_slider'),
		];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'aes_slider'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_image',
			[
				'label'   => esc_html__('Image', 'aes_slider'),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src()
				]
			]
		);

		$repeater->add_control(
			'slide_title',
			[
				'label'   => esc_html__('Title', 'aes_slider'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('John Doe', 'aes_slider'),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'slide_desc',
			[
				'label'   => esc_html__('Description', 'aes_slider'),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('CEO, Acme Inc.', 'aes_slider'),
				'dynamic' => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'slide_button_txt',
			[
				'label'       => esc_html__('Button Text', 'aes_slider'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'rows'        => 10,
				'default'     => esc_html__('Learn More', 'aes_slider'),
				'placeholder' => esc_html__('Type your button title here', 'aes_slider'),
				'dynamic'     => [
					'active' => true
				]
			]
		);

		$repeater->add_control(
			'slide_button_url',
			[
				'label'       => esc_html__('Link', 'aes_slider'),
				'type'        => \Elementor\Controls_Manager::URL,
				'options'     => ['url', 'is_external', 'nofollow'],
				'default'     => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true
				],
				'label_block' => true,
				'condition' => [
					'slide_button_txt!' => ''
				]
			]
		);

		$this->add_control(
			'slider',
			[
				'label'       => esc_html__('Slider', 'aes_slider'),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'slide_title'      => esc_html__('Jane Doe', 'aes_slider'),
						'slide_desc'       => esc_html__('CEO, Acme Inc.', 'aes_slider'),
						'slide_button_txt' => esc_html__('Learn More', 'aes_slider')
					],
					[
						'slide_title'      => esc_html__('John Smith', 'aes_slider'),
						'slide_desc'       => esc_html__('Marketing Director', 'aes_slider'),
						'slide_button_txt' => esc_html__('Learn More', 'aes_slider')
					],
					[
						'slide_title'      => esc_html__('Lisa Ray', 'aes_slider'),
						'slide_desc'       => esc_html__('Product Manager', 'aes_slider'),
						'slide_button_txt' => esc_html__('Learn More', 'aes_slider')
					]
				],
				'title_field' => '{{{ slide_title }}}'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_settings_section',
			[
				'label' => esc_html__('Slider Settings', 'aes_slider'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'slide_per_view',
			[
				'label' => esc_html__('Slide Per View', 'textdomain'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5,
				'step' => 1,
				'default' => 1,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__('Auto Play', 'textdomain'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'textdomain'),
				'label_off' => esc_html__('No', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_content_section',
			[
				'label' => esc_html__('Content', 'aes_slider'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'      => esc_html__('Item Width', 'aes_slider'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5
					],
					'%'  => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'    => [
					'unit' => '%',
					'size' => 32
				],
				'selectors'  => [
					'{{WRAPPER}} .ea-testimonial-container .testimonial' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label'      => esc_html__('Item Gap', 'aes_slider'),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5
					],
					'%'  => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10
				],
				'selectors'  => [
					'{{WRAPPER}} .ea-testimonial-container' => 'gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .ea-testimonial-container .testimonial'
			]
		);

		$this->add_control(
			'client_name_heading',
			[
				'label'     => esc_html__('Client Name', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

		$this->add_control(
			'client_name_margin',
			[
				'label'      => esc_html__('Margin', 'aes_slider'),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em', 'rem', 'custom'],
				'default'    => [
					'top'      => 2,
					'right'    => 0,
					'bottom'   => 2,
					'left'     => 0,
					'unit'     => 'px',
					'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .ea-testimonial-container .testimonial h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'client_name_color',
			[
				'label'     => esc_html__('Color', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ea-testimonial-container .testimonial h3' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'client_name_typo',
				'selector' => '{{WRAPPER}} .ea-testimonial-container .testimonial h3'
			]
		);

		$this->add_control(
			'client_designation_heading',
			[
				'label'     => esc_html__('Client Designation', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

		$this->add_control(
			'client_designation_color',
			[
				'label'     => esc_html__('Color', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ea-testimonial-container .testimonial .role' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'client_designation_typo',
				'selector' => '{{WRAPPER}} .ea-testimonial-container .testimonial .role'
			]
		);

		$this->add_control(
			'client_review_heading',
			[
				'label'     => esc_html__('Client Review', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after'
			]
		);

		$this->add_control(
			'client_review_color',
			[
				'label'     => esc_html__('Review Color', 'aes_slider'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ea-testimonial-container .testimonial .message' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'client_review_typo',
				'selector' => '{{WRAPPER}} .ea-testimonial-container .testimonial .message'
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		?>
		<?php if ($settings['slider']): ?>
			<div class="swiper ea-slider-container">
				<div class="swiper-wrapper ea-slider-wrapper">
					<?php foreach ($settings['slider'] as $slide): ?>
						<?php
						if (! empty($slide['slide_button_url']['url'])) {
							$this->add_link_attributes('slide_link', $slide['slide_button_url']);
						}
						?>
						<div class="swiper-slide" style="background-image: url('<?php echo esc_url($slide['slide_image']['url']); ?>')">
							<div class="slide-content">
								<h2><?php echo esc_html($slide['slide_title']); ?></h2>
								<p><?php echo esc_html($slide['slide_desc']); ?></p>
								<a href="<?php echo esc_html($slide['slide_button_url']['url']); ?>" <?php $this->print_render_attribute_string('slide_link'); ?>><?php echo esc_html($slide['slide_button_txt']); ?></a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Pagination -->
				<div class="swiper-pagination"></div>

				<!-- Navigation -->
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		<?php endif; ?>
		<?php
	}
}
