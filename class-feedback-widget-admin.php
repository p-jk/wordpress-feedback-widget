<?php

// if ( ! class_exists( 'WP_List_Table' ) ) {
	// require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
// }

class Feedback_Widget_Admin extends WP_List_Table{

    private $model;

    public function __construct(Feedback_Widget_Model $model) {
        parent::__construct([
            // 'singular' => 'Feedback',
            // 'plural'   => 'Feedback',
            'ajax'     => false
        ]);
        $this->model = $model;
    }

    public function init() {
        add_menu_page( 
            __('Feedback Page'),
            'Feedback',
            'manage_options',
            'feedback-widget',
            array($this, 'admin_menu_page'),
            'dashicons-smiley' 
        ); 
    }

    public function admin_menu_page() {
        $this->prepare_items();
        ?>
            <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Feedback</h2>
            <?= $this->display(); ?>
            </div>
        <?php
    }

    public function get_columns(){
        $columns = array(		
        'question' => 'Question',
        'feedback'    => 'Feedback',
        'date_created'      => 'Date Submited',	
        );
        return $columns;
    }	

    public function get_sortable_columns() {
        // return array('date_created' => array('date_created', false));
    }

    public function column_default($item, $column_name) {
        switch( $column_name ) { 
                case 'question':
                case 'feedback':
                case 'date_created':
            return $item[$column_name];
                default:
            return print_r($item, true);
        }
    }   

    public function get_hidden_columns() {
        return array();
    }
    
    public function get_views(){
        
    }

    public function prepare_items(){

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->model->get_feedback();

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($data);

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page
        ));

        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;

    }

}