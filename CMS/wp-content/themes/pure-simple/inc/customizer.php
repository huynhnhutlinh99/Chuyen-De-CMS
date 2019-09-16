<?php
/**
 * Pure and Simple Theme Customizer
 * @package Pure_and_Simple
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function puresimple_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->remove_section( 'colors');

	// Add custom description to Background sections.
	$wp_customize->get_section( 'background_image' )->description = __( 'Background may only be visible on boxed layout.', 'pure-simple' );
	
	/**
     *  Pro Page Note
     */
    class pure_simple_note extends WP_Customize_Control {
        public function render_content() {
            echo __( 'This feature is available in the <a href="https://www.styledthemes.com/themes/pure-simple/" title="premium version" target="_blank">Premium version</a>.', 'pure-simple' );

        }
    }


// Setting group for uploading logo
    $wp_customize->add_setting('puresimple_logo', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           	=> 'option',
		'sanitize_callback' => 'puresimple_sanitize_upload',
    ));
	
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'puresimple_logo', array(
        'label'    => __('Your Logo', 'pure-simple'),
        'section'  => 'title_tagline',
        'settings' => 'puresimple_logo',
		'priority' => 1,
    )));	
// header background colour
	$wp_customize->add_setting( 'header_bgccolour', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bgccolour', array(
		'label'   => __( 'Header Background Colour', 'pure-simple' ),
		'section' => 'title_tagline',
		'settings'   => 'header_bgccolour',
		'priority' => 2,			
	) ) );
// Site title background
	$wp_customize->add_setting( 'site_infobg', array(
		'default'        => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_infobg', array(
		'label'   => __( 'Site Title Background', 'pure-simple' ),
		'section' => 'title_tagline',
		'settings'   => 'site_infobg',
		'priority' => 3,			
	) ) );
// Site title colour
	$wp_customize->add_setting( 'site_titlecolour', array(
		'default'        => '#000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_titlecolour', array(
		'label'   => __( 'Site Title Colour', 'pure-simple' ),
		'section' => 'title_tagline',
		'settings'   => 'site_titlecolour',
		'priority' => 4,			
	) ) );			
// Site tagline colour
	$wp_customize->add_setting( 'tagline_colour', array(
		'default'        => '#b9b9b9',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_colour', array(
		'label'   => __( 'Site Tagline Colour', 'pure-simple' ),
		'section' => 'title_tagline',
		'settings'   => 'tagline_colour',
		'priority' => 5,			
	) ) );
	
// Setting site title size
	$wp_customize->add_setting( 'site_titlesize', array(
		'default'        => '2.75rem',
		'sanitize_callback' => 'puresimple_sanitize_text',
	) );

	$wp_customize->add_control( 'site_titlesize', array(
		'settings' => 'site_titlesize',
		'label'    => __( 'Site Title Size', 'pure-simple' ),
		'section'  => 'title_tagline',		
		'type'     => 'text',
		'priority' => 6,
	) );

// Setting site tagline size
	$wp_customize->add_setting( 'site_taglinesize', array(
		'default'        => '1.375rem',
		'sanitize_callback' => 'puresimple_sanitize_text',
	) );

	$wp_customize->add_control( 'site_taglinesize', array(
		'settings' => 'site_taglinesize',
		'label'    => __( 'Site Tagline Size', 'pure-simple' ),
		'section'  => 'title_tagline',		
		'type'     => 'text',
		'priority' => 7,
	) );
	
// Setting site header height by padding
	$wp_customize->add_setting( 'header_padding', array(
		'default'        => '2rem 0 2rem 0',
		'sanitize_callback' => 'puresimple_sanitize_text',
	) );

	$wp_customize->add_control( 'header_padding', array(
		'settings' => 'header_padding',
		'label'    => __( 'Header Height with Padding', 'pure-simple' ),
		'section'  => 'title_tagline',		
		'type'     => 'text',
		'priority' => 8,
	) );
			
	
