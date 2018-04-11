<?php

class LocalAppointmentsCustomPostTypes{

  function __construct(){

    add_action( 'init', array( 'LocalAppointmentsCustomPostTypes', 'register_services' ) );
    add_action( 'init', array( 'LocalAppointmentsCustomPostTypes', 'register_notifications' ) );

  }

  public static function register_services(){

    $args = array(
      'public' => true,
      'label'  => esc_html__( 'Services', 'local-appointments' ),
      'show_ui'=> false,
      'show_in_rest' => true
    );
    register_post_type( 'loc-app-service', apply_filters( 'local-appointments-register-cpt-services-args', $args ) );

  }

  public static function register_notifications(){

    $args = array(
      'public' => true,
      'label'  => esc_html__( 'Notifications', 'local-appointments' ),
      'show_ui'=> false,
      'show_in_rest' => true
    );
    register_post_type( 'loc-app-notification', apply_filters( 'local-appointments-register-cpt-services-args', $args ) );

  }

}

new LocalAppointmentsCustomPostTypes();
