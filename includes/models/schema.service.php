<?php

add_filter( 'local-appointments-schema-service', function(){
  return array(
    'name' => array(
      'type' => 'string',
      'description' => 'Please choose a name'
    ),
    'status' => array(
      'type' => 'string',
      'default' => 'publish'
    ),
    'tagline' => array(
      'type' => 'string',
      'description' => 'Please choose a tagline'
    ),
    'description' => array(
      'type' => 'string',
      'description' => 'Please choose a decription'
    ),
    'color' => array(
      'type' => 'string',
      'description' => 'Please choose a color'
    ),
    'duration_type' => array(
      'type' => 'integer'
    ),
    'duration' => array(
      'type' => 'integer'
    ),
    'capacity' => array(
      'type' => 'integer'
    ),
    'price' => array(
      'type' => 'number'
    ),
  );
  return array(
    array(
      'name' => 'status',
      'validation' => 'wp_validate_boolean',
      'value' => true
    ),
    array(
      'name' => 'name',
      'value' => ''
    ),
    array(
      'name' => 'tagline',
      'value' => ''
    ),
    array(
      'name' => 'description',
      'value' => ''
    ),
    array(
      'name' => 'color',
      'value' => ''
    ),
    array(
      'name' => 'duration_type',
      'validation' => 'intval',
      'value' => 30
    ),
    array(
      'name' => 'duration',
      'validation' => 'intval',
      'value' => 30
    ),
    array(
      'name' => 'availability',
      'validation' => 'local_appointments_sanitize_availability',
      'value' => array()
    ),
    array(
      'name' => 'padding',
      'validation' => 'is_array',
      'value' => array(
        array(
          'name' => 'before',
          'validation' => 'intval',
          'value' => 0
        ),
        array(
          'name' => 'after',
          'validation' => 'intval',
          'value' => 0
        )
      )
    ),
    array(
      'name' => 'rolling_method',
      'validation' => 'intval',
      'value' => 1
    ),
    array(
      'name' => 'rolling_days',
      'validation' => 'intval',
      'value' => 40
    ),
    array(
      'name' => 'rolling_date_range',
      'validation' => 'is_array',
      'value' => array()
    ),
    array(
      'name' => 'price',
      'validation' => 'is_numeric',
      'value' => 0
    ),
    array(
      'name' => 'capacity',
      'validation' => 'intval',
      'value' => 0
    )
  );
});
