<?php
function mytheme_kirki_sections( $wp_customize ) {
    /**
     * Add panels
     */
    $wp_customize->add_panel( 'backgrounds', array(
        'priority'    => 10,
        'title'       => __( 'Backgrounds', 'kirki' ),
    ) );

    /**
     * Add sections
     */
     $wp_customize->add_section( 'header_background', array(
        'title'       => __( 'Header Background', 'kirki' ),
        'priority'    => 10,
        'panel'       => 'backgrounds',
    ) );

     $wp_customize->add_section( 'main_background', array(
        'title'       => __( 'Main Background', 'kirki' ),
        'priority'    => 20,
        'panel'       => 'backgrounds',
    ) );

     $wp_customize->add_section( 'footer_background', array(
        'title'       => __( 'Footer Background', 'kirki' ),
        'priority'    => 30,
        'panel'       => 'backgrounds',
    ) );

     $wp_customize->add_section( 'typography', array(
        'title'       => __( 'Typography', 'kirki' ),
        'priority'    => 20,
    ) );

}
add_action( 'customize_register', 'mytheme_kirki_sections' );

function mytheme_kirki_fields( $wp_customize ) {
    
    $fields[] = array(
        'type'        => 'select',
        'setting'     => 'font_family',
        'label'       => __( 'Font-Family', 'kirki' ),
        'description' => __( 'Please choose a font for your site. This font-family will be applied to all elements on your page, including headers and body.', 'kirki' ),
        'section'     => 'typography',
        'default'     => 'Roboto',
        'priority'    => 10,
        'choices'     => Kirki_Fonts::get_font_choices(),
        'output'      => array(
            array(
                'element'  => 'body, h1, h2, h3, h4, h5, h6',
                'property' => 'font-family',
            ),
        ),
        'transport'   => 'postMessage',
        'js_vars'     => array(
            array(
                'element'  => 'body, h1, h2, h3, h4, h5, h6',
                'function' => 'css',
                'property' => 'font-family',
            ),
        ),
    );

    
}
add_filter( 'kirki/fields', 'mytheme_kirki_fields' );