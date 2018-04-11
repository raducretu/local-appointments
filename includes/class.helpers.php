<?php

class LocalAppointmentsHelpers{

  public function __construct(){

    add_filter( 'local-appointments-localize-default-currency', array( 'LocalAppointmentsHelpers', 'default_currency' ) );

    add_filter( 'local-appointments-convert-date-time-format', array( 'LocalAppointmentsHelpers', 'parse_date_format' ) );
    add_filter( 'local-appointments-front-localize', array( 'LocalAppointmentsHelpers', 'localize_currency' ) );
    add_filter( 'local-appointments-front-localize', array( 'LocalAppointmentsHelpers', 'localize_date_time' ) );
    add_filter( 'local-appointments-admin-localize', array( 'LocalAppointmentsHelpers', 'localize_currency' ) );
    add_filter( 'local-appointments-admin-localize', array( 'LocalAppointmentsHelpers', 'localize_date_time' ) );

    add_filter( 'local-appointments-locale-element-ui', array( 'LocalAppointmentsHelpers', 'element_ui_locale' ) );

  }

  public static function element_ui_locale( $out ){
    $out['colorpicker'] = array(
      'confirm' => esc_html__( 'OK', 'local-appointments'),
      'clear' => esc_html__( 'Clear', 'local-appointments')
    );
    $out['datepicker'] = array(
      'now' => esc_html__( 'Now', 'local-appointments'),
      'today' => esc_html__( 'Today', 'local-appointments'),
      'cancel' => esc_html__( 'Cancel', 'local-appointments'),
      'clear' => esc_html__( 'Clear', 'local-appointments'),
      'confirm' => esc_html__( 'OK', 'local-appointments'),
      'selectDate' => esc_html__( 'Select date', 'local-appointments'),
      'selectTime' => esc_html__( 'Select time', 'local-appointments'),
      'startDate' => esc_html__( 'Start Date', 'local-appointments'),
      'startTime' => esc_html__( 'Start Time', 'local-appointments'),
      'endDate' => esc_html__( 'End Date', 'local-appointments'),
      'endTime' => esc_html__( 'End Time', 'local-appointments'),
      'year' => '',
      'month1' => esc_html__( 'Jan', 'local-appointments'),
      'month2' => esc_html__( 'Feb', 'local-appointments'),
      'month3' => esc_html__( 'Mar', 'local-appointments'),
      'month4' => esc_html__( 'Apr', 'local-appointments'),
      'month5' => esc_html__( 'May', 'local-appointments'),
      'month6' => esc_html__( 'Jun', 'local-appointments'),
      'month7' => esc_html__( 'Jul', 'local-appointments'),
      'month8' => esc_html__( 'Aug', 'local-appointments'),
      'month9' => esc_html__( 'Sep', 'local-appointments'),
      'month10' => esc_html__( 'Oct', 'local-appointments'),
      'month11' => esc_html__( 'Nov', 'local-appointments'),
      'month12' => esc_html__( 'Dec', 'local-appointments'),
      'weeks' =>  array(
        'sun' => esc_html__( 'Sun', 'local-appointments'),
        'mon' => esc_html__( 'Mon', 'local-appointments'),
        'tue' => esc_html__( 'Tue', 'local-appointments'),
        'wed' => esc_html__( 'Wed', 'local-appointments'),
        'thu' => esc_html__( 'Thu', 'local-appointments'),
        'fri' => esc_html__( 'Fri', 'local-appointments'),
        'sat' => esc_html__( 'Sat', 'local-appointments')
      ),
      'months' => array(
        'jan' => esc_html__( 'Jan', 'local-appointments'),
        'feb' => esc_html__( 'Feb', 'local-appointments'),
        'mar' => esc_html__( 'Mar', 'local-appointments'),
        'apr' => esc_html__( 'Apr', 'local-appointments'),
        'may' => esc_html__( 'May', 'local-appointments'),
        'jun' => esc_html__( 'Jun', 'local-appointments'),
        'jul' => esc_html__( 'Jul', 'local-appointments'),
        'aug' => esc_html__( 'Aug', 'local-appointments'),
        'sep' => esc_html__( 'Sep', 'local-appointments'),
        'oct' => esc_html__( 'Oct', 'local-appointments'),
        'nov' => esc_html__( 'Nov', 'local-appointments'),
        'dec' => esc_html__( 'Dec', 'local-appointments')
      )
    );
    $out['select'] = array(
      'loading' => esc_html__( 'Loading', 'local-appointments'),
      'noMatch' => esc_html__( 'No matching data', 'local-appointments'),
      'noData' => esc_html__( 'No data', 'local-appointments'),
      'placeholder' => esc_html__( 'Select', 'local-appointments')
    );
    $out['cascader'] = array(
      'noMatch' => esc_html__( 'No matching data', 'local-appointments'),
      'loading' => esc_html__( 'Loading', 'local-appointments'),
      'placeholder' => esc_html__( 'Select', 'local-appointments')
    );
    $out['pagination'] = array(
     'goto' => esc_html__( 'Go to', 'local-appointments'),
     'pagesize' => esc_html__( '/page', 'local-appointments'),
     'total' => esc_html__( 'Total {total}', 'local-appointments'),
     'pageClassifier' => ''
   );
   $out['messagebox'] = array(
      'title' => esc_html__( 'Message', 'local-appointments'),
      'confirm' => esc_html__( 'OK', 'local-appointments'),
      'cancel' => esc_html__( 'Cancel', 'local-appointments'),
      'error' => esc_html__( 'Illegal input', 'local-appointments')
    );
    $out['upload'] = array(
      'deleteTip' => esc_html__( 'press delete to remove', 'local-appointments'),
      'delete' => esc_html__( 'Delete', 'local-appointments'),
      'preview' => esc_html__( 'Preview', 'local-appointments'),
      'continue' => esc_html__( 'Continue', 'local-appointments')
    );
    $out['table'] = array(
      'emptyText' => esc_html__( 'No Data', 'local-appointments'),
      'confirmFilter' => esc_html__( 'Confirm', 'local-appointments'),
      'resetFilter' => esc_html__( 'Reset', 'local-appointments'),
      'clearFilter' => esc_html__( 'All', 'local-appointments'),
      'sumText' => esc_html__( 'Sum', 'local-appointments')
    );
    $out['tree'] = array(
     'emptyText' => esc_html__( 'No Data', 'local-appointments')
   );
   $out['transfer'] = array(
      'noMatch' => esc_html__( 'No matching data', 'local-appointments'),
      'noData' => esc_html__( 'No data', 'local-appointments'),
      'titles' => array( esc_html__( 'List 1', 'local-appointments'), esc_html__('List 2', 'local-appointments') ),
      'filterPlaceholder' => esc_html__( 'Enter keyword', 'local-appointments'),
      'noCheckedFormat' => esc_html__( '{total} items', 'local-appointments'),
      'hasCheckedFormat' => esc_html__( '{checked}/{total} checked', 'local-appointments')
    );
    return $out;
  }

