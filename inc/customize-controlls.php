<?php




function my_custom_text_settings( $fields ) {

    // Add the controls
    $fields[] = array(
        'label'       => __( 'My custom control', 'translation_domain' ),
        'section'     => 'my_section',
        'settings'    => 'my_setting',
        'type'        => 'text',
        'priority'    => 10,
        'option_type' => 'theme_mod',
        'capability'  => 'edit_theme_options',
    );

    $fields[] = array(
        'label'       => __( 'My custom control 2', 'translation_domain' ),
        'section'     => 'my_section',
        'settings'    => 'my_setting_2',
        'type'        => 'text',
        'priority'    => 20,
        'option_type' => 'theme_mod',
        'capability'  => 'edit_theme_options',
    );

    return $fields;

}
add_filter( 'kirki/fields', 'my_custom_text_settings' );
