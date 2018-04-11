<?php

class LocalAppointmentsShortcodes {

  function __construct(){

    add_action( 'wp_footer', array( 'LocalAppointmentsShortcodes', 'register_templates' ) );
    add_action( 'wp_enqueue_scripts', array( 'LocalAppointmentsShortcodes', 'assets' ) );
    add_shortcode( 'local-appointments', array( 'LocalAppointmentsShortcodes', 'shortcode_cb' ) );

  }

  public static function shortcode_cb( $atts, $content = '' ){

    $atts = shortcode_atts( array(
    ), $atts, 'local-appointments' );

    wp_enqueue_script( 'local-appointments' );
    wp_enqueue_style( 'local-appointments' );

    global $local_appointments_shortcodes;

    $local_appointments_shortcodes++;

    ?>
    <div class="local-appointments-sc-services" id="local-appointments--<?php echo $local_appointments_shortcodes ?>">
      <local-appointments-shortcode-services :atts="form"></local-appointments-shortcode-services>
    </div>
    <?php
  }

  public static function register_templates(){

    $path = untrailingslashit( plugin_dir_path( __FILE__ ) ) ;

    $templates = array(
      '/components/shortcode-services-choose-service.php',
      '/components/shortcode-services-choose-day.php',
      '/components/shortcode-services-choose-time.php',
      '/components/shortcode-services-choose-details.php',
      '/components/shortcode-services.php',

     );

    foreach( $templates as $template ){
      if( file_exists( "{$path}/templates/$template" ) ) require_once( "{$path}/templates/$template" );
    }

  }

  public static function assets(){

    if( is_admin() ) return;

    if( ! wp_style_is( 'fontawesome', 'registered' ) )
      wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );


    wp_register_style(
      'local-appointments',
      plugins_url( '/assets/css/front.css', __FILE__ ),
      array( 'fontawesome' ),
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

    wp_register_script(
      'local-appointments',
      plugins_url( '/assets/js/front-min.js', __FILE__ ),
      array( 'vue-js', 'lodash', 'moment', 'vue-resource', 'vue2-filters' ),
      rand(),
      true
    );

    wp_localize_script( 'local-appointments', 'app_wp_locale', apply_filters( 'local-appointments-front-localize', array() ) );

  }

}

new LocalAppointmentsShortcodes();