  public static function localize_date_time( $arr ){

    global $wp_locale;

    $arr['first_day'] = intval( get_option( 'start_of_week') );
    $arr['day_names'] = array_values( $wp_locale->weekday );
    $arr['day_names_short'] = array_values( $wp_locale->weekday_abbrev );
    $arr['day_names_min'] = array_values( $wp_locale->weekday_initial );
    $arr['date_format'] = apply_filters( 'local-appointments-convert-date-time-format', get_option( 'date_format' ) );
    $arr['time_format'] = apply_filters( 'local-appointments-convert-date-time-format', get_option( 'time_format' ) );

    return $arr;
  }


  public static function default_currency( $arr ){
    return array(
      'currency' => 'USD',
      'currency_symbol' => "$",
      'currency_decimals' => 2,
      'currency_thousands' => ',',
      'currency_separator' => '.',
      'currency_position' => 1
    );
  }


  public static function localize_currency( $arr ){

    $default_settings = apply_filters( 'local-appointments-localize-default-currency', array() );
    $settings = get_option( 'local_appointments_settings', $default_settings );

    $settings = is_array( $settings ) ? $settings : $default_settings;

    foreach( $settings as $key => $setting ){
      $arr[$key] = $setting;
    }

    return $arr;
  }

  public static function parse_date_format( $format ){
      $replacements = [
          'd' => 'DD',
          'D' => 'ddd',
          'j' => 'D',
          'l' => 'dddd',
          'N' => 'E',
          'S' => 'o',
          'w' => 'e',
          'z' => 'DDD',
          'W' => 'W',
          'F' => 'MMMM',
          'm' => 'MM',
          'M' => 'MMM',
          'n' => 'M',
          't' => '', // no equivalent
          'L' => '', // no equivalent
          'o' => 'YYYY',
          'Y' => 'YYYY',
          'y' => 'YY',
          'a' => 'a',
          'A' => 'A',
          'B' => '', // no equivalent
          'g' => 'h',
          'G' => 'H',
          'h' => 'hh',
          'H' => 'HH',
          'i' => 'mm',
          's' => 'ss',
          'u' => 'SSS',
          'e' => 'zz', // deprecated since version 1.6.0 of moment.js
          'I' => '', // no equivalent
          'O' => '', // no equivalent
          'P' => '', // no equivalent
          'T' => '', // no equivalent
          'Z' => '', // no equivalent
          'c' => '', // no equivalent
          'r' => '', // no equivalent
          'U' => 'X',
      ];
      $momentFormat = strtr($format, $replacements);
      return $momentFormat;
  }

}

new LocalAppointmentsHelpers();
