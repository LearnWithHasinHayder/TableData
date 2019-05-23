<?php
if ( ! class_exists( "WP_List_Table" ) ) {
    require_once( ABSPATH . "wp-admin/includes/class-wp-list-table.php" );
}

class Persons_Table extends WP_List_Table {


    function set_data( $data ) {
        $this->items = $data;
    }

    function get_columns() {
        return [
            'cb'    => '<input type="checkbox">',
            'name'  => __( 'Name', 'tabledata' ),
            'email' => __( 'E-mail', 'tabledata' ),
            'age'   => __( 'Age', 'tabledata' ),
        ];
    }

    function get_sortable_columns() {
        return [
            'age' => [ 'age', true ],
            'name' => [ 'name', true ],
        ];
    }


    function column_cb( $item ) {
        return "<input type='checkbox' value='{$item['id']}'/>";
    }

    function column_email( $item ) {
        return "<strong>{$item['email']}</strong>";
    }

    function column_age( $item ) {
        return "<em>{$item['age']}</em>";
    }

    function prepare_items() {
        $this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
    }

    function column_default( $item, $column_name ) {
        return $item[ $column_name ];
    }


}