<?php
class LocalAppointmentsRestApi {

  private $_version;
  private $_namespace;

  public function __construct(){

    $this->_version = '1';
    $this->_namespace = "local-appointments/v{$this->_version}";

    add_action( 'rest_api_init', array( $this, 'register_api_routes' ) );
    add_filter( 'local-appointments-front-localize', array( $this, 'localize_public_api' ) );
    add_filter( 'local-appointments-admin-localize', array( $this, 'localize_private_api' ) );


    add_action( 'rest_api_init', array( 'LocalAppointmentsRestApi', 'modify_services_rest_responses' ) );

  }



  public static function modify_services_rest_responses() {

    /* Services */

    /* Name */
    register_rest_field(
       array( 'loc-app-service' ),
       'name',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Tagline */
    register_rest_field(
       array( 'loc-app-service' ),
       'tagline',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Description */
    register_rest_field(
       array( 'loc-app-service' ),
       'description',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Capacity */
    register_rest_field(
       array( 'loc-app-service' ),
       'capacity',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return (int)get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, (int)$value );
        }
       )
    );

    /* Price */
    register_rest_field(
       array( 'loc-app-service' ),
       'price',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return floatval( get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true ) );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, floatval($value) );
        }
       )
    );

    /* Color */
    register_rest_field(
       array( 'loc-app-service' ),
       'color',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          return get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value);
        }
       )
    );

    /* Duration Type */
    register_rest_field(
       array( 'loc-app-service' ),
       'duration_type',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          return ! empty( $out ) ? $out : 30;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, (int)$value );
        }
       )
    );

    /* Duration */
    register_rest_field(
       array( 'loc-app-service' ),
       'duration',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          return ! empty( $out ) ? (int)$out : 30;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, (int)$value );
        }
       )
    );


    /* Availability*/
    register_rest_field(
       array( 'loc-app-service' ),
       'availability',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          if( ! empty( $out ) && is_array( $out ) ){
            array_walk( $out, function(&$a, $b){
              if( $b === 'days' ){
                array_walk( $a, function(&$aa, $bb ){
                  $aa = array_map( function($o){
                      return array_map( 'intval', $o );
                  }, $aa );
                });
              } else{
                $a = $a;
                }
            });
          } else {
            $out = array(
              'days' => array(
                1 => array( array( 540, 1020 ) ),
                2 => array( array( 540, 1020 ) ),
                3 => array( array( 540, 1020 ) ),
                4 => array( array( 540, 1020 ) ),
                5 => array( array( 540, 1020 ) ),
              ),
              'specific' => array(),
              'empty' => array()
            );
          }
          return $out;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );


    /* Padding */
    register_rest_field(
       array( 'loc-app-service' ),
       'padding',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          if( ! empty( $out ) && is_array( $out ) ){
            $out = array_map( 'intval', $out );
          } else {
            $out = array(
              'before' => 0,
              'after' => 0
            );
          }
          return $out;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Rolling Method */
    register_rest_field(
       array( 'loc-app-service' ),
       'rolling_method',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          return ! empty( $out ) ? (int)$out : 1;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Rolling Days */
    register_rest_field(
       array( 'loc-app-service' ),
       'rolling_days',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          return ! empty( $out ) ? (int)$out : 40;
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );

    /* Rolling Date Range */
    register_rest_field(
       array( 'loc-app-service' ),
       'rolling_date_range',
       array(
        'get_callback' => function( $object, $field_name, $request ){
          $out = get_post_meta( $object[ 'id' ], '_app_wp_' . $field_name, true );
          return ! empty( $out ) && is_array( $out ) ? $out : array();
        },
        'update_callback' => function( $value, $object, $field_name ){
          return update_post_meta( $object->ID, '_app_wp_' . $field_name, $value );
        }
       )
    );



  }

  public function localize_private_api( $arr ){

    $arr['rest_nonce'] = wp_create_nonce( 'wp_rest' );
    $arr['rest_api_base'] = array(
      'services' => rest_url('/wp/v2/loc-app-service/'),
      'notifications' => rest_url('/wp/v2/loc-app-notification/'),
      'shortcodes' => array(
        'services' => rest_url("/{$this->_namespace}/shortcodes/services/")
      )
    );

    return $arr;
  }

  public function localize_public_api( $arr ){

    $arr['rest_nonce'] = wp_create_nonce( 'wp_rest' );
    $arr['rest_api_base'] = array(
      'services' => rest_url('/wp/v2/loc-app-service/'),
      'shortcodes' => array(
        'services' => rest_url("/{$this->_namespace}/shortcodes/services/")
      )
    );

    return $arr;
  }

  function register_api_routes(){

    register_rest_route( $this->_namespace, '/shortcodes/services/(?P<id>[a-zA-Z0-9-]+)', array(
      array(
          'methods'  => WP_REST_Server::READABLE,
          'callback' => array( $this, 'get_shortcode_options' )
      ),
      array(
          'methods'  => WP_REST_Server::CREATABLE,
          'callback' => array( $this, 'update_shortcode_options' ),
          //'permission_callback' => array( $this, 'user_permissions' )
          'args' => array(
            'id' => array(
              'default' => 'view',
            )
          )
      ),
    ));

  }

  public function get_shortcode_options( $request ){
    $params = $request->get_body_params();
    $params = $request->get_url_params();
    $default = apply_filters( 'local-appointments-sc-services-options', array() );
    error_log(print_r($default, true));
    $out = get_option( '_loc_app_sc_' . $params['id'] );
    if( empty( $out ) ) $out = $default;

    $schema = apply_filters( 'local-appointments-sc-services-options-validation', array() );

    foreach( $out as $key => $sections ){
      foreach( $sections as $key_option => $option ){
        $out[$key][$key_option] = isset( $schema[$key][$key_option] ) && function_exists($schema[$key][$key_option]) ? $schema[$key][$key_option]($option) : esc_attr( $option );
      }
    }
    foreach( $default as $key => $val ){
      foreach( $val as $o_k => $o ){
        if( ! isset( $out[$key][$o_k] ) ){
          $out[$key][$o_k] = $default[$key][$o_k];
        }
      }
    }
    //error_log(print_r($out, true));
    return $out;
  }

  public function update_shortcode_options( $request ){
    $body = $request->get_body_params();
    $params = $request->get_url_params();
    if( ! isset( $params['id'] ) ) return;
    return update_option( '_loc_app_sc_' . $params['id'], $body );
  }



}

new LocalAppointmentsRestApi();


?>