/**
 * This is a section called Basic Settings
 * For miscellaneous options
 */

	$wp_customize->add_section( 'basic_settings', array(
		'title'          => __( 'Basic Settings', 'pure-simple' ),
		'priority'       => 25,
	) );
	// hide default content from theme
	$wp_customize->add_setting( 'hide_default_content', array(
		'default' => 0,
		'sanitize_callback' => 'puresimple_sanitize_checkbox',
	));
	$wp_customize->add_control( 'hide_default_content', array(
        'type' => 'checkbox',
        'label'    => __( 'Hide default content from theme', 'pure-simple' ),
        'section' => 'basic_settings',
		'priority' => 1,
    ) );
	// Setting for page width
		$wp_customize->add_setting( 'page_width', array(
			'default' => 'boxwide',
			'sanitize_callback' => 'puresimple_sanitize_pagewidth',
		) );
	// Control for page width	
		$wp_customize->add_control( 'page_width', array(
		'label'   => __( 'Page Width', 'pure-simple' ),
		'section' => 'basic_settings',
		'type'    => 'radio',
			'choices' => array(
				'boxwide' => __( 'Full Screen', 'pure-simple' ),
				'boxmedium' => __( 'Smaller Width 1500px', 'pure-simple' ),
				'boxsmall' => __( 'Smaller Width 1200px', 'pure-simple' ),
			),
		'priority'       => 2,	
		));	

	// Setting for blog layout
		$wp_customize->add_setting( 'blog_layout', array(
			'default' => 'blogright',
			'sanitize_callback' => 'puresimple_sanitize_bloglayout',
		) );
	// Control for blog layout	
		$wp_customize->add_control( 'blog_layout', array(
		'label'   => __( 'Blog Layout', 'pure-simple' ),
		'section' => 'basic_settings',
		'priority' => 3,
		'type'    => 'radio',
			'choices' => array(
				'blogright' => __( 'Blog with Right Sidebar', 'pure-simple' ),
				'blogleft' => __( 'Blog with Left Sidebar', 'pure-simple' ),
				'blogwide' => __( 'Blog Full Width &amp; no Sidebars', 'pure-simple' ),
			),
		));

	// Setting for blog style
		$wp_customize->add_setting( 'blog_style', array(
			'default' => 'blogstyle1',
			'sanitize_callback' => 'puresimple_sanitize_blogstyle',
		) );
	// Control for blog layout	
		$wp_customize->add_control( 'blog_style', array(
		'label'   => __( 'Blog Summary Style', 'pure-simple' ),
		'section' => 'basic_settings',
		'priority' => 4,
		'type'    => 'radio',
			'choices' => array(
				'blogstyle1' => __( 'Style 1', 'pure-simple' ),
				'blogstyle2' => __( 'Style 2', 'pure-simple' ),
				'blogstyle3' => __( 'Style 3', 'pure-simple' ),
				'blogstyle4' => __( 'style 4', 'pure-simple' ),
			),
		));

// Setting for content or excerpt
	$wp_customize->add_setting( 'excerpt_content', array(
		'default' => 'content',
		'sanitize_callback' => 'puresimple_sanitize_excerpt',
	) );
// Control for Content or excerpt
	$wp_customize->add_control( 'excerpt_content', array(
    'label'   => __( 'Content or Excerpt', 'pure-simple' ),
    'section' => 'basic_settings',
    'type'    => 'radio',
        'choices' => array(
            'content' => __( 'Content', 'pure-simple' ),
            'excerpt' => __( 'Excerpt', 'pure-simple' ),	
        ),
	'priority'       => 5,
    ));

