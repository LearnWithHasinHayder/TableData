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

function datatable_display_table() {
	include_once "dataset.php";
	$table = new Persons_Table();
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
        </form>
    </div>
	<?php

}

add_action( "admin_menu", "datatable_admin_page" );