<?php

class LocalAppointmentsAdminPage{

  public function __construct(){

    add_action( 'admin_menu', array( 'LocalAppointmentsAdminPage', 'register_admin_page' ) );
    add_action( 'local-appointments-admin-templates', array( 'LocalAppointmentsAdminPage', 'register_templates' ) );
    add_action( 'admin_enqueue_scripts', array( 'LocalAppointmentsAdminPage', 'assets' ) );
    add_filter( 'local-appointments-models', array( 'LocalAppointmentsAdminPage', 'models' ) );

  }


  public static function models( $arr ){
    return array(
      'shortcodes' => array(
        'services' => apply_filters( 'local-appointments-sc-services-options', array() )
      )
    );
  }


  public static function assets(){

    if( ! wp_style_is( 'element-ui', 'registered' ) )
      wp_register_style( 'element-ui', 'https://unpkg.com/element-ui/lib/theme-chalk/index.css' );

    if( ! wp_style_is( 'fontawesome', 'registered' ) )
      wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.0.9/css/all.css', array(), rand() );

    wp_enqueue_style(
      'local-appointments',
      plugins_url( '/assets/admin/css/app.css', LOCAL_APPOINTMENTS_FILE ),
      array( 'element-ui', 'fontawesome' ),
      rand()
    );

    if( ! wp_script_is( 'vue-js', 'registered' ) )
      wp_register_script( 'vue-js', 'https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.js' );

    if( ! wp_script_is( 'vue-js-router', 'registered' ) )
      wp_register_script( 'vue-js-router', 'https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.0.1/vue-router.js' );

    if( ! wp_script_is( 'lodash', 'registered' ) )
      wp_register_script( 'lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.5/lodash.js' );

    if( ! wp_script_is( 'moment', 'registered' ) )
      wp_register_script( 'moment', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js' );

    if( ! wp_script_is( 'vue-resource', 'registered' ) )
      wp_register_script( 'vue-resource', 'https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.5.0/vue-resource.js' );

    if( ! wp_script_is( 'vue2-filters', 'registered' ) )
      wp_register_script( 'vue2-filters', 'https://cdn.jsdelivr.net/npm/vue2-filters/dist/vue2-filters.min.js' );

    if( ! wp_script_is( 'element-ui', 'registered' ) )
      wp_register_script( 'element-ui', 'https://unpkg.com/element-ui/lib/index.js', array( 'vue-js' ) );

    if( ! wp_script_is( 'marked', 'registered' ) )
      wp_register_script( 'marked', 'https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.17/marked.js' );

    if( ! wp_script_is( 'waypoints', 'registered' ) )
      wp_register_script( 'waypoints', plugins_url( '/local-appointments/dev/libs/waypoints/jquery.waypoints.min.js' ), array( 'jquery' ) );

    if( ! wp_script_is( 'waypoints-sticky', 'registered' ) )
      wp_register_script( 'waypoints-sticky', plugins_url( '/local-appointments/dev/libs/waypoints/shortcuts/sticky.min.js' ), array( 'jquery', 'waypoints' ) );

    wp_enqueue_script(
      'local-appointments',
      plugins_url( '/assets/admin/js/app-min.js', LOCAL_APPOINTMENTS_FILE ),
      array( 'vue-js', 'vue-js-router', 'element-ui', 'lodash', 'moment', 'vue-resource', 'vue2-filters', 'marked', 'waypoints-sticky' ),
      rand(),
      true
    );


    $current_user = wp_get_current_user();

    wp_localize_script( 'local-appointments', 'local_appointments_locale', apply_filters( 'local-appointments-admin-localize', array(
      'element_ui' => array( 'el' => apply_filters( 'app-wp-locale-element-ui', array() ) ),
      'current_user' => array(
        'name' => $current_user->display_name,
        'email' => $current_user->user_email
      ),
      'models' => apply_filters( 'local-appointments-models', array() )
    )));

  }

  public static function register_templates(){

    $path = untrailingslashit( plugin_dir_path( LOCAL_APPOINTMENTS_FILE ) ) ;

    $templates = array(

      '/routes/dashboard.php',
      '/routes/services.php',
      '/routes/service.php',
      '/routes/notifications.php',
      '/routes/notification.php',
      '/routes/appearance.php',
      '/routes/settings.php',
      '/routes/global/navigation.php',
      '/components/availability.php',
      '/components/shortcode-services.php',
      '/components/shortcode-services-choose-service.php',
      '/components/shortcode-services-choose-day.php',
      '/components/shortcode-services-choose-time.php',
      '/components/shortcode-services-choose-details.php',
     );

    foreach( $templates as $template ){
      if( file_exists( "{$path}/templates/$template" ) ) require_once( "{$path}/templates/$template" );
    }

  }


  public static function register_admin_page() {
    add_menu_page( 'Local Appointments', 'Local Appointments', 'manage_options', 'local-appointments.php', array( 'LocalAppointmentsAdminPage', 'admin_page_cb' ), 'dashicons-tickets', 6  );
  }

  public static function admin_page_cb(){
    ?>
    <div class="wrap" id="local-appointments">
      <router-view v-loading="loading"></router-view>
    </div>
    <?php
    do_action( 'local-appointments-admin-templates' );
  }

}

new LocalAppointmentsAdminPage();