// Setting group for a excerpt
	$wp_customize->add_setting( 'excerpt_limit', array(
		'default'        => '50',
		'sanitize_callback' => 'puresimple_sanitize_number',
	) );
	$wp_customize->add_control( 'excerpt_limit', array(
		'settings' => 'excerpt_limit',
		'label'    => __( 'Excerpt Length', 'pure-simple' ),
		'section'  => 'basic_settings',
		'type'     => 'text',
		'priority'       => 6,
	) );


// hide featured image on single
	$wp_customize->add_setting( 'hide_featured', array(
	'sanitize_callback' => 'puresimple_sanitize_checkbox',
	));
	$wp_customize->add_control( 'hide_featured', array(
        'type' => 'checkbox',
        'label'    => __( 'Hide Featured Image on Full Post', 'pure-simple' ),
        'section' => 'basic_settings',
		'priority' => 7,
    ) );
		
// hide post edit links
	$wp_customize->add_setting( 'hide_edit', array(
	'sanitize_callback' => 'puresimple_sanitize_checkbox',
	));
	$wp_customize->add_control( 'hide_edit', array(
        'type' => 'checkbox',
        'label'    => __( 'Hide Edit Links', 'pure-simple' ),
        'section' => 'basic_settings',
		'priority' => 8,
    ) );
// Setting group for a Copyright
	$wp_customize->add_setting( 'copyright', array(
		'default'        => 'Your Name',
		'sanitize_callback' => 'puresimple_sanitize_text',
	) );

	$wp_customize->add_control( 'copyright', array(
		'settings' => 'copyright',
		'label'    => __( 'Your Copyright Name', 'pure-simple' ),
		'section'  => 'basic_settings',		
		'type'     => 'text',
		'priority' => 13,
	) );
	
     /*
    =================================================
    Move to top setting
    =================================================
    */

    $wp_customize->add_setting( 'movetotop', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'movetotop', array(
		'settings' => 'movetotop',
		'label'    => __( 'Enable Move To Top', 'pure-simple' ),
		'section'  => 'basic_settings',		
		'type'     => 'checkbox',
		'priority' => 12,
	) );


	$wp_customize->add_section( 'sticky_menu', array(
		'title'          => __( 'Sticky Menu', 'pure-simple' ),
		'priority'       => 25,
	) );

	$wp_customize->add_setting( 'pure_simple_sticky_menu', array(
            'sanitize_callback' =>  'puresimple_sanitize_text'
        ) );

	 $wp_customize->add_control( new pure_simple_note ( $wp_customize,'pure_simple_sticky_menu', array(
            'section'  => 'sticky_menu'
     ) ) );
	
	// Setting for page width
		$wp_customize->add_setting( 'sticky_menu', array(
			'default' => '1',
			'sanitize_callback' => 'puresimple_sanitize_checkbox',
		) );
	// Control for page width	
		$wp_customize->add_control( 'sticky_menu', array(
		'label'   => __( 'Sticky Menu', 'pure-simple' ),
		'section' => 'sticky_menu',
		'type'    => 'checkbox',
		'priority'       => 2,	
		));	
	

/**
 * Create a section called Colours
 */

	$wp_customize->add_section( 'colours', array(
		'title'          => __( 'Colours', 'pure-simple' ),
		'priority'       => 30,
	) );


// Menu background
	$wp_customize->add_setting( 'menu_bg', array(
		'default'        => '#789993',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bg', array(
		'label'   => __( 'Menu Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'menu_bg',
		'priority' => 2,			
	) ) );		
