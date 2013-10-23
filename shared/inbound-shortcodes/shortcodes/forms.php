<?php
/**
*   Inbound Forms Shortcode Options
*   Forms code found in /shared/classes/form.class.php
*/
	$shortcodes_config['forms'] = array(
		'no_preview' => false,
		'options' => array(
			'form_name' => array(
				'name' => __('Form Name<span class="small-required-text">*</span>', INBOUND_LABEL),
				'desc' => __('This is not shown to visitors', INBOUND_LABEL),
				'type' => 'text',
				'placeholder' => "Example: XYZ Whitepaper Download",
				'std' => '',
				'class' => 'main-form-settings',
			),
			/*'confirmation' => array(
						'name' => __('Form Layout', INBOUND_LABEL),
						'desc' => __('Choose Your Form Layout', INBOUND_LABEL),
						'type' => 'select',
						'options' => array(
							"redirect" => "Redirect After Form Completion", 
							"text" => "Display Text on Same Page",
							),
						'std' => 'redirect'
			),*/
			'redirect' => array(
				'name' => __('Redirect URL<span class="small-required-text">*</span>', INBOUND_LABEL),
				'desc' => __('Where do you want to send people after they fill out the form?', INBOUND_LABEL),
				'type' => 'text',
				'placeholder' => "http://www.yoursite.com/thank-you",
				'std' => '',
				'reveal_on' => 'redirect',
				'class' => 'main-form-settings',
			),
			/*'thank_you_text' => array(
					'name' => __('Field Description <span class="small-optional-text">(optional)</span>',  INBOUND_LABEL),
					'desc' => __('Put field description here.',  INBOUND_LABEL),
					'type' => 'textarea',
					'std' => '',
					'class' => 'advanced',
					'reveal_on' => 'text' 
			), */
			'notify' => array(
				'name' => __('Notify on Form Completions<span class="small-required-text">*</span>', INBOUND_LABEL),
				'desc' => __('Who should get admin notifications on this form?', INBOUND_LABEL),
				'type' => 'text',
				'placeholder' => "youremail@email.com",
				'std' => '',
				'class' => 'main-form-settings',
			),
			'heading_design' => array(
					'name' => __('Name Name Name',  INBOUND_LABEL),
					'desc' => __('Layout Options',  INBOUND_LABEL),
					'type' => 'helper-block',
					'std' => '',
					'class' => 'main-design-settings',
			),
			'layout' => array(
						'name' => __('Form Layout', INBOUND_LABEL),
						'desc' => __('Choose Your Form Layout', INBOUND_LABEL),
						'type' => 'select',
						'options' => array(
							"vertical" => "Vertical", 
							"horizontal" => "Horizontal",
							),
						'std' => 'inline',
						'class' => 'main-design-settings',
			),		
			'labels' => array(
						'name' => __('Label Alignment', INBOUND_LABEL),
						'desc' => __('Choose Label Layout', INBOUND_LABEL),
						'type' => 'select',
						'options' => array(
							"top" => "Labels on Top", 
							"bottom" => "Labels on Bottom",
							"inline" => "Inline",
							"placeholder" => "Use HTML5 Placeholder text only"
							),
						'std' => 'top',
						'class' => 'main-design-settings',
					),
			'submit' => array(
				'name' => __('Submit Button Text', INBOUND_LABEL),
				'desc' => __('Enter the text you want to show on the submit button. (or a link to a custom submit button image)', INBOUND_LABEL),
				'type' => 'text',
				'std' => 'Submit',
				'class' => 'main-design-settings',
			),
			'width' => array(
				'name' => __('Custom Width', INBOUND_LABEL),
				'desc' => __('Enter in pixel width or % width. Example: 400 <u>or</u> 100%', INBOUND_LABEL),
				'type' => 'text',
				'std' => '',
				'class' => 'main-design-settings',
			),
		),
		'child' => array(
			'options' => array(
				'label' => array(
					'name' => __('Field Label',  INBOUND_LABEL),
					'desc' => '',
					'type' => 'text',
					'std' => '',
					'placeholder' => "Enter the Form Field Label. Example: First Name"
				),
				'field_type' => array(
					'name' => __('Field Type', INBOUND_LABEL),
					'desc' => __('Select an form field type', INBOUND_LABEL),
					'type' => 'select',
					'options' => array(
						"text" => "Single Line Text", 
						"textarea" => "Paragraph Text",
						'dropdown' => "Dropdown Options",
						"radio" => "Radio Select",
						"number" => "Number",
						"checkbox" => "Checkbox",
						//"html-block" => "HTML Block",
						"date" => "Date Field",
						"time" => "Time Field",
						'hidden' => "Hidden Field",
						//'file_upload' => "File Upload",
						//'editor' => "HTML Editor"
						//"multi-select" => "multi-select"
						),
					'std' => ''
				),

				'dropdown_options' => array(
					'name' => __('Dropdown choices',  INBOUND_LABEL),
					'desc' => __('Enter Your Dropdown Options. Separate by commas.',  INBOUND_LABEL),
					'type' => 'text',
					'std' => '',
					'placeholder' => 'Choice 1, Choice 2, Choice 3',
					'reveal_on' => 'dropdown' // on select choice show this
				),
				'radio_options' => array(
					'name' => __('Radio Choices',  INBOUND_LABEL),
					'desc' => __('Enter Your Radio Options. Separate by commas.',  INBOUND_LABEL),
					'type' => 'text',
					'std' => '',
					'placeholder' => 'Choice 1, Choice 2',
					'reveal_on' => 'radio' // on select choice show this
				),
				'html_block_options' => array(
					'name' => __('HTML Block',  INBOUND_LABEL),
					'desc' => __('This is a raw HTML block in the form. Insert text/HTML',  INBOUND_LABEL),
					'type' => 'textarea',
					'std' => '',
					'reveal_on' => 'html-block' // on select choice show this
				),
				'helper' => array(
					'name' => __('Field Description <span class="small-optional-text">(optional)</span>',  INBOUND_LABEL),
					'desc' => __('<span class="show-advanced-fields">Show advanced fields</span>',  INBOUND_LABEL),
					'type' => 'helper-block',
					'std' => '',
					'class' => '',
				),
				'required' => array(
					'name' => __('Required Field? <span class="small-optional-text">(optional)</span>', INBOUND_LABEL),
					'checkbox_text' => __('Check to make field required', INBOUND_LABEL),
					'desc' => '',
					'type' => 'checkbox',
					'std' => '0',
					'class' => 'advanced',
				),
				'placeholder' => array(
					'name' => __('Field Placeholder <span class="small-optional-text">(optional)</span>',  INBOUND_LABEL),
					'desc' => __('Put field placeholder text here. Only works for normal text inputs',  INBOUND_LABEL),
					'type' => 'text',
					'std' => '',
					'class' => 'advanced',
				),
				'description' => array(
					'name' => __('Field Description <span class="small-optional-text">(optional)</span>',  INBOUND_LABEL),
					'desc' => __('Put field description here.',  INBOUND_LABEL),
					'type' => 'textarea',
					'std' => '',
					'class' => 'advanced',
				),
				
				'hidden_input_options' => array(
					'name' => __('Dynamic Field Filling',  INBOUND_LABEL),
					'desc' => __('Enter Your Dynamic URL parameter',  INBOUND_LABEL),
					'type' => 'text',
					'std' => '',
					'placeholder' => 'enter dynamic url parameter example: utm_campaign ',
					'class' => 'advanced',
					//'reveal_on' => 'hidden' // on select choice show this
				),
			),
			'shortcode' => '[inbound_field label="{{label}}" type="{{field_type}}" description="{{description}}" required="{{required}}" dropdown="{{dropdown_options}}" radio="{{radio_options}}" placeholder="{{placeholder}}" html="{{html_block_options}}" dynamic="{{hidden_input_options}}"]',
			'clone' => __('Add Another Field',  INBOUND_LABEL )
		),
		'shortcode' => '[inbound_form name="{{form_name}}" redirect="{{redirect}}" layout="{{layout}}" labels="{{labels}}" submit="{{submit}}" width="{{width}}"]{{child}}[/inbound_form]',
		'popup_title' => __('Insert Inbound Form Shortcode',  INBOUND_LABEL)
	);

/* 	Shortcode moved to shared form class */
		