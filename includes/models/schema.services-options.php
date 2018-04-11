<?php

add_filter( 'local-appointments-sc-services-schema', function(){
  return array(
    array(
      'name' => 'services',
      'validation' => 'is_array',
      'value' => array(
        array(
          'name' => 'show_duration',
          'validation' => 'wp_validate_boolean',
          'value' => false
        ),
        array(
          'name' => 'show_tagline',
          'validation' => 'wp_validate_boolean',
          'value' => true
        ),
        array(
          'name' => 'show_price',
          'validation' => 'wp_validate_boolean',
          'value' => false
        ),
        array(
          'name' => 'columns',
          'validation' => 'intval',
          'value' => 2
        )
      )
    ),
    array(
      'name' => 'days',
      'validation' => 'is_array',
      'value' => array(
        array(
          'name' => 'days_limit',
          'validation' => 'intval',
          'value' => 14
        ),
        array(
          'name' => 'columns',
          'validation' => 'intval',
          'value' => 5
        ),
        array(
          'name' => 'label_back',
          'value' => esc_html__( 'Back', 'local-appointments' )
        ),
        array(
          'name' => 'label_available',
          'value' => esc_html__( 'Available', 'local-appointments' )
        ),
        array(
          'name' => 'label_select_day',
          'value' => esc_html__( 'Select a Day', 'local-appointments' )
        ),
        array(
          'name' => 'label_starting',
          'value' => esc_html__( 'Starting', 'local-appointments' )
        ),
        array(
          'name' => 'label_ending',
          'value' => esc_html__( 'Ending', 'local-appointments' )
        ),
        array(
          'name' => 'show_filters_days',
          'validation' => 'wp_validate_boolean',
          'value' => true
        ),
        array(
          'name' => 'show_filters_hours',
          'validation' => 'wp_validate_boolean',
          'value' => false
        )
      )
    ),
    array(
      'name' => 'time',
      'validation' => 'is_array',
      'value' => array(
        array(
          'name' => 'time_increments',
          'validation' => 'intval',
          'value' => 14
        ),
        array(
          'name' => 'show_noon',
          'validation' => 'wp_validate_boolean',
          'value' => true
        )
      )
    ),
    array(
      'name' => 'details',
      'validation' => 'is_array',
      'value' => array(
        array(
          'name' => 'fields',
          'validation' => 'local_appointments_sanitize_fields_array',
          'value' => array(
            array(
              'validation' => 'is_array',
              'value' => array(
                array(
                  'name' => 'type',
                  'value' => 'text'
                ),
                array(
                  'name' => 'label',
                  'value' => esc_html__( 'Full Name', 'local-appointments' )
                ),
                array(
                  'name' => 'mandatory',
                  'value' => true,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'allow_mandatory',
                  'value' => false,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'allow_delete',
                  'value' => false,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'status',
                  'value' => true,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'placeholder',
                  'value' => esc_html__( 'Enter Full Name Here', 'local-appointments' )
                ),
                array(
                  'name' => 'value',
                  'value' => ''
                )
              )
            ),
            array(
              'validation' => 'is_array',
              'value' => array(
                array(
                  'name' => 'type',
                  'value' => 'email'
                ),
                array(
                  'name' => 'label',
                  'value' => esc_html__( 'Email Address', 'local-appointments' )
                ),
                array(
                  'name' => 'mandatory',
                  'value' => true,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'allow_mandatory',
                  'value' => false,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'allow_delete',
                  'value' => false,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'status',
                  'value' => true,
                  'validation' => 'wp_validate_boolean'
                ),
                array(
                  'name' => 'placeholder',
                  'value' => esc_html__( 'Enter Email Here', 'local-appointments' )
                ),
                array(
                  'name' => 'value',
                  'value' => ''
                )
              )
            ),
          )
        ),
      )
    ),
  );
});
