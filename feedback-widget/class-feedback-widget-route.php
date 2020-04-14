<?php

class Feedback_Widget_Route extends WP_REST_Controller {

    protected $model;

    public function __construct(Feedback_Widget_Model $model){
        $this->model = $model;
    }

    public function register_routes() {
        
        register_rest_route( 'feedback-widget/v1', '/feedback', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_items')
            ),
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'create_item'),
                'args' => array(
                    'question' => array(
                        'required' => true,
						'type' => 'string',
						'description' => __('Question Field')
					),
					'feedback' => array(
                        'required' => true,
						'type' => 'string',
						'description' => __('Feeback Field')
					),
                    )
                ),
            ));
            
        register_rest_route( 'feedback-widget/v1', '/feedback/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'delete_item'),
                'args' => array(
                    'id' => array(
                        'required' => true,
                        'type' => 'int',
                        'description' => __('Question Field')
                    )
                )
            )
        ));
    }

    public function get_items($request) {
        if (method_exists('Feedback_Widget_Model','get_feedback')) {
            $result = $this->model->get_feedback();
            return new WP_REST_Response( $result, 200 );
        }
        return new WP_Error('cant-get', __('An error has occured'), array( 'status' => 500 ));
    }

    public function create_item($request) {
        if (method_exists('Feedback_Widget_Model','create_feedback')) {
            $request_body = $request->get_params();
            $result = $this->model->create_feedback($request_body);
            return new WP_REST_Response( $result, 200 );
        }
        return new WP_Error('cant-create', __('An error has occured'), array( 'status' => 500 ));
    }

    public function delete_item($request) {
        $query_param = $request->get_params();
        if (method_exists('Feedback_Widget_Model','delete_feedback')) {
                $result = $this->model->delete_feedback($query_param);
                return new WP_REST_Response( $result, 200 );
        }
        return new WP_Error('cant-delete', __('An error has occured'), array( 'status' => 500 ));
    }
}