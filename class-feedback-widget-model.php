<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class Feedback_Widget_Model {

    public static function create_feedback_table() {
        global $table_prefix;

        $sql = 'CREATE TABLE ' . $table_prefix . 'feedback (';
        $sql .= 'id int NOT NULL AUTO_INCREMENT PRIMARY KEY,';
        $sql .= 'question varchar(255),';
        $sql .= 'feedback varchar(255),';
        $sql .= 'date_created datetime);';

        maybe_create_table($table_prefix . "feedback", $sql);
    }

    public static function drop_feedback_table() {
        global $table_prefix;
        global $wpdb;

        $wpdb->query('DROP TABLE IF EXISTS ' . $table_prefix . 'feedback');
    }

    public function get_feedback() {
        global $table_prefix;
        global $wpdb;

        return $wpdb->get_results("select * from wp_feedback", ARRAY_A);
    }

    public function create_feedback($data) {
        global $table_prefix;
        global $wpdb;

        $data['date_created'] = date('Y-m-d H:i:s');

        return $wpdb->insert($table_prefix.'feedback', $data, array('%s','%s', '%s'));
    }

    public function delete_feedback($data) {
        global $table_prefix;
        global $wpdb;

        return $wpdb->delete($table_prefix.'feedback', $data, array('%d'));
    }
}