<?php 
// BigCloudCMS Shortcode Generator 

// Enqueue scripts

function kad_shortcode_button_scripts(){
	 wp_enqueue_media();
  	wp_enqueue_script('kadwidget_upload', get_template_directory_uri() . '/assets/js/min/widget_upload-ck.js');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('kad-shortcode-css', get_template_directory_uri() . '/lib/kad_shortcodes/css/kad-short-pop.css'); 
	wp_enqueue_script('kad_shortcode',get_template_directory_uri() . '/lib/kad_shortcodes/js/kad_shortcode_pop.js',array( 'jquery', 'wp-color-picker' ),'1.2.0 ', TRUE);
}

add_action('admin_enqueue_scripts','kad_shortcode_button_scripts');

add_action('admin_footer','kad_shortcode_content');

function bigcloudcms_shortcode_option( $name, $attr_option, $shortcode ){
	
	$kad_option_element = null;
	
	(isset($attr_option['desc']) && !empty($attr_option['desc'])) ? $desc = '<p class="description">'.$attr_option['desc'].'</p>' : $desc = '';
	
		
	switch( $attr_option['type'] ){
		
		case 'radio':
	    
		$kad_option_element .= '<div class="label"><strong>'.$attr_option['title'].': </strong></div><div class="content">';
	    foreach( $attr_option['values'] as $val => $title ){
	    
		(isset($attr_option['def']) && !empty($attr_option['def'])) ? $def = $attr_option['def'] : $def = '';
		
		 $kad_option_element .= '
			<label for="shortcode-option-'.$shortcode.'-'.$name.'-'.$val.'">'.$title.'</label>
		    <input class="attr" type="radio" data-attrname="'.$name.'" name="'.$shortcode.'-'.$name.'" value="'.$val.'" id="shortcode-option-'.$shortcode.'-'.$name.'-'.$val.'"'. ( $val == $def ? ' checked="checked"':'').'>';
	    }
		
		$kad_option_element .= $desc . '</div>';
		
	    break;
	    case 'checkbox':
		
		$kad_option_element .= '<div class="label"><label for="' . $name . '"><strong>' . $attr_option['title'] . ': </strong></label></div>    <div class="content"> <input type="checkbox" class="' . $name . '" data-attrname="'.$name.'" id="' . $name . '" />'. $desc. '</div> ';
		
		break;
		case 'select':

		$kad_option_element .= '
		<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
		<div class="content"><select id="'.$name.'" class="kad-sc-select">';
			$values = $attr_option['values'];
			foreach( $values as $value => $vname ){
				if($value == $attr_option['default']) { $selected=' selected="selected"';} else { $selected=""; }
		    	$kad_option_element .= '<option value="'.$value.'" ' . $selected .'>'.$vname.'</option>';
			}
		$kad_option_element .= '</select>' . $desc . '</div>';

		break;
		case 'icon-select':

		$kad_option_element .= '
		<div class="label"><label for="'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		
		<div class="content"><select id="'.$name.'" class="kad-icon-select">';
			$values = $attr_option['values'];
			foreach( $values as $value ){
		    	$kad_option_element .= '<option value="'.$value.'">'.$value.'</option>';
			}
		$kad_option_element .= '</select>' . $desc . '</div>';

		break;
		case 'color':
			
	           $kad_option_element .= '
	           <div class="label"><label><strong>'.$attr_option['title'].' </strong></label></div>
			   <div class="content"><input type="text" value="'. ( isset($attr_option['default']) ? $attr_option['default'] : "" ) . '" class="kad-popup-colorpicker" data-attrname="'.$name.'" style="width: 70px;" data-default-color="'. ( isset($attr_option['default']) ? $attr_option['default'] : "" ) . '"/>';
			   $kad_option_element .= $desc . '</div>';
		break;
		case 'textarea':
		$kad_option_element .= '
		<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
		<div class="content"><textarea class="kad-sc-'.$name.'" data-attrname="'.$name.'"></textarea> ' . $desc . '</div>';
		break;
		case 'text':
		default:
		    $kad_option_element .= '
			<div class="label"><label for="shortcode-option-'.$name.'"><strong>'.$attr_option['title'].': </strong></label></div>
			<div class="content"><input class="attr kad-sc-textinput kad-sc-'.$name.'" type="text" data-attrname="'.$name.'" value="" />' . $desc . '</div>';
		break;
	}
	
	$kad_option_element .= '<div class="clear"></div>';
    
	
    return $kad_option_element;
}

