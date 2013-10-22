<?php
/**
*   Inbound Forms Shortcode
*/

/* 	Shortcode generator config
 * 	----------------------------------------------------- */

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
				'std' => '',
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
		'shortcode' => '[inbound_form_test name="{{form_name}}" redirect="{{redirect}}" layout="{{layout}}" labels="{{labels}}" submit="{{submit}}" width="{{width}}"]{{child}}[/inbound_form_test]',
		'popup_title' => __('Insert Inbound Form Shortcode',  INBOUND_LABEL)
	);

/* 	Add shortcode
 * 	----------------------------------------------------- */
	add_shortcode('inbound_form_test', 'inbound_form_test_function');
	
	function inbound_form_test_function( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'name' => '',
			'layout' => '',
			'labels' => '',
			'width' => '',
			'redirect' => '',
			'submit' => 'Submit'
		), $atts));
		
		$form_name = $name;
		$form_layout = $layout;
		$form_labels = $labels;
		$form_labels_class = (isset($form_labels)) ? "inbound-label-".$form_labels : 'inbound-label-inline';
		$submit_button = ($submit != "") ? $submit : 'Submit';


		// Check for image in submit button option
		if (preg_match('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i',$submit_button)) {
			$submit_button_type = 'style="background:url('.$submit_button.') no-repeat;color: rgba(0, 0, 0, 0);border: none;box-shadow: none;';
		} else {
			$submit_button_type = '';
		}
		
		/* Sanitize width input */
		if (preg_match('/px/i',$width)) {
			$fixed_width = str_replace("px", "", $width);
	    	$width_output = "width:" . $fixed_width . "px;";
		} elseif (preg_match('/%/i',$width)) {
			$fixed_width_perc = str_replace("%", "", $width);
	    	$width_output = "width:" . $fixed_width_perc . "%;";
		} else {
			$width_output = "width:" . $width . "px;";
		}
		
		$form_width = ($width != "") ? $width_output : '';
		
		//if (!preg_match_all("/(.?)\[(inbound_field)\b(.*?)(?:(\/))?\](?:(.+?)\[\/inbound_field\])?(.?)/s", $content, $matches)) {
		if (!preg_match_all('/(.?)\[(inbound_field)(.*?)\]/s',$content, $matches)) {
			return '';
		} 
		
		else {

			for($i = 0; $i < count($matches[0]); $i++) {
				$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
			}
			// matches are $matches[3][$i]['label']

			$clean_form_id = preg_replace("/[^A-Za-z0-9 ]/", '', trim($name));
			$form_id = strtolower(str_replace(array(' ','_'),'-',$clean_form_id));

			$form = '<!-- This Inbound Form is Automatically Tracked -->';
        	$form .= '<div id="inbound-form-wrapper" class="">';
        	$form .= '<form class="inbound-now-form wpl-track-me" method="post" id="'.$form_id.'" action="" style="'.$form_width.'">';
        	$main_layout = ($form_layout != "") ? 'inbound-'.$form_layout : 'inbound-normal';
				for($i = 0; $i < count($matches[0]); $i++) {

					$label = (isset($matches[3][$i]['label'])) ? $matches[3][$i]['label'] : '';
					$clean_label = preg_replace("/[^A-Za-z0-9 ]/", '', trim($label));
					$formatted_label = strtolower(str_replace(array(' ','_'),'-',$clean_label));
					$field_placeholder = (isset($matches[3][$i]['placeholder'])) ? $matches[3][$i]['placeholder'] : '';

					$placeholer_use = ($field_placeholder != "") ? $field_placeholder : $label;
					
					if ($field_placeholder != "") {
						$form_placeholder =	"placeholder='".$placeholer_use."'";
					} else if (isset($form_labels) && $form_labels === "placeholder") {
						$form_placeholder =	"placeholder='".$placeholer_use."'";
					} else {
						$form_placeholder = "";
					}

					$description_block = (isset($matches[3][$i]['description'])) ? $matches[3][$i]['description'] : '';
					$required = (isset($matches[3][$i]['required'])) ? $matches[3][$i]['required'] : '0';
					$req = ($required === '1') ? 'required' : '';
					$req_label = ($required === '1') ? '<span class="inbound-required">*</span>' : '';
					$field_name = strtolower(str_replace(array(' ','_'),'-',$label));

		/* Map Common Fields */
		(preg_match( '/Email|e-mail|email/i', $label, $email_input)) ? $email_input = " inbound-email" : $email_input = "";

        // Match Phone
        (preg_match( '/Phone|phone number|telephone/i', $label, $phone_input)) ? $phone_input = " inbound-phone" : $phone_input = "";
          
        // match name or first name. (minus: name=, last name, last_name,) 
        (preg_match( '/(?<!((last |last_)))name(?!\=)/im', $label, $first_name_input)) ? $first_name_input = " inbound-first-name" : $first_name_input =  "";

        // Match Last Name
        (preg_match( '/(?<!((first)))(last name|last_name|last)(?!\=)/im', $label, $last_name_input)) ? $last_name_input = " inbound-last-name" : $last_name_input =  "";

         $input_classes = $email_input . $first_name_input . $last_name_input . $phone_input;
          			
					$type = (isset($matches[3][$i]['type'])) ? $matches[3][$i]['type'] : '';
						$form .= '<div class="inbound-field '.$main_layout.' label-'.$form_labels_class.'">';
					if ($type != 'hidden' && $form_labels != "bottom" || $type === "radio"){	
                    	$form .= '<label class="inbound-label '.$formatted_label.' '.$form_labels_class.' inbound-input-'.$type.'">' . $matches[3][$i]['label'] . $req_label . '</label>';
                    }	
          			if ($type === 'textarea'){
          				$form .=  '<textarea class="inbound-input inbound-input-textarea" name="'.$field_name.'" id="in_'.$field_name.' '.$req.'"/></textarea>'; 	
          			} else if ($type === 'dropdown'){
          				$dropdown_fields = array();
						$dropdown = $matches[3][$i]['dropdown'];
						$dropdown_fields = explode(",", $dropdown);
						$form .= '<select name="'. $field_name .'" id="">';
						foreach ($dropdown_fields as $key => $value) { 
							$dropdown_val = strtolower(str_replace(array(' ','_'),'-',$value));
							$form .= '<option value="'. $dropdown_val .'">'. $value .'</option>';
						}
						$form .= '</select>';
          			} else if ($type === 'radio'){
          				$radio_fields = array();
						$radio = $matches[3][$i]['radio'];
						$radio_fields = explode(",", $radio);
						// $clean_radio = str_replace(array(' ','_'),'-',$value) // clean leading spaces. finish
						foreach ($radio_fields as $key => $value) { 
							$radio_val_trimmed =  trim($value);
							$radio_val =  strtolower(str_replace(array(' ','_'),'-',$radio_val_1));
							$form .= '<span class="radio-'.$main_layout.' radio-'.$form_labels_class.'"><input type="radio" name="'. $field_name .'" value="'. $radio_val .'">'. $radio_val_trimmed .'</span>';
						}
					} else if ($type === 'html-block'){	
							$html = $matches[3][$i]['html'];
							echo $html;
							$form .= "<div>" . $html . "</div>";

					} else if ($type === 'editor'){	
						//wp_editor(); // call wp editor
          			} else {
          				$hidden_param = (isset($matches[3][$i]['dynamic'])) ? $matches[3][$i]['dynamic'] : '';
          				$dynamic_value = (isset($_GET[$hidden_param])) ? $_GET[$hidden_param] : '';
		           		$form .=  '<input class="inbound-input inbound-input-text '.$formatted_label . $input_classes.'" name="'.$field_name.'" '.$form_placeholder.' value="'.$dynamic_value.'" type="'.$type.'" '.$req.'/>';
		       		}
		       		if ($type != 'hidden' && $form_labels === "bottom" && $type != "radio"){	
                    	$form .= '<label class="inbound-label '.$formatted_label.' '.$form_labels_class.' inbound-input-'.$type.'">' . $matches[3][$i]['label'] . $req_label . '</label>';
                    }
                   
                    
                   
                    
		       		if ($description_block != "" && $type != 'hidden'){
		       			$form .= "<div class='inbound-description'>".$description_block."</div>";
		       		}

                   		$form .= '</div>'; 
				}
			
			$form .= '<div class="inbound-field inbound-submit-area">
                      <input type="submit" '.$submit_button_type.' class="button" value="'.$submit_button.'" name="send" id="inbound_form_submit" />
                  </div>
                  <input type="hidden" name="inbound_submitted" value="1">';
           if( $redirect != "") { 
            $form .=  '<input type="hidden" id="inbound_redirect" name="inbound_redirect" value="'.$redirect.'">';
           }
           	$form .= '<input type="hidden" name="inbound_form_name" value="'.$form_name.'">
                  </form>
                  </div>';
			$form = preg_replace('/<br class="inbr".\/>/', '', $form); // remove editor br tags
			return $form;
	}
}