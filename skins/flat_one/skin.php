<?php

class LRM_Skin_Flat_One extends LRM_Skin_Base {

    public function __construct() {
        $this->slug = 'flat_one';
        $this->title = 'Flat One';
        $this->url = LRM_PRO_URL . 'skins/';

        $this->supports_customizer = true;

        $this->customizer_section_title = '[skin] Flat One';

        parent::__construct();
    }

    public function register_customizer_settings() {

        $this->_register_customizer_setting( "open_modal", array(
            'default' => '1',
            'setting_type' => 'option',
            'setting_transport' => 'postMessage',
            //'sanitize_callback' => 'sanitize_hex_color',
            'type_class' => 'LRM_Pro_WP_Customize_Control_Button',

            'label'      => __( 'Display modal for customize', 'ajax-login-and-registration-modal-popup' ),
            'description'=> __( 'Open modal >>', 'ajax-login-and-registration-modal-popup' ),

            'type' => 'button',
        ) );

        $this->_register_customizer_setting( "btn_color", array(
            'default' => '#ffffff',
            'setting_type' => 'option',
            'setting_transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',

            'label' => 'Buttons color',
            'type' => 'color',
        ), array(
            '.lrm-form a.button,.lrm-form button,.lrm-form button[type=submit],.lrm-form #buddypress input[type=submit],.lrm-form .gform_wrapper input.gform_button[type=submit],.lrm-form input[type=submit]' => array('attribute' => 'color','type' => 'css',),
        ) );

        $this->_register_customizer_setting( "btn_bg", array(
            'default' => '#000000',
            'setting_type' => 'option',
            'setting_transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',

            'label' => 'Buttons background color',
            'type' => 'color',
        ), array(
            '.lrm-form a.button,.lrm-form button,.lrm-form button[type=submit],.lrm-form #buddypress input[type=submit],.lrm-form .gform_wrapper input.gform_button[type=submit],.lrm-form input[type=submit] ' => array('attribute' => 'background-color','type' => 'css',),
        ) );

        $this->_register_customizer_setting( "inactive_tab_bg", array(
            'default' => '#000000',
            'setting_type' => 'option',
            'setting_transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',

            'label' => 'Inactive tab background',
            'type' => 'color',
        ), array(
            '.lrm-user-modal-container .lrm-switcher a:not(.selected)' => array('attribute' => 'background-color','type' => 'css',),
        ) );

        $this->_register_customizer_setting( "inactive_tab_color", array(
            'default' => '#ffffff',
            'setting_type' => 'option',
            'setting_transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',

            'label' => 'Inactive tab color',
            'type' => 'color',
        ), array(
            '.lrm-user-modal-container .lrm-switcher a:not(.selected) ' => array('attribute' => 'color','type' => 'css',),
        ) );

    }

}