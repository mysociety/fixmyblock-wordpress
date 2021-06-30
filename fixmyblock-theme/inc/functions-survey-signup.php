<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function get_survey_signup_output( $options = array() ) {
    $options = wp_parse_args(
        $options,
        get_survey_signup_output_defaults()
    );

    ob_start();
    ?>
<div class="p-3 p-md-4 my-5 rounded <?php echo esc_attr($options['extra_classes']); ?>">
    <h3><small class="d-block">Survey:</small> <?php echo esc_html($options['title']); ?></h3>
    <?php echo wp_kses( $options['content'], 'post'); ?>
    <div id="mc_embed_signup">
        <form action="<?php echo esc_url(get_survey_signup_action_url()); ?>" class="validate" id="mc-embedded-subscribe-form" method="post" name="mc-embedded-subscribe-form" novalidate="" target="_blank">
            <label for="mce-EMAIL">Your email address</label>
            <div id="mc_embed_signup_scroll" class="d-flex flex-wrap mt-n2 mr-n3">
                <input class="mt-2 mr-3 form-control" id="mce-EMAIL" name="EMAIL" required="" type="email" value="" style="width: auto; flex-basis: 20em;">
                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div aria-hidden="true" style="position: absolute; left: -5000px;">
                    <input name="b_53d0d2026dea615ed488a8834_9334858efa" tabindex="-1" type="text" value="">
                </div>
                <div class="mt-2 mr-3">
                    <input id="mc-embedded-subscribe" name="subscribe" type="submit" class="btn btn-primary" value="<?php echo esc_html($options['button']); ?>">
                </div>
            </div>
        </form>
    </div>
</div>
    <?php

    $output = ob_get_clean();
    return $output;
}

function get_survey_signup_output_defaults() {
    return array(
        'title' => 'Can we ask you later how you’re doing?',
        'content' => '<p>Let us know your email address, and we’ll follow up in a few weeks’ time, to see whether there’s been any progress on your issue, and to get your thoughts on how we can make FixMyBlock more helpful.</p>',
        'button' => 'Sign up for survey',
        'extra_classes' => 'has-yellow-100-background-color has-black-color'
    );
}

function get_survey_signup_action_url() {
    $url = 'https://mysociety.us9.list-manage.com/subscribe/post?u=53d0d2026dea615ed488a8834&id=9334858efa';
    $url = add_query_arg(
        'SOURCE_URL',
        urlencode( get_permalink( get_queried_object_id() ) ),
        $url
    );
    // NOTE: URL is not encoded. Should call esc_url() on it before printing.
    return $url;
}

function get_survey_signup_widget_fields( $context = 'widget' ) {
    $fields = array();
    $defaults = get_survey_signup_output_defaults();

    if ( $context == 'block' ) {
        $fields[] = Field::make(
            'html',
            'placeholder_text',
            __( 'Placeholder text' )
        )->set_html(
            '<p style="font-weight: bold; margin: 0;">Survey signup</p>'
        );
    }

    $fields[] = Field::make(
        'text',
        'title',
        __( 'Title (optional)' )
    )->set_default_value(
        __( $defaults['title'] )
    );

    $fields[] = Field::make(
        'rich_text',
        'content',
        __( 'Text content (optional)' )
    )->set_default_value(
        __( $defaults['content'] )
    );

    $fields[] = Field::make(
        'text',
        'button',
        __( 'Button text (optional)' )
    )->set_default_value(
        __( $defaults['button'] )
    );

    return $fields;
}
