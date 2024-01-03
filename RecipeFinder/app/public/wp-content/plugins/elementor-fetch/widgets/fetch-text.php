<?php

namespace ElementorFetchWidgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FetchText extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'fetch_text';
    }

    public function get_title()
    {
        return 'Fetch Text';
    }

    public function get_icon()
    {
        return 'eicon-text-area';
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => 'Content',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'text_id',
            [
                'label' => 'Text ID (without #)',
                'type' => \Elementor\Controls_Manager::TEXT,

                'placeholder' => 'first-text',
            ]
        );

        $this->add_control(
            'input_type',
            [
                'label' => 'Input Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'input' => 'Input',
                    'div' => 'Text',
                ],
                'default' => 'input',
            ]
        );


        $this->add_control(
            'placeholder',
            [
                'label' => 'Placeholder',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'placeholder',
                'condition' => [
                    'input_type' => 'input',
                ],
            ]
        );

        $this->add_control(
            'text_type',
            [
                'label' => 'Text Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'single' => 'Single Line',
                    'multi' => 'Multi Line',
                ],
                'default' => 'single',
                'condition' => [
                    'input_type' => 'div',
                ],
            ]
        );


        $this->add_control(
            'single_text',
            [
                'label' => 'Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'Default text',
                'condition' => [
                    'text_type' => 'single',
                ],
            ]
        );

        $this->add_control(
            'multi_text',
            [
                'label' => 'Text',
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => 'Default text',
                'condition' => [
                    'text_type' => 'multi',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ('multi' === $settings['text_type'] && $settings["input_type"] === "div") {
            echo '<div data-text-type="multi-line" id="' . $settings["text_id"] . '">' . esc_textarea($settings['multi_text']) . '</div>';
        } else if ('single' === $settings['text_type'] && $settings["input_type"] === "div") {
            echo '<div data-text-type="single-line" id="' . $settings["text_id"] . '">' . esc_html($settings['single_text']) . '</div>';
        } else {
            echo '<input id="' . $settings["text_id"] . '" placeholder="' . $settings["placeholder"] . '""></input>';
        }

?>

        <style>
            div {
                /* Use Elementor's global color and typography settings */
                color: var(--e-global-color-text);
                font-family: var(--e-global-typography-primary-font-family);
                font-weight: var(--e-global-typography-primary-font-weight);
                font-size: var(--e-global-typography-primary-font-size);
                line-height: var(--e-global-typography-primary-line-height);
                margin-bottom: var(--e-global-spacing);
                transition: color 0.3s ease;
            }
        </style>


<?php
    }
}
