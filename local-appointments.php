<?php
/*
Plugin Name: Local Appointments
Plugin URI: http://curlythemes.com/plugins/local-appointments/
Description: Local Appointments
Version: 1.0
Author: Curly Themes
Author URI: http://demo.curlythemes.com
Text Domain: local-appointments
*/

define( 'LOCAL_APPOINTMENTS_FILE', __FILE__ );


  include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/models/schema.services-options.php' );
include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/models/schema.service.php' );

$local_appointments_shortcodes = 0;


function local_appointments_sanitize_fields_array($fields){
  if( is_array( $fields ) ){
    foreach( $fields as $key => $field ){
      foreach( $field as $prop_key => $prop ){
        if( in_array( $prop_key, array( 'mandatory', 'allow_mandatory', 'allow_delete', 'status' ) ) ){
          $fields[$key][$prop_key] = wp_validate_boolean( $prop );
        }
        //
      }
    }
  }
  return $fields;
}

add_filter( 'local-appointments-sc-services-options', function( $options ){
  $model = array();
  foreach( apply_filters( 'local-appointments-sc-services-schema', array() ) as $key => $option ){
    $model[$option['name']] = local_appointments_parse_option( $option );
  }
  error_log(print_r($model, true));
  return $model;
});

add_filter( 'local-appointments-sc-services-options-validation', function( $options ){
  $model = array();
  foreach( apply_filters( 'local-appointments-sc-services-schema', array() ) as $key => $option ){
    $model[$option['name']] = local_appointments_get_service_option_validation( $option );
  }
  return $model;
});

function local_appointments_get_service_option_validation( $option ){
  $out = '';
  if( isset($option['validation']) && $option['validation'] === 'is_array' ){
    $out = array();
    foreach( $option['value'] as $key => $opt ){
      if( isset( $opt['name'] ) ){
        $out[$opt['name']] = local_appointments_get_service_option_validation( $opt ) ;
      } else{
        $out[] = local_appointments_get_service_option_validation( $opt ) ;
      }
    }
  }
  else{
    $out = isset( $option['validation'] ) ? $option['validation'] : 'esc_attr';
  }
  return $out;
}


function local_appointments_parse_option( $option ){
  $out = '';
  if( isset($option['validation']) && $option['validation'] === 'is_array' ){
    $out = array();
    foreach( $option['value'] as $key => $opt ){
      if( isset( $opt['name'] ) ){
        $out[$opt['name']] = local_appointments_parse_option( $opt ) ;
      } else{
        $out[] = local_appointments_parse_option( $opt ) ;
      }
    }
  }
  else if( isset($option['validation']) && $option['validation'] === 'local_appointments_sanitize_fields_array'  ){
    $out = array();
    if( isset($option['value']) ){
      foreach( $option['value'] as $key => $opt ){
        if( isset( $opt['name'] ) ){
          $out[$opt['name']] = local_appointments_parse_option( $opt ) ;
        } else{
          $out[] = local_appointments_parse_option( $opt ) ;
        }
      }
    }

  }
  else{
    $out = $option['value'];
  }
  return $out;
}




include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/models/schema.service.php' );

include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class.helpers.php' );
include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class.rest-api.php' );
include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class.custom-post-types.php' );
include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class.shortcodes.php' );
include( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/class.admin-page.php' );