function kad_shortcode_content(){

	//Columns
$bigcloudcms_shortcodes['columns'] = array( 
	'title'=>__('Columns', 'bigcloudcms'), 
	'attr'=>array(
		'columns'=>array(
			'type'=>'radio', 
			'title'=>__('Columns','bigcloudcms'),
			'values' => array(
				"span6" => '<img src="'. get_template_directory_uri().'/assets/img/twocolumn.jpg" />' . __("Two Columns", "bigcloudcms"),
				"span4right" => '<img src="'. get_template_directory_uri().'/assets/img/twocolumnright.jpg" />' . __("Two Columns offset Right", "bigcloudcms"),
				"span4left" => '<img src="'. get_template_directory_uri().'/assets/img/twocolumnleft.jpg" />' . __("Two Columns offset Left", "bigcloudcms"),
				"span4" => '<img src="'. get_template_directory_uri().'/assets/img/threecolumn.jpg" />' . __("Three Columns", "bigcloudcms"),
				"span3" => '<img src="'. get_template_directory_uri().'/assets/img/fourcolumn.jpg" />' . __("Four Columns", "bigcloudcms"),
				)
		),
	) 
);
	// Divider 
$bigcloudcms_shortcodes['hr'] = array( 
	'title'=>__('Divider', 'bigcloudcms'), 
	'attr'=>array(
		'style'=>array(
			'type'=>'select', 
			'title'=>__('Style', 'bigcloudcms'),
			'default' => 'line',
			'values' => array(
				"line" => __("Line", "bigcloudcms"),
				"dots" => __("Dots", "bigcloudcms"),
				"gradient" => __("Gradient", "bigcloudcms"),
				)
		),
		'size'=>array(
			'type'=>'select', 
			'title'=>__('Size','bigcloudcms'),
			'default' => '1px',
			'values' => array(
				"1px" => "1px",
				"2px" => "2px",
				"3px" => "3px",
				"4px" => "4px",
				"5px" => "5px",
				)
		),
		'color'=>array(
			'type'=>'color', 
			'title'  => __('Color','bigcloudcms'),
		)
	) 
);
// Spacer
$bigcloudcms_shortcodes['space'] = array( 
	'title'=>__('Spacing', 'bigcloudcms'), 
	'attr'=>array(
		'size'=>array(
			'type'=>'select', 
			'title'=>__('Size','bigcloudcms'),
			'default' => '10px',
			'values' => array(
				"10px" => "10px",
				"20px" => "20px",
				"30px" => "30px",
				"40px" => "40px",
				"50px" => "50px",
				)
		)
	) 
);
// Spacer
$bigcloudcms_shortcodes['tabs'] = array( 
	'title'=>__('Tabs', 'bigcloudcms'), 
);
$bigcloudcms_shortcodes['accordion'] = array( 
	'title'=>__('Accordion', 'bigcloudcms'),
);
$bigcloudcms_shortcodes['pullquote'] = array( 
	'title'=>__('Pull-Quotes', 'bigcloudcms'), 
	'attr'=>array(
		'align'=>array(
			'type'=>'select', 
			'title'=>__('Align', 'bigcloudcms'),
			'default' => 'center',
			'values' => array(
				"center" => __('Center','bigcloudcms'),
				"left" => __('Left','bigcloudcms'),
				"right" => __('Right','bigcloudcms'),
				)
		),
		'content'=>array(
			'type'=>'textarea', 
			'title'=>__('Pull-Quote Text', 'bigcloudcms')
		)
	) 
);
$bigcloudcms_shortcodes['blockquote'] = array( 
	'title'=>__('Block-Quotes', 'bigcloudcms'), 
	'attr'=>array(
		'align'=>array(
			'type'=>'select', 
			'title'=>__('Align', 'bigcloudcms'),
			'default' => 'center',
			'values' => array(
				"center" => __('Center','bigcloudcms'),
				"left" => __('Left','bigcloudcms'),
				"right" => __('Right','bigcloudcms'),
				)
		),
		'content'=>array(
			'type'=>'textarea', 
			'title'=>__('Block-Quote Text', 'bigcloudcms')
		)
	) 
);
$bigcloudcms_shortcodes['kt_box'] = array( 
	'title'=>__('Simple Box', 'bigcloudcms'), 
	'attr'=>array(
		'padding_top'=>array(
			'type'=>'text', 
			'title'=>__('Padding Top (just a number)', 'bigcloudcms'),
			'default' => '15',
		),
		'padding_bottom'=>array(
			'type'=>'text', 
			'title'=>__('Padding Bottom (just a number)', 'bigcloudcms'),
			'default' => '15',
		),
		'padding_left'=>array(
			'type'=>'text', 
			'title'=>__('Padding Left (just a number)', 'bigcloudcms'),
			'default' => '15',
		),
		'padding_right'=>array(
			'type'=>'text', 
			'title'=>__('Padding Right (just a number)', 'bigcloudcms'),
			'default' => '15',
		),
		'min_height'=>array(
			'type'=>'text', 
			'title'=>__('Min Height (just a number)', 'bigcloudcms'),
			'default' => '0',
		),
		'background'=>array(
			'type'=>'color', 
			'title'  => __('Background Color','bigcloudcms'),
			'default' => '',
		),
		'opacity'=>array(
			'type'=>'select', 
			'title'=>__('Background Color Opacity', 'bigcloudcms'),
			'default' => '1',
			'values' => array(
				"1" => __('1.0','bigcloudcms'),
				"0.9" => __('0.9','bigcloudcms'),
				"0.8" => __('0.8','bigcloudcms'),
				"0.7" => __('0.7','bigcloudcms'),
				"0.6" => __('0.6','bigcloudcms'),
				"0.5" => __('0.5','bigcloudcms'),
				"0.4" => __('0.4','bigcloudcms'),
				"0.3" => __('0.3','bigcloudcms'),
				"0.2" => __('0.2','bigcloudcms'),
				"0.1" => __('0.1','bigcloudcms'),
				"0.0" => __('0.0','bigcloudcms'),
				)
		),
		'content'=>array(
			'type'=>'textarea', 
			'title'=>__('Content Text', 'bigcloudcms')
		)
	) 
);
$icons = kad_icon_list();

	//Button
$bigcloudcms_shortcodes['btn'] = array( 
	'title'=>__('Button', 'bigcloudcms'), 
	'attr'=>array(
		'text'=>array(
			'type'=>'text', 
			'title'=>__('Button Text', 'bigcloudcms')
		),
		'target'=>array(
			'type'=>'checkbox', 
			'title'=>__('Open Link In New Tab?','bigcloudcms')
		),
		'tcolor'=>array(
			'type'=>'color', 
			'title'  => __('Font Color','bigcloudcms'),
			'default' => '#ffffff',
		),
		'bcolor'=>array(
			'type'=>'color', 
			'title'  => __('Button Background Color','bigcloudcms'),
			'default' => '',
		),
		'thovercolor'=>array(
			'type'=>'color', 
			'title'  => __('Font Hover Color','bigcloudcms'),
			'default' => '#ffffff',
		),
		'bhovercolor'=>array(
			'type'=>'color', 
			'title'  => __('Button Background Hover Color','bigcloudcms'),
			'default' => '',
		),
		'link'=>array(
			'type'=>'text', 
			'title'=>__('Link URL', 'bigcloudcms')
		),
		'size'=>array(
			'type'=>'select', 
			'title'=>__('Button Size', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => __('Default', 'bigcloudcms'),
				"large" => __('Large', 'bigcloudcms'),
				"small" => __('Small', 'bigcloudcms'),
				)
		),
		'font'=>array(
			'type'=>'select', 
			'title'=>__('Font Family', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => __('Default', 'bigcloudcms'),
				"h1-family" => __('H1 Family', 'bigcloudcms'),
				)
		),
		'icon'=>array(
			'type'=>'icon-select', 
			'title'=>__('Choose an Icon (optional)', 'bigcloudcms'),
			'values' => $icons
		),
	) 
);
$bigcloudcms_shortcodes['gmap'] = array( 
	'title'=>__('Google Map', 'bigcloudcms'), 
	'attr'=>array(
		'address'=>array(
			'type'=>'text', 
			'title'=>__('Address One', 'bigcloudcms')
		),
		'title'=>array(
			'type'=>'text', 
			'title'=>__('Address Title One','bigcloudcms'),
			'desc'=>__('Displays in Popup e.g. = Business Name', 'bigcloudcms')
		),
		'height'=>array(
			'type'=>'text', 
			'title'=>__('Map Height', 'bigcloudcms'),
			'desc'=>__('Just a number e.g. = 400', 'bigcloudcms'), 
		),
		'zoom'=>array(
			'type'=>'select', 
			'title'=>__('Map Zoom','bigcloudcms'),
			'default' => '15',
			'values' => array(
				"1" => "1",
				"2" => "2",
				"3" => "3",
				"4" => "4",
				"5" => "5",
				"6" => "6",
				"7" => "7",
				"8" => "8",
				"9" => "9",
				"10" => "10",
				"11" => "11",
				"12" => "12",
				"13" => "13",
				"14" => "14",
				"15" => "15",
				"16" => "16",
				"17" => "17",
				"18" => "18",
				"19" => "19",
				"20" => "20",
				)
		),
		'maptype'=>array(
			'type'=>'select', 
			'title'=>__('Map Type','bigcloudcms'),
			'default' => 'ROADMAP',
			'values' => array(
				"ROADMAP" => __('ROADMAP', 'bigcloudcms'),
				"HYBRID" => __('HYBRID', 'bigcloudcms'),
				"TERRAIN" => __('TERRAIN', 'bigcloudcms'),
				"SATELLITE" => __('SATELLITE', 'bigcloudcms'),
				)
		),
		'address2'=>array(
			'type'=>'text', 
			'title'=>__('Address Two', 'bigcloudcms')
		),
		'title2'=>array(
			'type'=>'text', 
			'title'=>__('Address Title Two','bigcloudcms'),
			'desc'=>__('Displays in Popup e.g. = Business Name', 'bigcloudcms')
		),
		'address3'=>array(
			'type'=>'text', 
			'title'=>__('Address Three', 'bigcloudcms')
		),
		'title3'=>array(
			'type'=>'text', 
			'title'=>__('Address Title Three','bigcloudcms'),
			'desc'=>__('Displays in Popup e.g. = Business Name', 'bigcloudcms')
		),
		'address4'=>array(
			'type'=>'text', 
			'title'=>__('Address Four', 'bigcloudcms')
		),
		'title4'=>array(
			'type'=>'text', 
			'title'=>__('Address Title Four','bigcloudcms'),
			'desc'=>__('Displays in Popup e.g. = Business Name', 'bigcloudcms')
		),
		'center'=>array(
			'type'=>'text', 
			'title'=>__('Map Center','bigcloudcms'),
			'desc'=>__('Defaults to Address One', 'bigcloudcms')
		)
	) 
);

$bigcloudcms_shortcodes['icon'] = array( 
	'title'=>__('Icon', 'bigcloudcms'), 
	'attr'=>array(
		'icon'=>array(
			'type'=>'icon-select', 
			'title'=>__('Choose an Icon', 'bigcloudcms'),
			'values' => $icons
		),
		'size'=>array(
			'type'=>'select', 
			'title'=>__('Icon Size','bigcloudcms'),
			'default' => '14px',
			'values' => array(
				"5px" => "5px",
				"6px" => "6px",
				"7px" => "7px",
				"8px" => "8px",
				"9px" => "9px",
				"10px" => "10px",
				"11px" => "11px",
				"12px" => "12px",
				"13px" => "13px",
				"14px" => "14px",
				"15px" => "15px",
				"16px" => "16px",
				"17px" => "17px",
				"18px" => "18px",
				"19px" => "19px",
				"20px" => "20px",
				"21px" => "21px",
				"22px" => "22px",
				"23px" => "23px",
				"24px" => "24px",
				"25px" => "25px",
				"26px" => "26px",
				"27px" => "27px",
				"28px" => "28px",
				"29px" => "29px",
				"30px" => "30px",
				"31px" => "31px",
				"32px" => "32px",
				"33px" => "33px",
				"34px" => "34px",
				"35px" => "35px",
				"36px" => "36px",
				"37px" => "37px",
				"38px" => "38px",
				"39px" => "39px",
				"40px" => "40px",
				"41px" => "41px",
				"42px" => "42px",
				"43px" => "43px",
				"44px" => "44px",
				"45px" => "45px",
				"46px" => "46px",
				"47px" => "47px",
				"48px" => "48px",
				"49px" => "49px",
				"50px" => "50px",
				"51px" => "51px",
				"52px" => "52px",
				"53px" => "53px",
				"54px" => "54px",
				"55px" => "55px",
				"56px" => "56px",
				"57px" => "57px",
				"58px" => "58px",
				"59px" => "59px",
				"60px" => "60px",
				"61px" => "61px",
				"62px" => "62px",
				"63px" => "63px",
				"64px" => "64px",
				"65px" => "65px",
				"66px" => "66px",
				"67px" => "67px",
				"68px" => "68px",
				"69px" => "69px",
				"70px" => "70px",
				"71px" => "71px",
				"72px" => "72px",
				"73px" => "73px",
				"74px" => "74px",
				"75px" => "75px",
				"76px" => "76px",
				"77px" => "77px",
				"78px" => "78px",
				"79px" => "79px",
				"80px" => "80px",
			)
		),
		'color'=>array(
			'type'=>'color', 
			'title'  => __('Icon Color','bigcloudcms'),
			'default' => '',
		),
		'float'=>array(
			'type'=>'select', 
			'title'=>__('Icon Float', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => "none",
				"left" => "Left",
				"right" => "Right",
				)
		),
		'style'=>array(
			'type'=>'select', 
			'title'=>__('Icon Style', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => "none",
				"circle" => __('Circle', 'bigcloudcms'),
				"smcircle" => __('Small Circle', 'bigcloudcms'),
				"square" => __('Square', 'bigcloudcms'),
				"smsquare" => __('Small Square', 'bigcloudcms'),
				)
		),
		'background'=>array(
			'type'=>'color', 
			'title'  => __('Background Color','bigcloudcms'),
			'default' => '',
		)
	) 
);
$bigcloudcms_shortcodes['iconbox'] = array( 
	'title'=>__('Icon Box', 'bigcloudcms'), 
	'attr'=>array(
		'icon'=>array(
			'type'=>'icon-select', 
			'title'=>__('Choose an Icon', 'bigcloudcms'),
			'values' => $icons
		),
		'iconsize'=>array(
			'type'=>'select', 
			'title'=>__('Icon Size','bigcloudcms'),
			'default' => '48px',
			'values' => array(
				"5px" => "5px",
				"6px" => "6px",
				"7px" => "7px",
				"8px" => "8px",
				"9px" => "9px",
				"10px" => "10px",
				"11px" => "11px",
				"12px" => "12px",
				"13px" => "13px",
				"14px" => "14px",
				"15px" => "15px",
				"16px" => "16px",
				"17px" => "17px",
				"18px" => "18px",
				"19px" => "19px",
				"20px" => "20px",
				"21px" => "21px",
				"22px" => "22px",
				"23px" => "23px",
				"24px" => "24px",
				"25px" => "25px",
				"26px" => "26px",
				"27px" => "27px",
				"28px" => "28px",
				"29px" => "29px",
				"30px" => "30px",
				"31px" => "31px",
				"32px" => "32px",
				"33px" => "33px",
				"34px" => "34px",
				"35px" => "35px",
				"36px" => "36px",
				"37px" => "37px",
				"38px" => "38px",
				"39px" => "39px",
				"40px" => "40px",
				"41px" => "41px",
				"42px" => "42px",
				"43px" => "43px",
				"44px" => "44px",
				"45px" => "45px",
				"46px" => "46px",
				"47px" => "47px",
				"48px" => "48px",
				"49px" => "49px",
				"50px" => "50px",
				"51px" => "51px",
				"52px" => "52px",
				"53px" => "53px",
				"54px" => "54px",
				"55px" => "55px",
				"56px" => "56px",
				"57px" => "57px",
				"58px" => "58px",
				"59px" => "59px",
				"60px" => "60px",
				"61px" => "61px",
				"62px" => "62px",
				"63px" => "63px",
				"64px" => "64px",
				"65px" => "65px",
				"66px" => "66px",
				"67px" => "67px",
				"68px" => "68px",
				"69px" => "69px",
				"70px" => "70px",
				"71px" => "71px",
				"72px" => "72px",
				"73px" => "73px",
				"74px" => "74px",
				"75px" => "75px",
				"76px" => "76px",
				"77px" => "77px",
				"78px" => "78px",
				"79px" => "79px",
				"80px" => "80px",
			)
		),
		'color'=>array(
			'type'=>'color', 
			'title'  => __('Icon/Font Color','bigcloudcms'),
			'default' => '#ffffff',
		),
		'background'=>array(
			'type'=>'color', 
			'title'  => __('Background Color','bigcloudcms'),
			'default' => '#dddddd',
		),
		'hcolor'=>array(
			'type'=>'color', 
			'title'  => __('Hover Icon/Font Color','bigcloudcms'),
			'default' => '#ffffff',
		),
		'hbackground'=>array(
			'type'=>'color', 
			'title'  => __('Hover Background Color','bigcloudcms'),
			'default' => '',
		),
		'link'=>array(
			'type'=>'text', 
			'title'=>__('Link URL', 'bigcloudcms')
		),
		'title'=>array(
			'type'=>'text', 
			'title'=>__('Title', 'bigcloudcms')
		),
		'description'=>array(
			'type'=>'textarea', 
			'title'=>__('Description', 'bigcloudcms')
		)

	) 
);
$bigcloudcms_shortcodes['kt_typed'] = array( 
	'title'=>__('Animated Typed Text', 'bigcloudcms'), 
	'attr'=>array(
		'first_sentence'=>array(
			'type'=>'text', 
			'title'=>__('First Sentence', 'bigcloudcms')
		),
		'second_sentence'=>array(
			'type'=>'text', 
			'title'=>__('Second Sentence (optional)', 'bigcloudcms')
		),
		'third_sentence'=>array(
			'type'=>'text', 
			'title'=>__('Third Sentence (optional)', 'bigcloudcms')
		),
		'fourth_sentence'=>array(
			'type'=>'text', 
			'title'=>__('Fourth Sentence (optional)', 'bigcloudcms')
		),
		'loop'=>array(
			'type'=>'checkbox', 
			'title'=>__('Loop','bigcloudcms')
		)
	) 
);

$bigcloudcms_shortcodes['kad_youtube'] = array( 
	'title'=>__('YouTube', 'bigcloudcms'), 
	'attr'=>array(
		'url'=>array(
			'type'=>'text', 
			'title'=>__('Video URL', 'bigcloudcms')
		),
		'width'=>array(
			'type'=>'text', 
			'title'=>__('Video Width', 'bigcloudcms'),
			'desc' =>__('Just a number e.g. = 600', 'bigcloudcms'), 
		),
		'height'=>array(
			'type'=>'text', 
			'title'=>__('Video Height', 'bigcloudcms'),
			'desc'=>__('Just a number e.g. = 400', 'bigcloudcms'), 
		),
		'maxwidth'=>array(
			'type'=>'text', 
			'title'=>__('Video Max Width', 'bigcloudcms'),
			'desc'=>__('Keeps the responsive video from getting too large', 'bigcloudcms'), 
		),
		'hidecontrols'=>array(
			'type'=>'checkbox', 
			'title'=>__('Hide Controls','bigcloudcms')
		),
		'autoplay'=>array(
			'type'=>'checkbox', 
			'title'=>__('Auto Play','bigcloudcms')
		),
		'rel'=>array(
			'type'=>'checkbox', 
			'title'=>__('Show Related','pinnacle')
		),
		'modestbranding'=>array(
			'type'=>'checkbox', 
			'title'=>__('Modest Branding?','bigcloudcms')
		)
	) 
);
$bigcloudcms_shortcodes['kad_vimeo'] = array( 
	'title'=>__('Vimeo', 'bigcloudcms'), 
	'attr'=>array(
		'url'=>array(
			'type'=>'text', 
			'title'=>__('Video URL', 'bigcloudcms')
		),
		'width'=>array(
			'type'=>'text', 
			'title'=>__('Video Width', 'bigcloudcms'),
			'desc' =>__('Just a number e.g. = 600', 'bigcloudcms'), 
		),
		'height'=>array(
			'type'=>'text', 
			'title'=>__('Video Height', 'bigcloudcms'),
			'desc'=>__('Just a number e.g. = 400', 'bigcloudcms'), 
		),
		'maxwidth'=>array(
			'type'=>'text', 
			'title'=>__('Video Max Width', 'bigcloudcms'),
			'desc'=>__('Keeps the responsive video from getting too large', 'bigcloudcms'), 
		),
		'autoplay'=>array(
			'type'=>'checkbox', 
			'title'=>__('Auto Play','bigcloudcms')
		)
	) 
);
$postcategories = get_categories();
$cat_options = array();
$cat_options = array("" => "All");
foreach ($postcategories as $cat) {
      $cat_options[$cat->slug] = $cat->name;
}

$bigcloudcms_shortcodes['blog_posts'] = array( 
	'title'=>__('Blog Posts', 'bigcloudcms'), 
	'attr'=>array(
		'orderby'=>array(
			'type'=>'select', 
			'title'=>__('Order By', 'bigcloudcms'),
			'default' => 'date',
			'values' => array(
				"date" => __('Date','bigcloudcms'),
				"rand" => __('Random','bigcloudcms'),
				"menu_order" => __('Menu Order','bigcloudcms'),
				)
		),
		'cat'=>array(
			'type'=>'select',
			'default' => '',
			'title'=>__('Category', 'bigcloudcms'),
			'values' => $cat_options,
		),
		'items'=>array(
			'type'=>'text', 
			'title'=>__('Number of Posts', 'bigcloudcms')
		),
	) 
);
	//Button
$bigcloudcms_shortcodes['kad_modal'] = array( 
	'title'=>__('Modal', 'bigcloudcms'), 
	'attr'=>array(
		'btntitle'=>array(
			'type'=>'text', 
			'title'=>__('Button Title', 'bigcloudcms')
		),
		'btncolor'=>array(
			'type'=>'color', 
			'title'  => __('Button Font Color','bigcloudcms'),
			'default' => '#ffffff',
		),
		'btnbackground'=>array(
			'type'=>'color', 
			'title'  => __('Button Background Color','bigcloudcms'),
			'default' => '',
		),
		'btnsize'=>array(
			'type'=>'select', 
			'title'=>__('Button Size', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => __('Default', 'bigcloudcms'),
				"large" => __('Large', 'bigcloudcms'),
				"small" => __('Small', 'bigcloudcms'),
				)
		),
		'btnfont'=>array(
			'type'=>'select', 
			'title'=>__('Font Family', 'bigcloudcms'),
			'default' => '',
			'values' => array(
				"" => __('Default', 'bigcloudcms'),
				"h1-family" => __('H1 Family', 'bigcloudcms'),
				)
		),
		'title'=>array(
			'type'=>'text', 
			'title'=>__('Modal Title', 'bigcloudcms')
		),
		'content'=>array(
			'type'=>'textarea', 
			'title'=>__('Modal Content', 'bigcloudcms')
		)
	) 
);
$bigcloudcms_shortcodes['kad_testimonial_form'] = array( 
	'title'=>__('Testimonial Form', 'bigcloudcms'), 
	'attr'=>array(
		'location'=>array(
			'type'=>'checkbox', 
			'title'=>__('Show Location Field?','bigcloudcms')
		),
		'position'=>array(
			'type'=>'checkbox', 
			'title'=>__('Show Position Field?','bigcloudcms')
		),
		'link'=>array(
			'type'=>'checkbox', 
			'title'=>__('Show Link Field?','bigcloudcms')
		),
		'name_label'=>array(
			'type'=>'text', 
			'title'=>__('Name Field Label', 'bigcloudcms'),
			'desc'=>__('Default: Name', 'bigcloudcms')
		),
		'testimonial_label'=>array(
			'type'=>'text', 
			'title'=>__('Testimonial Field Label','bigcloudcms'),
			'desc'=>__('Default: Testimonial', 'bigcloudcms')
		),
		'location_label'=>array(
			'type'=>'text', 
			'title'=>__('Location Field Label', 'bigcloudcms'),
			'desc'=>__('Default: Location - Optional', 'bigcloudcms')
		),
		'position_label'=>array(
			'type'=>'text', 
			'title'=>__('Position Field Label', 'bigcloudcms'),
			'desc'=>__('Default: Position or Company - optional', 'bigcloudcms')
		),
		'link_label'=>array(
			'type'=>'text', 
			'title'=>__('Link Field Label','bigcloudcms'),
			'desc'=>__('Default: Link - optional', 'bigcloudcms')
		),
		'submit_label'=>array(
			'type'=>'text', 
			'title'=>__('Submit Field Label', 'bigcloudcms'),
			'desc'=>__('Default: Submit', 'bigcloudcms')
		),
		'success_message'=>array(
			'type'=>'text', 
			'title'=>__('Success Message','bigcloudcms'),
			'desc'=>__('Default: Thank you for submitting your testimonial! It is now awaiting approval from the site admnistator. Thank you!', 'bigcloudcms')
		),
	) 
);

	ob_start(); ?>
	<div id="bigcloudcms-shortcode-container">
		<div id="bigcloudcms-shortcode-innercontainer" class="mfp-hide mfp-with-anim">
		 	<div class="bigcloudcmsshortcode-content">
		 		<div class="shortcodes-header">
					<div class="kadshort-header"><h3><?php echo __('BigCloudCMS Shortcodes', 'bigcloudcms'); ?></h3></div>
					<div class="kadshort-select"><select id="bigcloudcms-shortcodes" data-placeholder="<?php _e("Choose a shortcode", 'bigcloudcms'); ?>">
				    <option></option>
					
					<?php $kad_sc_html = ''; $kad_options_html = '';
					$bigcloudcms_shortcodes = apply_filters('bigcloudcms_shortcodes', $bigcloudcms_shortcodes);
					foreach( $bigcloudcms_shortcodes as $shortcode => $options ){
						
							$kad_sc_html .= '<option value="'.$shortcode.'">'.$options['title'].'</option>';
							$kad_options_html .= '<div class="shortcode-options" id="options-'.$shortcode.'" data-name="'.$shortcode.'">';
							
								if( !empty($options['attr']) ){
									 foreach( $options['attr'] as $name => $attr_option ){
										$kad_options_html .= bigcloudcms_shortcode_option( $name, $attr_option, $shortcode );
									 }
								}
			
							$kad_options_html .= '</div>'; 
						
					} 
			
			$kad_sc_html .= '</select></div></div>'; 	
		
	
		 echo $kad_sc_html . $kad_options_html; ?>

 				
			<div class="kad_shortcode_insert">	
				<a href="javascript:void(0);" id="kad-shortcode-insert" class="kad-addshortcode-btn" style=""><?php _e("Add Shortcode", "bigcloudcms"); ?></a>
			</div>
	</div> 
	</div>
	</div>
<?php  $output = ob_get_contents();
		ob_end_clean();
	echo $output;
}