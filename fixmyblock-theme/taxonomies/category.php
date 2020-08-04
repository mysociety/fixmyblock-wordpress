<?php

// Add "singular_name" field to the built-in "category" taxonomy.
// This is useful when you want to "label" a post with its category,
// and you want that category to feel like it’s describing the post.


// GETTER (will be sanitized)
function get_category_singular_name( $term_id ) {
    $value = get_term_meta( $term_id, 'category_singular_name', true );
    $value = sanitize_category_singular_name( $value );
    return $value;
  }


// SANITIZE DATA
function sanitize_category_singular_name( $value ) {
    return sanitize_text_field( $value );
}


// REGISTER TERM META
function register_category_singular_name() {
    register_meta( 'term', 'category_singular_name', 'sanitize_category_singular_name' );
}
add_action( 'init', 'register_category_singular_name' );


// ADD FIELD TO CATEGORY TERM PAGE
function add_form_field_category_singular_name() { ?>
    <div class="form-field">
        <label for="<?php echo esc_attr( 'category_singular_name' ); ?>"><?php _e( 'Singular name' ); ?></label>
        <input type="text" name="<?php echo esc_attr( 'category_singular_name' ); ?>" id="<?php echo esc_attr( 'category_singular_name' ); ?>">
        <p class="description"><?php _e('The name of this category, in singular form, e.g. a category named “Recipes” would have a singular name of “Recipe”.'); ?></p>
    </div>
<?php }
add_action( 'category_add_form_fields', 'add_form_field_category_singular_name' );


// ADD FIELD TO CATEGORY EDIT PAGE
function edit_form_field_category_singular_name( $term ) {
    $value = get_category_singular_name( $term->term_id );
    if ( ! $value ) {
        $value = "";
    }
    ?>
    <tr class="form-field">
        <th scope="row"><label for="<?php echo esc_attr( 'category_singular_name' ); ?>"><?php _e( 'Singular name' ); ?></label></th>
        <td>
            <input type="text" name="<?php echo esc_attr( 'category_singular_name' ); ?>" id="<?php echo esc_attr( 'category_singular_name' ); ?>" value="<?php echo esc_attr( $value ); ?>">
            <p class="description"><?php _e('The name of this category, in singular form, e.g. a category named “Recipes” would have a singular name of “Recipe”.'); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'category_edit_form_fields', 'edit_form_field_category_singular_name' );


// SAVE TERM META (on term edit & create)
function save_category_singular_name( $term_id ) {
    $old_value  = get_category_singular_name( $term_id );
    if ( isset( $_POST[ 'category_singular_name' ] ) ) {
        $new_value = sanitize_category_singular_name( $_POST[ 'category_singular_name' ] );
     } else {
        $new_value = '';
     }

    if ( $old_value && '' === $new_value ) {
        delete_term_meta( $term_id, 'category_singular_name' );
    } else if ( $old_value !== $new_value ) {
        update_term_meta( $term_id, 'category_singular_name', $new_value );
    }
}
add_action( 'edit_category',   'save_category_singular_name' );
add_action( 'create_category', 'save_category_singular_name' );


// MODIFY COLUMNS (add our meta to the list)
function edit_category_admin_columns( $columns ) {
    $columns[ 'category_singular_name' ] = __( 'Singular name' );
    return $columns;
}
add_filter( 'manage_edit-category_columns', 'edit_category_admin_columns' );


// RENDER COLUMNS (render the meta data on a column)
function render_category_singular_name_admin_column( $out, $column, $term_id ) {
    if ( 'category_singular_name' === $column ) {
        $value  = get_category_singular_name( $term_id );
        if ( ! $value ) {
            $value = '';
        }
        $out = sprintf(
            '<span class="%s-block">%s</div>',
            esc_attr( 'category_singular_name' ),
            esc_attr( $value )
        );
    }
    return $out;
}
add_filter( 'manage_category_custom_column', 'render_category_singular_name_admin_column', 10, 3 );
