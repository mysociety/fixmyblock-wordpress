<?php

class Media_Attribution_Fields {
    private $fields = array(
        "source_url" => array(
            "label" => "Source URL",
            "input" => "text",
        ),
        "creator_name" => array(
            "label" => "Creator name",
            "input" => "text",
        ),
        "license_name" => array(
            "label" => "License name",
            "input" => "text",
        ),
        "license_url" => array(
            "label" => "License URL",
            "input" => "text",
        ),
    );

    function __construct() {
        add_filter( 'attachment_fields_to_edit', array( $this, 'add_fields' ), 11, 2 );
        add_filter( 'attachment_fields_to_save', array( $this, 'save_fields' ), 11, 2 );
    }

    function add_fields( $form_fields, $post = null ) {
        foreach ( $this->fields as $slug => $field ) {
            $field['value'] = get_post_meta( $post->ID, '_' . $slug, true );
            $form_fields[ $slug ] = $field;
        }
        return $form_fields;
    }

    function save_fields( $post, $attachment ) {
        foreach ( $this->fields as $slug => $field ) {
            if ( isset( $attachment[$slug] ) ) {
                update_post_meta( $post['ID'], '_' . $slug, $attachment[$slug] );
            } else {
                delete_post_meta( $post['ID'], $slug );
            }
        }
        return $post;
    }
}

new Media_Attribution_Fields();


function get_the_media_credits( $post = 0 ) {
    $post = get_post( $post );
    $attachment_ids = array();
    $credits = array();
    $html = '';

    // Get post thumbnail image.
    if ( has_post_thumbnail($post->ID) ) {
        $attachment_ids[] = get_post_thumbnail_id( $post->ID );
    }

    // Next look in post content and check for instances of wp-image-[digits].
    // Frankly embarassing that WordPress forces us to use a regex here.
    if (preg_match_all('/wp-image-(\d+)/i', $post->post_content, $matches)) {
        foreach ( $matches[1] as $id ) {
            if ( ! in_array($id, $attachment_ids) ) {
                $attachment_ids[] = $id;
            }
        }
    }

    // Collect credit info for each attachment.
    foreach ( $attachment_ids as $id ) {
        $source_url = get_post_meta( $id, '_source_url', true);
        $creator_name = get_post_meta( $id, '_creator_name', true);
        $license_url = get_post_meta( $id, '_license_url', true);
        $license_name = get_post_meta( $id, '_license_name', true);

        if ( $source_url && $creator_name && $license_url && $license_name ) {
            $credits[] = array(
                "title" => get_the_title( $id ),
                "source_url" => $source_url,
                "creator_name" => $creator_name,
                "license_url" => $license_url,
                "license_name" => $license_name,
            );
        }
    }

    if ( $credits ) {
        $html = '<div class="image-credits">' . "\n";

        $html .= sprintf(
            '<h2>%s</h2>' . "\n",
            count( $credits ) > 1 ? 'Image credits' : 'Image credit'
        );

        $html .= '<ul>' . "\n";

        foreach ( $credits as $credit ) {
            $html .= sprintf(
                '<li>%s by <a href="%s" target="_blank">%s</a>, <a href="%s" target="_blank">%s</a>.</li>' . "\n",
                esc_html( ucfirst( $credit['title'] ) ),
                esc_attr( $credit['source_url'] ),
                esc_html( $credit['creator_name'] ),
                esc_attr( $credit['license_url'] ),
                esc_html( $credit['license_name'] )
            );
        }

        $html .= '</ul>' . "\n";
        $html .= '</div>' . "\n";
    }

    return $html;
}


function the_media_credits() {
    echo get_the_media_credits();
}
