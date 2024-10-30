<?php

class GFDBM_GravityForm extends ET_Builder_Module {
	public $main_css_element = '%%order_class%%.gfdbm_gravity_form';
	public $slug             = 'gfdbm_gravity_form';
	public $vb_support       = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://treestarmarketing.com/',
		'author'     => 'Tree Star Marketing LLC',
		'author_uri' => 'https://treestarmarketing.com/',
	);

	public function init() {
		$this->name = esc_html__( 'Gravity Form', 'gfdbm-module-for-gravity-forms-in-divi-builder' );
	}

	public function get_fields() {
		return [
			'admin_label' => [
				'label'       => __( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => 'This will change the label of the module in the builder for easy identification.',
			],
			'gravityform_id' => [
				'label'       => esc_html__( 'Form ID', 'et_builder' ),
				'type'        => 'select',
				'options'     => $this->get_active_form_options(),
				'tab_slug'    => 'general',
				'toggle_slug' => 'main_content',
				'description' => esc_html__( 'Select the gravity form', 'et_builder' ),
				'default'     => $this->get_default( 'gravityform_id' ),
			],
			'title' => [
				'label'       => esc_html__( 'Show Title', 'et_builder' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'main_content',
				'description' => esc_html__( 'Select `Yes` to show title', 'et_builder' ),
				'default'     => $this->get_default( 'title' ),
			],
			'description' => [
				'label'       => esc_html__( 'Show Description', 'et_builder' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'main_content',
				'description' => esc_html__( 'Select `Yes` to show description', 'et_builder' ),
				'default'     => $this->get_default( 'description' ),
			],
			'ajax' => [
				'label'       => esc_html__( 'Enable Ajax', 'et_builder' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				],
				'tab_slug'    => 'general',
				'toggle_slug' => 'main_content',
				'description' => esc_html__( 'Select `Yes` to submit form via ajax', 'et_builder' ),
				'default'     => $this->get_default( 'ajax' ),
			],
			'tabindex' => [
				'label'          => esc_html__( 'Tab Index', 'et_builder' ),
				'type'           => 'range',
				'range_settings' => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				],
				'tab_slug'       => 'general',
				'toggle_slug'    => 'main_content',
				'description'    => esc_html__( 'Specify the starting tab index for the fields of this form.', 'et_builder' ),
				'allowed_units'  => [ '' ],
				'default_unit'   => '',
				'default'        => $this->get_default( 'tabindex' ),
			],
			'field_values' => [
				'label'       => esc_html__( 'Field Values', 'et_builder' ),
				'type'        => 'text',
				'tab_slug'    => 'general',
				'toggle_slug' => 'main_content',
				'description' => esc_html__( 'Specify the default field values. Example: field_values=’check=First Choice,Second Choice’.', 'et_builder' ),
				'default'     => $this->get_default( 'field_values' ),
			],
		];
	}

	/**
	 * Options for divi select field
	 */
	public function get_active_form_options() {
		$options = [
			'gf-0' => '- Select Gravity Form -',
		];

		if ( class_exists( '\\GFAPI' ) ) {
			$forms = \GFAPI::get_forms();
			foreach ( array_reverse( $forms ) as $form ) {
				$options[sprintf( 'gf-%s', $form['id'] )] = $form['title'];
			}
		}

		return $options;
	}

	/**
	 * Get default for given keys
	 */
	public function get_default( $key ) {
		$defaults = $this->get_default_attributes();
		return ( isset( $defaults[$key] ) ? $defaults[$key] : '' );
	}

	/**
	 * Get defaults
	 */
	public function get_default_attributes() {
		$defaults = [
			'gravityform_id' => 'gf-0',
			'title'          => 'on',
			'description'    => 'on',
			'ajax'           => 'off',
			'tabindex'       => '0',
			'field_values'   => '',
		];
		return $defaults;
	}

	public function get_advanced_fields_config() {
		return [
			'button' => [
				'next_button' => [
					'label'       => 'Next Button',
					'css'         => [
						'main'         => "{$this->main_css_element} .gform_page_footer .gform_next_button",
						'limited_main' => "{$this->main_css_element} .gform_page_footer .gform_next_button",
						'alignment'    => "{$this->main_css_element} .gform_page_footer .next_button.et_pb_button_wrapper",
					],
					'box_shadow' => [
						'css' => [
							'main'  => "{$this->main_css_element} .gform_page_footer .gform_next_button",
						],
					],
					'use_alignment' => true,
					'margin_padding' => [
						'css' => [
							'main'  => "{$this->main_css_element} .gform_page_footer .next_button.et_pb_button_wrapper .gform_next_button",
						],
					],
				],
				'previous_button' => [
					'label'       => 'Previous Button',
					'css'         => [
						'main'         => "{$this->main_css_element} .gform_page_footer .gform_previous_button",
						'limited_main' => "{$this->main_css_element} .gform_page_footer .gform_previous_button",
						'alignment'    => "{$this->main_css_element} .gform_page_footer .previous_button.et_pb_button_wrapper",
					],
					'box_shadow' => [
						'css' => [
							'main'  => "%%order_class%% .gform_page_footer .gform_previous_button",
						],
					],
					'use_alignment' => true,
					'margin_padding' => [
						'css' => [
							'main'  => "{$this->main_css_element} .gform_page_footer .previous_button.et_pb_button_wrapper .gform_previous_button",
						],
					],
				],
				'form_button' => [
					'label'       => 'Submit Button',
					'css'         => [
						'main'         => "{$this->main_css_element} .gform_button",
						'limited_main' => "{$this->main_css_element} .gform_button",
						'alignment'    => "{$this->main_css_element} .submit_button.et_pb_button_wrapper",
					],
					'box_shadow' => [
						'css' => [
							'main'  => "%%order_class%% .gform_button",
						],
					],
					'use_alignment' => true,
					'margin_padding' => [
						'css' => [
							'main'  => "{$this->main_css_element} .submit_button.et_pb_button_wrapper .gform_button",
						],
					],
				],
			],
			'borders' => [
				'default' => [
					'css' => [
						'main' => [
							'border_styles' => "{$this->main_css_element}",
							'border_radii'  => "{$this->main_css_element}",
						],
					],
					'defaults' => [
						'border_radii'  => 'on||||',
						'border_styles' => [
							'width' => '0px',
							'color' => '#ffffffff',
							'style' => 'solid',
						],
					],
				],
			],
			'text'       => false,
			'box_shadow' => [
				'default' => [
					'css' => [
						'main'      => "{$this->main_css_element}",
						'important' => 'all',
					],
				],
			],
			'filters' => [
				'css' => [
					'main' => "{$this->main_css_element}",
				],
			],
			'animation'      => false,
			'text_shadow'    => false,
			'max_width'      => false,
			'custom_margin'  => false,
			'margin_padding' => [
				'css' => [
					'main'      => "{$this->main_css_element}",
					'important' => 'all',
				],
			],
			'background' => [
				'css' => [
					'main'      => "{$this->main_css_element}",
					'important' => 'all',
				],
			],
			'fonts' => [
				'title' => [
					'sub_toggle'  => 'title',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper h3.gform_title",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#333333',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'font'        => [
						'default' => '|700',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '22',
					],
				],
				'description' => [
					'sub_toggle'  => 'description',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper span.gform_description",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'font'        => [
						'default' => '',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'label'                     => [
					'sub_toggle'  => 'label',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper label.gfield_label",
						'important' => 'all',
					],
					'font'        => [
						'default' => '|700',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'sub_label'                 => [
					'sub_toggle'  => 'sub_label',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper li.gfield div.ginput_complex label:not([class^=gfield_label])",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '12',
					],
				],
				'field_description'         => [
					'sub_toggle'  => 'field_description',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper li.gfield div.gfield_description:not([class*=\"gfield_consent_description\"])",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '12',
					],
				],
				'input_font'                => [
					'sub_toggle'  => 'input_font',
					'css'         => [
						'main'      => "{$this->main_css_element} .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {$this->main_css_element} .gform_wrapper ul.gform_fields li.gfield textarea, {$this->main_css_element} .gform_wrapper .gfield_checkbox li label, {$this->main_css_element} .gform_wrapper .gfield_radio li label, {$this->main_css_element} .gform_wrapper li.gfield select",
						'important' => 'all',
					],
					'font'        => [],
					'text_color'  => [
						'default' => '#4e4e4e',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'checkbox_radio_field'      => [
					'sub_toggle'  => 'checkbox_radio_field',
					'css'         => [
						'main'      => "{$this->main_css_element} .gform_wrapper div.ginput_container_checkbox .gfield_checkbox li label, {$this->main_css_element} .gform_wrapper div.ginput_container_radio .gfield_radio li label",
						'important' => 'all',
					],
					'font'        => [],
					'text_color'  => [
						'default' => '#4e4e4e',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'placeholder'               => [
					'css' => [
						'main'      => "{$this->main_css_element} .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])::placeholder, {$this->main_css_element} .gform_wrapper ul.gform_fields li.gfield textarea::placeholder, {$this->main_css_element} .gform_wrapper .gfield_checkbox li label::placeholder, {$this->main_css_element} .gform_wrapper .gfield_radio li label::placeholder, {$this->main_css_element} .gform_wrapper li.gfield select::placeholder",
						'important' => 'all',
					],
				],
				'consent_checkbox'          => [
					'sub_toggle'  => 'consent_checkbox',
					'css'         => [
						'main'      => "{$this->main_css_element} .gform_wrapper li.gfield div.ginput_container_consent label",
						'important' => 'all',
					],
					'font'        => [],
					'text_color'  => [
						'default' => '#4e4e4e',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'consent_description'       => [
					'sub_toggle'  => 'consent_description',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper li.gfield div.gfield_description.gfield_consent_description",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
				],
				'validation_error_heading'  => [
					'sub_toggle'  => 'validation_error_heading',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper div.validation_error",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#790000',
					],
					'text_align'  => [
						'default' => 'center',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '14',
					],
					'font'        => [
						'default' => '|700',
					],
				],
				'field_validation_error'    => [
					'sub_toggle'  => 'field_validation_error',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper li.gfield.gfield_error div.gfield_description.validation_message",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#790000',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '12',
					],
					'font'        => [
						'default' => '|700',
					],
				],
				'confirmation_message'      => [
					'sub_toggle'  => 'confirmation_message',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_confirmation_wrapper div.gform_confirmation_message",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#000000',
					],
					'text_align'  => [
						'default' => 'center',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '20',
					],
					'font'        => [
						'default' => '|700',
					],
				],
				'progress_bar_title'        => [
					'sub_toggle'  => 'progress_bar_title',
					'css'         => [
						'main'      => "{$this->main_css_element} h3.gf_progressbar_title",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#333333',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '12',
					],
				],
				'section_field_title'       => [
					'sub_toggle'  => 'section_field_title',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper .gfield.gsection .gsection_title",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#333333',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'font'        => [
						'default' => '|700',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '17',
					],
				],
				'section_field_description' => [
					'sub_toggle'  => 'section_field_title',
					'css'         => [
						'main'      => "{$this->main_css_element} div.gform_wrapper .gfield.gsection .gsection_description",
						'important' => 'all',
					],
					'text_color'  => [
						'default' => '#666666',
					],
					'text_align'  => [
						'default' => 'left',
					],
					'font'        => [
						'default' => '',
					],
					'line_height' => [
						'default' => '1',
					],
					'font_size'   => [
						'default' => '11',
					],
				],
			],
			'link_options'   => false,
		];
	}

	public function get_custom_css_fields_config() {
		return [
			'title'                    => [
				'label'    => esc_html__( 'Form Title', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper h3.gform_title",
			],
			'description'              => [
				'label'    => esc_html__( 'Form Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper span.gform_description",
			],
			'label'                    => [
				'label'    => esc_html__( 'Label', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper label.gfield_label",
			],
			'sub_label'                => [
				'label'    => esc_html__( 'Sub Label', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper li.gfield div.ginput_complex label:not([class^=\"gfield_label\"])",
			],
			'field_description'        => [
				'label'    => esc_html__( 'Field Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper li.gfield div.gfield_description:not([class*=\"gfield_consent_description\"])",
			],
			'text_field'               => [
				'label'    => esc_html__( 'Text Field', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])",
			],
			'textarea_field'           => [
				'label'    => esc_html__( 'Textarea Field', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper textarea",
			],
			'select_field'             => [
				'label'    => esc_html__( 'Select Field', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper select",
			],
			'checkbox_radio_field'     => [
				'label'    => esc_html__( 'Checkbox/Radio Field', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper input[type=checkbox], {$this->main_css_element} .gform_wrapper input[type=radio]",
			],
			'checkbox_radio_text'      => [
				'label'    => esc_html__( 'Checkbox Radio Options Text', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper div.ginput_container_checkbox .gfield_checkbox li label, {$this->main_css_element} .gform_wrapper div.ginput_container_radio .gfield_radio li label",
			],
			'consent_checkbox_label'   => [
				'label'    => esc_html__( 'Consent Checkbox Label', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_wrapper li.gfield div.ginput_container_consent label",
			],
			'consent_description'      => [
				'label'    => esc_html__( 'Consent Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper li.gfield div.gfield_description.gfield_consent_description",
			],
			'validation_error_heading' => [
				'label'    => esc_html__( 'Validation Error Heading', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper div.validation_error",
			],
			'validation_message'       => [
				'label'    => esc_html__( 'Field Validation Message', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_wrapper li.gfield.gfield_error div.gfield_description.validation_message",
			],
			'next_button'      => [
				'label'    => esc_html__( 'Next Button', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_next_button",
			],
			'previous_button'   => [
				'label'    => esc_html__( 'Previous Button', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_previous_button",
			],
			'form_button'       => [
				'label'    => esc_html__( 'Submit Button', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} .gform_button",
			],
			'confirmation_wrapper'     => [
				'label'    => esc_html__( 'Submitted Form Confirmation Wrapper', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_confirmation_wrapper",
			],
			'confirmation_message'     => [
				'label'    => esc_html__( 'Submitted Form Confirmation Message', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gform_confirmation_wrapper div.gform_confirmation_message",
			],
			'progress_bar_title'       => [
				'label'    => esc_html__( 'Progress Bar Title', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} h3.gf_progressbar_title",
			],
			'progress_bar_percentage'  => [
				'label'    => esc_html__( 'Progress Bar Percentage', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				'selector' => "{$this->main_css_element} div.gf_progressbar_wrapper div.gf_progressbar div.gf_progressbar_percentage",
			],
		];
	}

	public function get_settings_modal_toggles() {
		return [
			'general' => [
				'toggles' => [
					'main_content' => esc_html__( 'Shortcode Parameters', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				],
			],
			'advanced' => [
				'toggles' => [
					'title'                     => esc_html__( 'Form Title', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'description'               => esc_html__( 'Form Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'field_container'           => esc_html__( 'Field Wrapper', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'label'                     => esc_html__( 'Label', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'sub_label'                 => esc_html__( 'Sub Label', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'field_description'         => esc_html__( 'Field Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'input_container'           => esc_html__( 'Input Wrapper', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'input_font'                => esc_html__( 'Input General', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'text_input'                => esc_html__( 'Text/Textarea', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'select_field'              => esc_html__( 'Select', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'checkbox_radio_field'      => esc_html__( 'Checkbox/Radio', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'placeholder'               => esc_html__( 'Input Placeholder Text', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'section_field'             => esc_html__( 'Section Field Wrapper', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'section_field_title'       => esc_html__( 'Section Field Title', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'section_field_description' => esc_html__( 'Section Field Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'consent_checkbox'          => esc_html__( 'Consent Checkbox', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'consent_description'       => esc_html__( 'Consent Description', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'validation_error_heading'  => esc_html__( 'Validation Error Heading', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'field_validation_error'    => esc_html__( 'Field Validation Error', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'footer'                    => esc_html__( 'Footer', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'progress_bar_title'        => esc_html__( 'Progress Bar Title', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'progress_bar'              => esc_html__( 'Progress Bar', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'validation_error_field'    => esc_html__( 'Validation Error Field', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'form_button'               => esc_html__( 'Button', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
					'confirmation_message'      => esc_html__( 'Confirmation Message', 'gfdbm-module-for-gravity-forms-in-divi-builder' ),
				],
			],
		];
	}

	/**
	* Default button style when advanced styles are off.
	*/
	public function set_button_default_on_custom_disabled( $render_slug, $main_selector ) {
		ET_Builder_Element::set_style( $render_slug, [
			'selector'    => "{$main_selector} .et_pb_button",
			'declaration' => sprintf( 'padding: 0.3em 1em !important; font-size: 20px !important; color:#ffffff; background:#000000;border-radius: 3px; border: 2px solid #000000;' ),
		] );
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$defaults = wp_parse_args( $attrs, $this->get_default_attributes() );
		foreach ( $defaults as $key => $value ) {
			if ( isset( $this->props[$key] ) and empty($this->props[$key]) ) {
				$this->props[$key] = $value;
			}
		}
		$props = wp_parse_args( $this->props, $defaults );

		$gravityform_id = str_replace( 'gf-', '', $props['gravityform_id'] );
		$gravityform_shortcode = sprintf(
			'[gravityform id=%1$s title=%2$s description=%3$s ajax=%4$s tabindex=%5$s /]',
			$gravityform_id,
			( $props['title'] == 'on' ? 'true' : 'false' ),
			( $props['description'] == 'on' ? 'true' : 'false' ),
			( $props['ajax'] == 'on' ? 'true' : 'false' ),
			$props['tabindex']
		);

		return do_shortcode( $gravityform_shortcode );
	}
}

new GFDBM_GravityForm;
