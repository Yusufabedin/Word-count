<?php

/*
Plugin Name: word count
Plugin URI: https://learnwith.yusuf.com
Description: Count word form any wordpress post 
Version: 1.0
Author: yusuf
Author URI: https://www.facebook.com/
License: GPLv2 or later
Text Domain: word-count
Domain Path: /languages/
*/
// funtion wordcount_activation_hook(){}
// register_activation_hook(__FILE__,"wordcount_activation_hook");
// funtion wordcount_deactivation_hook(){}
// register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");*/
function word_count_load_textdomain(){
  load_plugin_textdomain('word-count',false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","word_count_load_textdomain");

function wordcount_count_words($content){
  $stripped_content = strip_tags($content);
  $wordn = str_word_count($stripped_content);
  $label = __('Total Number of Words','word-count');
  $label = apply_filters("wordcount_heading",$label);
  $tag = apply_filters('wordcount_tag','h2');
  $content .= sprintf('<%s>%s: %s</%s>',$tag,$label,$wordn,$tag);
  return $content;
}
add_filter('the_content','wordcount_count_words');
//reading count
function wordcount_reading_time($content){
 $stripped_content = strip_tags($content);
  $wordn = str_word_count($stripped_content);
  $reading_minute = floor($wordn/200);
  $reading_seconds = floor($wordn % 200/ ( 200 / 60));
  $is_visible = apply_filters('wordcount_reading_display_readingtime',1);
  if ($is_visible){
  $label = __('Total Reading Time','word-count');
  $label = apply_filters("wordcount_readingtime_heading",$label);
  $tag = apply_filters('wordcount_readingtime_tag','h4');
  $content .= sprintf('<%s>%s: %s minutes %s seconds</%s>',$tag,$label,$reading_minute,$reading_seconds,$tag);
  }
  return $content;
}
add_filter('the_content','wordcount_reading_time'); 


 
//short code
function mytheme_button($attributes){
    $default = array(
          'type'=>'primary',
          'title'=>__("Button",'mytheme'),
          'url'=>'',
          'size'=>'',
      );

      $button_attributes = shortcode_atts($default,$attributes);






        return sprintf('<a target="_blank" class="btn btn-%s %s "href="%s"> %s </a>',
            $button_attributes['type'],
            $button_attributes['size'],
            $button_attributes['url'],
            $button_attributes['title'],
        ); 
    }
    add_shortcode('button','mytheme_button');

    function mytheme_button2($attributes, $content=''){
       $default = array(
          'type'=>'primary',
          'title'=>__("Button",'mytheme'),
          'url'=>'',
          'size'=>'',
      );

      $button_attributes = shortcode_atts($default,$attributes);
        return sprintf('<a target="_blank" class="btn btn-%s %s "href="%s"> %s </a>',
            $button_attributes['type'],
            $button_attributes['size'],
            $button_attributes['url'],
            do_shortcode($content)
        );
    }
    add_shortcode('button2','mytheme_button2');


//Uppercase
    function mytheme_uppercase($attributes, $content=''){

      return strtoupper(do_shortcode($content));

    }


add_shortcode('uc','mytheme_uppercase');


//map shortcode
function mytheme_googly_map($attributes){
  $default = array(
      'place'=>'Dhaka Museum',
      'width'=>'800',
      'height'=>'500',
      'zoom'=>'14'
  );

    $params = shortcode_atts( $default,$attributes);

    $map = <<<EOD
     <div>
      <div>
        <iframe width="{$params['width']}" height="{$params['height']}" src="https://maps.google.com/maps?q={$params['place']}&t=&z={$params['zoom']}&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
      </div>
    </div>   
    EOD;

    return $map;

}
 

add_shortcode('gmap','mytheme_googly_map'); 

