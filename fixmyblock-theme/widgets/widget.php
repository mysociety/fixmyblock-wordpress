<?php

use Carbon_Fields\Widget;
use Carbon_Fields\Exception\Incorrect_Syntax_Exception;

// Carbon Fields insists that field names are unique across *all* widgets,
// using a static variable in Widget::register_field_name(). Before PHP 8.1,
// each subclass got its own copy of that static variable, so in practice
// names only had to be unique within each widget. PHP 8.1 made subclasses
// share it, so our widgets (which each have a "title" field) clash.
//
// Field values are stored per widget instance, so names only really need
// to be unique within a widget. This restores the pre-PHP 8.1 behaviour.
abstract class FixMyBlockWidget extends Widget {
    public function register_field_name( $name ) {
        static $registered_field_names = array();
        $class = static::class;

        if ( ! isset( $registered_field_names[$class] ) ) {
            $registered_field_names[$class] = array();
        }

        if ( in_array( $name, $registered_field_names[$class] ) ) {
            Incorrect_Syntax_Exception::raise( 'Field name "' . $name . '" already registered' );
            return false;
        }

        $registered_field_names[$class][] = $name;
        return true;
    }
}
