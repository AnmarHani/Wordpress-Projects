<?php

namespace ElementorFetchWidgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FetchForm extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'fetch_form';
    }

    public function get_title()
    {
        return 'Fetch Form';
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'form_section',
            [
                'label' => 'Form Fields',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Control for Form ID
        $this->add_control(
            'form_id',
            [
                'label' => 'Form ID (without #)',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'custom-form',
                'description' => 'Set a custom ID for the form.',
            ]
        );

        // Repeater for input fields
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'field_name',
            [
                'label' => 'Field Name (Key)',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'field_name',
            ]
        );

        $repeater->add_control(
            'field_type',
            [
                'label' => 'Field Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => 'Text',
                    'email' => 'Email',
                    'textarea' => 'Textarea',
                    'checkbox' => 'Checkbox',
                    'radio' => 'Radio',
                ],
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label' => 'Field Label',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Label',
            ]
        );

        $repeater->add_control(
            'field_placeholder',
            [
                'label' => 'Placeholder',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Enter text...',
                'condition' => [
                    'field_type' => 'text',
                ],
            ]
        );


        $this->add_control(
            'form_fields',
            [
                'label' => 'Form Fields',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ field_label }}}',
                'button' => 'Add Field',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $form_id = $settings['form_id'];
        $fields = $settings['form_fields'];

        echo '<form id="' . esc_attr($form_id) . '">';

        foreach ($fields as $field) {
            echo '<label for="' . esc_attr($field['_id']) . '">' . esc_html($field['field_label']) . '</label>';
            switch ($field['field_type']) {
                case 'text':
                case 'email':
                    echo '<input type="' . $field['field_type'] . '" id="' . esc_attr($field['_id']) . '" name="' . esc_attr($field['name']) . '" placeholder="' . esc_attr($field['field_placeholder']) . '">';
                    break;
                case 'textarea':
                    echo '<textarea id="' . esc_attr($field['_id']) . '" name="' . esc_attr($field['_id']) . '" placeholder="' . esc_attr($field['field_placeholder']) . '"></textarea>';
                    break;
                case 'checkbox':
                    // Output checkbox input
                    echo '<input type="' . $field['field_type'] . '" id="' . esc_attr($field['_id']) . '" name="' . esc_attr($field['name']) . '" placeholder="' . esc_attr($field['field_placeholder']) . '">';
                    break;
                case 'radio':
                    echo '<input type="' . $field['field_type'] . '" id="' . esc_attr($field['_id']) . '" name="' . esc_attr($field['name']) . '" placeholder="' . esc_attr($field['field_placeholder']) . '">';
                    break;
            }
        }

        echo '</form>';
?>
        <style>
            form {
                /* Use Elementor's global color and typography settings */
                color: var(--e-global-color-text);
                font-family: var(--e-global-typography-primary-font-family);
                font-weight: var(--e-global-typography-primary-font-weight);
                display: flex;
                gap: 3;
                justify-content: center;
                flex-direction: column;
            }

            form input,
            form textarea,
            form select,
            form button {
                /* Apply consistent styling to all form elements */
                background-color: var(--e-global-color-accent);
                color: var(--e-global-color-text);
                padding: 10px;
                border: none;
                border-radius: 7px;
                transition: all 0.17s ease-in;
                cursor: pointer;
                margin: 4px;
            }

            form button:hover {
                /* Hover effect for buttons */
                transform: scale(1.07);
            }

            /* Additional custom styles for other form elements can go here */
        </style>

<?php
    }
}