// Caption header background
	$wp_customize->add_setting( 'caption_header_bgccolour', array(
		'default'        => '#3d3d3d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caption_header_bgccolour', array(
		'label'   => __( 'Caption Header Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'caption_header_bgccolour',
		'priority' => 3,			
	) ) );
	
// Caption header text
	$wp_customize->add_setting( 'caption_header_text', array(
		'default'        => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caption_header_text', array(
		'label'   => __( 'Caption Header Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'caption_header_text',
		'priority' => 4,			
	) ) );	
// Breadcrumb background
	$wp_customize->add_setting( 'breadcrumb_bg', array(
		'default'        => '#e6e6e6',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'breadcrumb_bg', array(
		'label'   => __( 'Breadcrumb Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'breadcrumb_bg',
		'priority' => 5,			
	) ) );	
// Breadcrumb text
	$wp_customize->add_setting( 'breadcrumb_text', array(
		'default'        => '#9e9e9e',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'breadcrumb_text', array(
		'label'   => __( 'Breadcrumb Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'breadcrumb_text',
		'priority' => 6,			
	) ) );
// CTA background
	$wp_customize->add_setting( 'cta_bg', array(
		'default'        => '#fff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_bg', array(
		'label'   => __( 'Call to Action Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'cta_bg',
		'priority' => 7,			
	) ) );
// CTA Heading
	$wp_customize->add_setting( 'cta_heading', array(
		'default'        => '#4c4c4c',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_heading', array(
		'label'   => __( 'Call to Action Heading', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'cta_heading',
		'priority' => 8,			
	) ) );
// CTA text
	$wp_customize->add_setting( 'cta_text', array(
		'default'        => '#adadad',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cta_text', array(
		'label'   => __( 'Call to Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'cta_text',
		'priority' => 9,			
	) ) );		
// Content background
	$wp_customize->add_setting( 'content_bg', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_bg', array(
		'label'   => __( 'Main Content Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'content_bg',
		'priority' => 10,			
	) ) );
	
// Main content text
	$wp_customize->add_setting( 'contenttext', array(
		'default'        => '#767676',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'contenttext', array(
		'label'   => __( 'Main Content Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'contenttext',
		'priority' => 11,			
	) ) );

// bottom widget area background
	$wp_customize->add_setting( 'bottomwidgets_bg', array(
		'default'        => '#566965',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottomwidgets_bg', array(
		'label'   => __( 'Bottom Widgets Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'bottomwidgets_bg',
		'priority' => 12,			
	) ) );
// Bottom Widgets text
	$wp_customize->add_setting( 'bottomtext', array(
		'default'        => '#cadad7',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottomtext', array(
		'label'   => __( 'Bottom Widget Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'bottomtext',
		'priority' => 13,			
	) ) );

// Bottom Widgets links
	$wp_customize->add_setting( 'bottom_links', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_links', array(
		'label'   => __( 'Bottom Widget Link', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'bottom_links',
		'priority' => 14,			
	) ) );
// Bottom Widgets links on hover
	$wp_customize->add_setting( 'bottom_linkshover', array(
		'default'        => '#cadad7',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bottom_linkshover', array(
		'label'   => __( 'Bottom Widget Link on Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'bottom_linkshover',
		'priority' => 15,			
	) ) );	
	
	
	
	
// Footer background
	$wp_customize->add_setting( 'footer_bg', array(
		'default'        => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bg', array(
		'label'   => __( 'Footer Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'footer_bg',
		'priority' => 16,			
	) ) );

// Footer text
	$wp_customize->add_setting( 'footertext', array(
		'default'        => '#767676',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footertext', array(
		'label'   => __( 'Footer Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'footertext',
		'priority' => 17,			
	) ) );

// Post and page titles
	$wp_customize->add_setting( 'post_title', array(
		'default'        => '#4c4c4c',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_title', array(
		'label'   => __( 'Post &amp; Page Titles', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'post_title',
		'priority' => 18,			
	) ) );

// Post and page titles on hover
	$wp_customize->add_setting( 'post_title_on_hover', array(
		'default'        => '#a48a61',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_title_on_hover', array(
		'label'   => __( 'Post &amp; Page Titles On Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'post_title_on_hover',
		'priority' => 18,			
	) ) );

// Widget titles
	$wp_customize->add_setting( 'widgetx_titles', array(
		'default'        => '#4c4c4c',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'widgetx_titles', array(
		'label'   => __( 'Widget Titles', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'widgetx_titles',
		'priority' => 19,			
	) ) );

// Content Links
	$wp_customize->add_setting( 'content_links', array(
		'default'        => '#c69f63',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_links', array(
		'label'   => __( 'Content Links', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'content_links',
		'priority' => 20,			
	) ) );
// Content Links on hover
	$wp_customize->add_setting( 'content_linkshover', array(
		'default'        => '#767676',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_linkshover', array(
		'label'   => __( 'Content Links on Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'content_linkshover',
		'priority' => 21,			
	) ) );

// Footer links
	$wp_customize->add_setting( 'footer_links', array(
		'default'        => '#b2b2b2',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_links', array(
		'label'   => __( 'Footer Links', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'footer_links',
		'priority' => 22,			
	) ) );

// Footer links on hover
	$wp_customize->add_setting( 'footer_linkshover', array(
		'default'        => '#767676',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_linkshover', array(
		'label'   => __( 'Footer Links on Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'footer_linkshover',
		'priority' => 23,			
	) ) );

// Read more
	$wp_customize->add_setting( 'read_more', array(
		'default'        => '#789993',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_more', array(
		'label'   => __( 'Read More Button Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'read_more',
		'priority' => 24,			
	) ) );
// Read more text
	$wp_customize->add_setting( 'read_moretext', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_moretext', array(
		'label'   => __( 'Read More Text', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'read_moretext',
		'priority' => 25,			
	) ) );
// Read more hover
	$wp_customize->add_setting( 'read_morehover', array(
		'default'        => '#a48a61',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_morehover', array(
		'label'   => __( 'Read More Background on Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'read_morehover',
		'priority' => 26,			
	) ) );
// Read more hover text
	$wp_customize->add_setting( 'read_morehover_text', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_morehover_text', array(
		'label'   => __( 'Read More Text on Hover', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'read_morehover_text',
		'priority' => 27,			
	) ) );




// Main menu link background on hover
	$wp_customize->add_setting( 'menu_hoverbg', array(
		'default'        => '#080d07',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_hoverbg', array(
		'label'   => __( 'Menu Hover Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'menu_hoverbg',
		'priority' => 28,			
	) ) );	
// Main menu link active background
	$wp_customize->add_setting( 'menu_activebg', array(
		'default'        => '#080d07',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_activebg', array(
		'label'   => __( 'Menu Active Background', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'menu_activebg',
		'priority' => 29,			
	) ) );	
	
// Main menu link
	$wp_customize->add_setting( 'menu_link', array(
		'default'        => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_link', array(
		'label'   => __( 'Menu Link Colour', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'menu_link',
		'priority' => 30,			
	) ) );

		
// Main submenu link
	$wp_customize->add_setting( 'submenu_link', array(
		'default'        => '#b6b6b6',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_link', array(
		'label'   => __( 'Submenu Link Colour', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'submenu_link',
		'priority' => 31,			
	) ) );
	
//sub menu background color
	$wp_customize->add_setting( 'submenu_bg_color', array(
		'default'        => '#080d07',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_bg_color', array(
		'label'   => __( 'Submenu Background Colour', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'submenu_bg_color',
		'priority' => 31,			
	) ) );

// Main submenu borders
	$wp_customize->add_setting( 'submenu_borders', array(
		'default'        => '#363535',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_borders', array(
		'label'   => __( 'Submenu Border Lines', 'pure-simple' ),
		'section' => 'colours',
		'settings'   => 'submenu_borders',
		'priority' => 32,			
	) ) );

	/**
 * Create a section called Mobile Menu Colors
 */
	$wp_customize->add_section( 'puresimple_mobilemenu_colors', array(
	'title'          => __( 'Mobile Navigation Colours', 'pure-simple' ),
	'priority'       => 34,
	) );
		

	// Mobile Menu Toggle background
	$wp_customize->add_setting( 'puresimple_toggle_bg', array(
		'default'        => '#080d07',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'puresimple_toggle_bg', array(
		'label'   => __( 'Toggle Menu Background', 'pure-simple' ),
		'section' => 'puresimple_mobilemenu_colors',
		'priority' => 1,			
	) ) );

	// Mobile Menu Toggle text color
	$wp_customize->add_setting( 'puresimple_toggle_text', array(
		'default'        => '#FFF',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'puresimple_toggle_text', array(
		'label'   => __( 'Toggle Text Color', 'pure-simple' ),
		'section' => 'puresimple_mobilemenu_colors',
		'priority' => 2,			
	) ) );

	// Mobile Menu color
	$wp_customize->add_setting( 'puresimple_menu_bg', array(
		'default'        => '#262826',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'puresimple_menu_bg', array(
		'label'   => __( 'Mobile Menu Background Color', 'pure-simple' ),
		'section' => 'puresimple_mobilemenu_colors',
		'priority' => 3,			
	) ) );

	// Mobile Menu link color
	$wp_customize->add_setting( 'puresimple_menu_link', array(
		'default'        => '#b8b8b8',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'puresimple_menu_link', array(
		'label'   => __( 'Mobile Menu Link Color', 'pure-simple' ),
		'section' => 'puresimple_mobilemenu_colors',
		'priority' => 4,			
	) ) );	

	$wp_customize->add_section( 'nav_position', array(
		'title'          => __( 'Navmenu Postion', 'pure-simple' ),
		'priority'       => 35,
	) );

	$wp_customize->add_setting( 'pure_simple_nav_position', array(
            'sanitize_callback' =>  'puresimple_sanitize_text'
        ) );
	 $wp_customize->add_control( new pure_simple_note ( $wp_customize,'pure_simple_sticky_menu', array(
            'section'  => 'nav_position'
     ) ) );
	
	// Setting for page width
		$wp_customize->add_setting( 'nav_position', array(
			'default' => '1',
			'sanitize_callback' => 'puresimple_sanitize_radio',
		) );
	// Control for page width	
		$wp_customize->add_control( 'nav_position', array(
		'label'   => __( 'Navigation Position', 'pure-simple' ),
		'section' => 'nav_position',
		'type'    => 'radio',
			'choices' => array(
				'top' => __( 'Top Of Banner', 'pure-simple' ),
				'boxmedium' => __( 'Bottom of Banner', 'pure-simple' ),
				
			),

		'priority'       => 3,	
		));	
			
	
/**
 * This is a custom section called Social Networking
 * which contains settings for social networking icons and links
 */
	$wp_customize->add_section( 'social_networking', array(
		'title'          => __( 'Social Networking', 'pure-simple' ),
		'priority'       => 50,
	) );


	
// Setting for hiding the social bar	
	$wp_customize->add_setting( 'hide_social', array(
	'sanitize_callback' => 'puresimple_sanitize_checkbox',
	));
	
	
// Control for hiding the social bar	
	$wp_customize->add_control( 'hide_social', array(
        'label' => __( 'Hide Social Bar', 'pure-simple' ),
		'type' => 'checkbox',
		'section' => 'social_networking',
		'priority' => 1,
    ) );

	
// Setting group for Twitter
	$wp_customize->add_setting( 'twitter_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'twitter_uid', array(
		'settings' => 'twitter_uid',
		'label'    => __( 'Twitter', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 2,
	) );	
	
// Setting group for Facebook
	$wp_customize->add_setting( 'facebook_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'facebook_uid', array(
		'settings' => 'facebook_uid',
		'label'    => __( 'Facebook', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 3,
	) );	
	
// Setting group for Google+
	$wp_customize->add_setting( 'google_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'google_uid', array(
		'settings' => 'google_uid',
		'label'    => __( 'Google+', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 4,
	) );	
	
// Setting group for Linkedin
	$wp_customize->add_setting( 'linkedin_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'linkedin_uid', array(
		'settings' => 'linkedin_uid',
		'label'    => __( 'Linkedin', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 5,
	) );	
	
// Setting group for Pinterest
	$wp_customize->add_setting( 'pinterest_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'pinterest_uid', array(
		'settings' => 'pinterest_uid',
		'label'    => __( 'Pinterest', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 6,
	) );

// Setting group for Flickr
	$wp_customize->add_setting( 'flickr_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'flickr_uid', array(
		'settings' => 'flickr_uid',
		'label'    => __( 'Flickr', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 7,
	) );
// Setting group for Youtube
	$wp_customize->add_setting( 'youtube_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'youtube_uid', array(
		'settings' => 'youtube_uid',
		'label'    => __( 'Youtube', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 8,
	) );	
// Setting group for Vimeo
	$wp_customize->add_setting( 'vimeo_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'vimeo_uid', array(
		'settings' => 'vimeo_uid',
		'label'    => __( 'Vimeo', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 9,
	) );
// Setting group for Instagram
	$wp_customize->add_setting( 'instagram_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'instagram_uid', array(
		'settings' => 'instagram_uid',
		'label'    => __( 'Instagram', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 10,
	) );	
	
	
// Setting group for Reddit
	$wp_customize->add_setting( 'reddit_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'reddit_uid', array(
		'settings' => 'reddit_uid',
		'label'    => __( 'Reddit', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 11,
	) );	
// Setting group for Picassa
	/* $wp_customize->add_setting( 'picassa_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'picassa_uid', array(
		'settings' => 'picassa_uid',
		'label'    => __( 'Picassa', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 12,
	) );
	*/	
// Setting group for Stumbleupon
	$wp_customize->add_setting( 'stumbleupon_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'stumbleupon_uid', array(
		'settings' => 'stumbleupon_uid',
		'label'    => __( 'Stubmleupon', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 13,
	) );	
// Setting group for WordPress
	$wp_customize->add_setting( 'wp_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'wp_uid', array(
		'settings' => 'wp_uid',
		'label'    => __( 'WordPress', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 14,
	) );
// Setting group forgithub
	$wp_customize->add_setting( 'github_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'github_uid', array(
		'settings' => 'github_uid',
		'label'    => __( 'Github', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 15,
	) );	
// Setting group dribbble
	$wp_customize->add_setting( 'dribbble_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'dribbble_uid', array(
		'settings' => 'dribbble_uid',
		'label'    => __( 'Dribbble', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 16,
	) );	
// Setting group tumbler
	$wp_customize->add_setting( 'tumblr_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'tumblr_uid', array(
		'settings' => 'tumblr_uid',
		'label'    => __( 'Tumblr', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 17,
	) );				
// Setting group for rss
	$wp_customize->add_setting( 'rss_uid', array(
		'default'        => '',
		'sanitize_callback' => 'puresimple_sanitize_url',
	) );

	$wp_customize->add_control( 'rss_uid', array(
		'settings' => 'rss_uid',
		'label'    => __( 'RSS', 'pure-simple' ),
		'section'  => 'social_networking',
		'type'     => 'text',
		'priority' => 18,
	) );	
	
	// Social icon colour
	$wp_customize->add_setting( 'social_colour', array(
		'default'        => '#767676',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_colour', array(
		'label'   => __( 'Social Icon Colour', 'pure-simple' ),
		'section' => 'social_networking',
		'settings'   => 'social_colour',
		'priority' => 20,			
	) ) );

	// Social icon colour on hover
	$wp_customize->add_setting( 'social_hover', array(
		'default'        => '#9c9c9c',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_hover', array(
		'label'   => __( 'Social Icon Hover', 'pure-simple' ),
		'section' => 'social_networking',
		'settings'   => 'social_hover',
		'priority' => 21,			
	) ) );
	
	// Social icon background
	$wp_customize->add_setting( 'social_bg', array(
		'default'        => '#42474d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'social_bg', array(
		'label'   => __( 'Social Icon Background', 'pure-simple' ),
		'section' => 'social_networking',
		'settings'   => 'social_bg',
		'priority' => 22,			
	) ) );		

		
}
add_action( 'customize_register', 'puresimple_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function puresimple_customize_preview_js() {
	wp_enqueue_script( 'puresimple_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'puresimple_customize_preview_js' );


		
		
/**
 * This is our theme sanitization settings
 * to help make things safer
 */		

// adds sanitization callback function for numeric data : number
function puresimple_sanitize_number( $value ) {
    $value = (int) $value; // Force the value into integer type.
    return ( 0 < $value ) ? $value : null;
}


// adds sanitization callback function : text 
function puresimple_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}


// adds sanitization callback function : url
function puresimple_sanitize_url( $value) {
	$value = esc_url_raw( $value);
	return $value;
}

// adds sanitization callback function : checkbox
function puresimple_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}	
	
