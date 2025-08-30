<?php

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

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
		//content section start
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'aes_slider'),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		//slides repeater start
		$repeater = new Repeater();

		$repeater->start_controls_tabs('aes_slides_repeater');

		//start Tab - Background
		$repeater->start_controls_tab('background_tab', ['label' => esc_html__('Background', 'aes_slider')]);

		/* TO-DO
		*
		* Slide Background Type - CHOOSE control
		* types - Classic(color/image), Gradient, Video
		*
		*/


		$repeater->add_control(
			'aes_slide_bg_color',
			[
				'label' => esc_html__('Background Color', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'default' => '#888888',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-bg' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'aes_slide_bg_image',
			[
				'label' => _x('Image', 'Background Control', 'aes_slider'),
				'type' => Controls_Manager::MEDIA,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-bg' => 'background-image: url({{URL}})',
				],
				'default' => [
					'url' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'slide_bg_size',
			[
				'label' => _x('Background size', 'Background Control', 'aes_slider'),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => _x('Cover', 'Background Control', 'aes_slider'),
					'contain' => _x('Contain', 'Background Control', 'aes_slider'),
					'auto' => _x('Auto', 'Background Control', 'aes_slider')
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-bg' => 'background-size: {{VALUE}}'
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'aes_slide_bg_image[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		//background_overlay - switcher control
		$repeater->add_control(
			'slide_bg_overlay',
			[
				'label' => _x( 'Background Overlay', 'Background Control', 'aes_slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'aes_slide_bg_image[url]!' => '',
				],
			]
		);

		//overlay color - color control
		$repeater->add_control(
			'slide_bg_overlay_color',
			[
				'label' => esc_html__('Color', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-bg-overlay' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_bg_overlay',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//overlay blend mode - select control
		$repeater->add_control(
			'overlay_blend_mode',
			[
				'label' => esc_html__('Blend Mode', 'aes_slider'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'aes_slider' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hard-light' => 'Hard Light',
					'soft-light' => 'Soft Light',
					'difference' => 'Difference',
					'plus-darker' => 'Plus Darker',
					'plus-lighter' => 'Plus Lighter',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_bg_overlay',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();
		//end Tab - Background


		//start Tab - Content
		$repeater->start_controls_tab('content_tab', ['label' => esc_html__('Content', 'aes_slider')]);

		$repeater->add_control(
			'aes_slide_title',
			[
				'label' => esc_html__('Title', 'aes_slider'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Slide Title', 'aes_slider'),
				'label_block' => true,
				'dynamic' => ['active' => true,],
			]
		);

		$repeater->add_control(
			'aes_slide_description',
			[
				'label' => esc_html__('Description', 'aes_slider'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'aes_slider'),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'aes_slide_button_txt',
			[
				'label' => esc_html__('Button Text', 'aes_slider'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Click Here', 'aes_slider'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'aes_slide_button_url',
			[
				'label' => esc_html__( 'Link', 'aes_slider' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow', 'custom_attributes' ],
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
					'custom_attributes' => '',
				],
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'aes_slide_button_txt',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();
		//end Tab - Content


		//start Tab - Style
		$repeater->start_controls_tab(
			'style_tab',
			[
				'label' => esc_html__('Style', 'aes_slider'),
			],
		);

		//custom slide styles - SWITCHER control
		$repeater->add_control(
			'slide_custom_style',
			[
				'label' => esc_html__('Custom Style', 'aes_slider'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		//inner content positon - TAB_CONTENT
		
			//horizontal position - CHOOSE control
			$repeater->add_responsive_control(
				'slide_horizontal_position',
				[
					'label'=> esc_html__('Horizontal Position', 'aes_slider'),
					'type'=> Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title'=> esc_html__('Left','aes_slider'),
							'icon'=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aes_slider' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'aes_slider' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => '{{VALUE}}',
					],
					'selectors_dictionary' => [
						'left' => 'margin-right: auto',
						'center' => 'margin: 0 auto',
						'right' => 'margin-left: auto',
					],
					'conditions' => [
						'terms' => [
							[
								'name' => 'slide_custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);

			//vertical position - CHOOSE control
			$repeater->add_responsive_control(
				'slide_vertical_position',
				[
					'label'=> esc_html__('Vertical Position', 'aes_slider'),
					'type'=> Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title'=> esc_html__('Left','aes_slider'),
							'icon'=> 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aes_slider' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'aes_slider' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-inner' => 'align-items: {{VALUE}}',
					],
					'selectors_dictionary' => [
						'top' => 'flex-start',
						'middle' => 'center',
						'bottom' => 'flex-end',
					],
					'conditions' => [
						'terms' => [
							[
								'name' => 'slide_custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);

			//text align - CHOOSE control
			$repeater->add_responsive_control(
			'slide_text_align',
			[
					'label' => esc_html__( 'Align Text', 'aes_slider' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'aes_slider' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'aes_slider' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'aes_slider' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'text-align: {{VALUE}};',
					],
					'conditions' => [
						'terms' => [
							[
								'name' => 'slide_custom_style',
								'value' => 'yes',
							],
						],
					],
				]
			);
		

		//slide title color - COLOR control
		$repeater->add_control(
			'slide_title_color',
			[
				'label' => esc_html__('Title Color', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-title' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);
		
		//slide description color - COLOR control
		$repeater->add_control(
			'slide_description_color',
			[
				'label' => esc_html__('Description Color', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-description' => 'color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);
		
		//text shadow - Group_Control_Text_Shadow {Move it to Style Tab}

		//slide content
		//inner content bg color - COLOR control
		$repeater->add_control(
			'slide_content_bg_color',
			[
				'label' => esc_html__('Content Background', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'default' => '#00000099',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'background-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//inner content padding - DIMENSIONS control
		$repeater->add_responsive_control(
			'slide_content_padding',
			[
				'label' => esc_html__( 'Padding', 'aes_slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default' => [
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//inner content border type - SELECT control
		$repeater->add_control(
			'slide_content_border_type',
			[
				'label' => esc_html__('Border Type', 'aes_slider'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__('None', 'aes_slider'),
					'solid' => 'Solid',
					'dashed' => 'Dashed',
					'dotted' => 'Dotted',
					'double' => 'Double',
					'grove' => 'Grove',
					'inset' => 'Inset'
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'border-style: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//border color - COLOR control
		$repeater->add_control(
			'slide_content_border_color',
			[
				'label' => esc_html__('Border Color', 'aes_slider'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'border-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
						[
							'name' => 'slide_content_border_type',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		//border width - DIMENSIONS control
		$repeater->add_responsive_control(
			'slide_border_width',
			[
				'label' => esc_html__('Border Width', 'aes_slider'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
						[
							'name' => 'slide_content_border_type',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
				]
		);
			
		//inner content border radius - DIMENSIONS control
		$repeater->add_responsive_control(
			'slide_border_radius',
			[
				'label' => esc_html__('Border Radius', 'aes_slider'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default' => [
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .aes-slide-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//backdrop blur - SLIDER control
		$repeater->add_control(
			'slide_content_backdrop_filter',
			[
				'label' => esc_html__('Backdrop Blur', 'aes_slider'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '20',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .aes-slide-contents' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slide_custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);
		

		$repeater->end_controls_tab();
		//end Tab - Style

		$repeater->end_controls_tabs();
		//end repeater

		
		//Default slides
		$this->add_control(
			'aes_slides',
			[
				'label'       => esc_html__('Slides', 'aes_slider'),
				'type'        => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'aes_slide_title'      => esc_html__('Slide 1 Title', 'aes_slider'),
						'aes_slide_description'       => esc_html__('Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'aes_slider'),
						'aes_slide_button_txt' => esc_html__('Click Here', 'aes_slider'),
						'aes_slide_bg_color' => '#888888',
						'aes_slide_bg_image' => [
							'url' => '',
						],
						
					],
					[
						'aes_slide_title'      => esc_html__('Slide 2 Title', 'aes_slider'),
						'aes_slide_description'       => esc_html__('Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'aes_slider'),
						'aes_slide_button_txt' => esc_html__('Click Here', 'aes_slider'),
						'aes_slide_bg_color' => '#4054b2',
						'aes_slide_bg_image' => [
							'url' => '',
						],
					]
				],
				'title_field' => '{{{ aes_slide_title }}}'
			]
		);


		//slide content max-width
		$this->add_responsive_control(
			'aes_slide_content_max_width',
			[
				'label' => esc_html__('Content Max Width', 'aes_slider'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '66',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .aes-slide-contents' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		//slider width
		$this->add_responsive_control(
			'aes_slider_width',
			[
				'label' => esc_html__('Slider Width', 'aes_slider'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '800',
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .aes-slider-container' => 'width: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slider_aspect_ratio',
							'value' => '',
						],
					],
				],
			]
		);
		
		//slider height
		$this->add_responsive_control(
			'aes_slider_height',
			[
				'label' => esc_html__('Slider Height', 'aes_slider'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1800,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '450',
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .aes-slider-container' => 'height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slider_aspect_ratio',
							'value' => '',
						],
					],
				],
			]
		);
		
		//slider aspect ratio - switcher control
		$this->add_control(
			'slider_aspect_ratio',
			[
				'label' => esc_html__( 'Maintain Aspect Ratio', 'aes_slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		//ratio width - text input control
		$this->add_responsive_control(
			'aspect_ratio',
			[
				'label' => esc_html__('Ratio', 'aes_slider'),
				'type' => Controls_Manager::TEXT,
				'default' => '16/9',
				'selectors' => [
					'{{WRAPPER}} .aes-slider-container' => 'aspect-ratio: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slider_aspect_ratio',
							'value' => 'yes',
						],
					],
				],
			]
		);

		//ratio height - text input control
		// $this->add_responsive_control(
		// 	'aspect_ratio_height',
		// 	[
		// 		'label' => esc_html__('Height', 'aes_slider'),
		// 		'type' => Controls_Manager::TEXT,
		// 		'default' => 9,
		// 		'conditions' => [
		// 			'terms' => [
		// 				[
		// 					'name' => 'slider_aspect_ratio',
		// 					'value' => 'yes',
		// 				],
		// 			],
		// 		],
		// 	]
		// );
		

		$this->end_controls_section();
		//content section end


		//slider settings section start
		$this->start_controls_section(
			'slider_settings_section',
			[
				'label' => esc_html__('Slider Settings', 'aes_slider'),
				'tab'   => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_responsive_control(
			'slide_per_view',
			[
				'label' => esc_html__('Slide Per View', 'textdomain'),
				'type' => Controls_Manager::NUMBER,
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
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'textdomain'),
				'label_off' => esc_html__('No', 'textdomain'),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
		//slider settings section end

	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
?>
		<?php if ($settings['aes_slides']): 
		// echo '<pre>';
		// print_r($settings);
		// echo '</pre>';
			?>
			<div class="swiper aes-slider-container" >
				<div class="swiper-wrapper aes-slides">
					<?php foreach ($settings['aes_slides'] as $slide):
					?>
						<div class="elementor-repeater-item-<?= $slide['_id'] ?> swiper-slide">
							<div class="aes-slide-bg" role="img"></div>
							<div class="aes-slide-bg-overlay"></div>
							<div class="aes-slide-inner">
								<div class="aes-slide-contents">
									<div class="aes-slide-title">Slide 1 Heading</div>
									<div class="aes-slide-description">Lorem ipsum dolor sit amet consectetur adipiscing elit dolor</div>
									<a href="http://www.google.com" class="aes-slide-button">Click Here</a>
								</div>
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
