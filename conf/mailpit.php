<?php
/*
Plugin Name: Mailpit
Description: Sends all email to the Mailpit container, for local development.
*/

add_action( 'phpmailer_init', function( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mailpit';
    $phpmailer->Port = 1025;
    $phpmailer->SMTPAuth = false;
    $phpmailer->SMTPAutoTLS = false;
} );

// PHPMailer rejects WordPress's default wordpress@localhost address.
add_filter( 'wp_mail_from', function( $from_email ) {
    return $from_email == 'wordpress@localhost' ? 'wordpress@localhost.test' : $from_email;
} );
