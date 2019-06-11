<?php
/*
Plugin Name: TableData
Plugin URI: https://learnwith.hasinhayder.com
Description: Example of using Tables in WordPress Admin Pages
Version: 1.0
Author: LWHH
Author URI: https://hasin.me
License: GPLv2 or later
Text Domain: tabledata
Domain Path: /languages/
*/
require_once "class.persons-table.php";

function tabledata_load_textdomain() {
	load_plugin_textdomain( 'tabledata_example', false, dirname( __FILE__ ) . "/languages" );
}

add_action( "plugins_loaded", "tabledata_load_textdomain" );

function datatable_admin_page() {
	add_menu_page(
		__( 'Data Table', 'tabledata' ),
		__( 'Data Table', 'tabledata' ),
		'manage_options',
		'datatable',
		'datatable_display_table'
	);
}

function datatable_search_by_name( $item ) {
	$name        = strtolower( $item['name'] );
	$search_name = sanitize_text_field( $_REQUEST['s'] );
	if ( strpos( $name, $search_name ) !== false ) {
		return true;
	}

	return false;
}

function datatable_filter_sex($item){
    $sex = $_REQUEST['filter_s']??'all';
    if('all'==$sex){
        return true;
    }else{
        if( $sex==$item['sex']){
            return true;
        }
    }
    return false;
}

function datatable_display_table() {
	include_once "dataset.php";
	$orderby = $_REQUEST['orderby'] ?? '';
	$order   = $_REQUEST['order'] ?? '';
	if ( isset( $_REQUEST['s'] ) && !empty($_REQUEST['s']) ) {
		$data = array_filter( $data, 'datatable_search_by_name' );
	}

	if ( isset( $_REQUEST['filter_s'] ) && !empty($_REQUEST['filter_s']) ) {
		$data = array_filter( $data, 'datatable_filter_sex' );
	}

	$table = new Persons_Table();
	if ( 'age' == $orderby ) {
		if ( 'asc' == $order ) {
			usort( $data, function ( $item1, $item2 ) {
				return $item2['age'] <=> $item1['age'];
			} );
		} else {
			usort( $data, function ( $item1, $item2 ) {
				return $item1['age'] <=> $item2['age'];
			} );
		}
	} else if ( 'name' == $orderby ) {
		if ( 'asc' == $order ) {
			usort( $data, function ( $item1, $item2 ) {
				return $item2['name'] <=> $item1['name'];
			} );
		} else {
			usort( $data, function ( $item1, $item2 ) {
				return $item1['name'] <=> $item2['name'];
			} );
		}
	}
	$table->set_data( $data );

	$table->prepare_items();
	?>
    <div class="wrap">
        <h2><?php _e( "Persons", "tabledata" ); ?></h2>
        <form method="GET">
			<?php
			$table->search_box( 'search', 'search_id' );
			$table->display();
			?>
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>">
        </form>
    </div>
	<?php

}

add_action( "admin_menu", "datatable_admin_page" );