// adds sanitization callback function : select
function puresimple_sanitize_masonry_select( $input ) {
    $valid = array(
            'col-md-3' => '4 Columns',
			'col-md-4' => '3 Columns',
			'col-md-6' => '2 Columns',           
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}	
		
// adds sanitization callback function for the page width : radio
function puresimple_sanitize_pagewidth( $input ) {
    $valid = array(
				'boxwide' => __( 'Full Screen', 'pure-simple' ),
				'boxmedium' => __( 'Smaller Width 1500px', 'pure-simple' ),
				'boxsmall' => __( 'Smaller Width 1200px', 'pure-simple' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
		
// adds sanitization callback function for the blog layout : radio
function puresimple_sanitize_bloglayout( $input ) {
    $valid = array(
				'blogright' => __( 'Blog with Right Sidebar', 'pure-simple' ),
				'blogleft' => __( 'Blog with Left Sidebar', 'pure-simple' ),
				'blogwide' => __( 'Blog Full Width &amp; no Sidebars', 'pure-simple' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}		

// adds sanitization callback function for the blog style : radio
function puresimple_sanitize_blogstyle( $input ) {
    $valid = array(
				'blogstyle1' => __( 'Style 1', 'pure-simple' ),
				'blogstyle2' => __( 'Style 2', 'pure-simple' ),
				'blogstyle3' => __( 'Style 3', 'pure-simple' ),
				'blogstyle4' => __( 'Style 4', 'pure-simple' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}


// adds sanitization callback function for the excerpt : radio
function puresimple_sanitize_excerpt( $input ) {
    $valid = array(
		'content' => __( 'Content', 'pure-simple' ),
        'excerpt' => __( 'Excerpt', 'pure-simple' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
		
// adds sanitization callback function for uploading : uploader
add_filter( 'puresimple_sanitize_image', 'puresimple_sanitize_upload' );
add_filter( 'puresimple_sanitize_file', 'puresimple_sanitize_upload' );

function puresimple_sanitize_upload( $input ) {        
        $output = '';        
        $filetype = wp_check_filetype($input);       
        if ( $filetype["ext"] ) {        
                $output = $input;        
        }       
        return $output;
}		
		

/**
 *  Registers
 */
/*function puresimple_registers() {
    wp_register_script( 'puresimple_customizer_script', get_template_directory_uri() . '/js/global.js', array("jquery"), '20120206', true  );
    wp_enqueue_script( 'puresimple_customizer_script' );
    wp_localize_script( 'puresimple_customizer_script', 'puresimple_buttons', array(
        'pro'       => __( 'View Pro Version', 'pure-simple' ),
        'rate'       => __( 'Rate Us', 'pure-simple' ),
        'documentation'       => __( 'View Documentation', 'pure-simple' ),
    ) );
}
add_action( 'customize_controls_enqueue_scripts', 'puresimple_registers' );*/