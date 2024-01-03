<?php

namespace ElementorFetchWidgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FetchButton extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'elementor_fetch_button';
    }

    public function get_title()
    {
        return 'Elementor Fetch Button';
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories()
    {
        return ['elementor-fetch-widgets'];
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
            'text',
            [
                'label' => 'Text',
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Fetch Button',
            ]
        );
        $this->add_control(
            'api_url',
            [
                'label' => 'API URL',
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'default' => 'https://your-api-url.com',

            ]
        );

        $this->add_control(
            'request_method',
            [
                'label' => 'Request Method',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'GET',
                'options' => [
                    'GET'    => 'GET',
                    'POST'   => 'POST'
                ],
            ]
        );


        $this->add_control(
            'has_query',
            [
                'label' => 'Has Query Parameters?',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'Yes',
                'label_off' => 'No',
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'request_method' => "GET",
                ],
            ]
        );

        $this->add_control(
            'query_parameter_name',
            [
                'label' => 'Query Parameter Name',
                'type' => \Elementor\Controls_Manager::TEXT,
                "placeholder" => 'first_text_value',
                'condition' => [
                    'has_query' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'query_parameter_value',
            [
                'label' => 'Query Parameter Value with Input ID (without #)',
                'type' => \Elementor\Controls_Manager::TEXT,
                "placeholder" => 'first-text',
                'condition' => [
                    'has_query' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'post_data',
            [
                'label' => 'Post Form ID (without #)',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'first-form',
                'condition' => [
                    'request_method' => 'POST', // Conditional Rendering only when request method is post
                ],
            ]
        );

        $this->add_control(
            'authorization_type',
            [
                'label' => 'Authorization Type',
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'NONE',
                'options' => [
                    'NONE'    => 'NONE',
                    'BASIC'   => 'BASIC',
                    'BEARER'   => 'BEARER',
                    'API KEY'   => 'API KEY',

                ],
            ]
        );

        $this->add_control(
            'authorization_value',
            [
                'label' => 'Authorization Value',
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'Enter Authorization Value',
                'condition' => [
                    'authorization_type!' => "NONE",
                ],
            ]
        );

        $this->add_control(
            'targeted_response_body',
            [
                'label' => 'Targeted Response Body',
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => 'products',
            ]
        );

        $this->add_control(
            'targeted_response_field',
            [
                'label' => 'Targeted Response Field in Object',
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => 'title',
            ]
        );

        $this->add_control(
            'response_text',
            [
                'label' => 'Response Text Field ID (without #)',
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => 'first-text',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $api_url = esc_url($settings['api_url']);
        $request_method = $settings['request_method'];
        $authorization_type = $settings['authorization_type'];
        $authorization_value = $settings['authorization_value'];
        $request_method = $settings['request_method'];
        $button_text = esc_html($settings['text']);
        $post_data = $settings['post_data'];
        $has_query = $settings['has_query'];
        $query_parameter_name = $settings['query_parameter_name'];
        $query_parameter_value = $settings['query_parameter_value'];
        $response_text = $settings['response_text'];
        $targeted_response_body = $settings['targeted_response_body'];
        $targeted_response_field = $settings['targeted_response_field'];

        // Output the button HTML
        echo '<button onclick="fetchElementorFetchWidgetsData()"> ' . $button_text . ' </button>';

        // Output the script
?>
        <style>
            button {
                background-color: var(--e-global-color-accent);
                font-family: var(--e-global-typography-primary-font-family);
                font-weight: var(--e-global-typography-primary-font-weight);
                color: var(--e-global-color-text);
                padding: 10px;
                border: none;
                border-radius: 7px;
                transition: all 0.17s ease-in;
                cursor: pointer;
            }

            button:hover {
                transform: scale(1.07);
                background-color: var(--e-global-color-primary);
            }
        </style>


        <script>
            function fetchElementorFetchWidgetsData() {
                var requestOptions = {
                    method: '<?php echo $request_method; ?>',
                    headers: new Headers({
                        'Authorization': '<?php echo $authorization_type !== "API KEY" ?: $authorization_value ?>',
                        'Content-Type': 'application/json'
                    }),
                };

                <?php if ($request_method === "POST") : ?>
                    var formElement = document.getElementById('<?php echo $post_data; ?>');
                    var formData = new FormData(formElement);
                    console.log(formData)
                    requestOptions.body = formData;
                <?php endif; ?>

                var url = "<?php echo $api_url; ?>";

                <?php if ($authorization_type === "API KEY") : ?>
                    url += '?apiKey=' + encodeURIComponent("<?php echo $authorization_value; ?>");
                <?php endif; ?>

                <?php if ($has_query === "yes") : ?>
                    var queryValue = document.getElementById('<?php echo $query_parameter_value ?>').value;
                    console.log('<?php echo $query_parameter_value ?>', queryValue)
                    url += (url.includes('?') ? '&' : '?') + '<?php echo $query_parameter_name ?>' + '=' + encodeURIComponent(queryValue);
                <?php endif; ?>
                console.log("url", url)


                fetch(url, requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(result => {
                        let targeted_text = document.getElementById('<?php echo $response_text ?>')
                        if (targeted_text.getAttribute("data-text-type") === "single-line") {
                            if (result['<?php echo $targeted_response_body ?>'].length > 1) {
                                return targeted_text.innerText = result['<?php echo $targeted_response_body ?>'][0]['<?php echo $targeted_response_field ?>']
                            }
                            return targeted_text.innerText = result['<?php echo $targeted_response_body ?>']['<?php echo $targeted_response_field ?>']

                        }
                        if (targeted_text.getAttribute("data-text-type") === "multi-line") {
                            targeted_text.innerHTML = ''
                            result['<?php echo $targeted_response_body ?>'].forEach((item) => {
                                let element = document.createElement('li')
                                element.innerText = item['<?php echo $targeted_response_field ?>']
                                targeted_text.appendChild(element)
                            })
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
<?php
    }
}
