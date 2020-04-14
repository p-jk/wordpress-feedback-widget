<?php

class Feedback_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'feedback_widget',
            __('Feeback Widget'),
            array ('description' => __('A widget for client to provide feedback'))
        );
        add_action('wp_enqueue_scripts', array($this, 'load_script'));
    }

    public static function init() {
        register_widget('Feedback_Widget');
    }

    public function widget($args, $instance) {
        ?>
            <div class="">
                <form id="feedback-widget-form" class="">       
                    <h4>
                        <span class="question-class">
                            <?= $instance['question'] ?? "How is our service?" ?>
                        <span>
                    </h4>
                    <input type="text" class="feedback-class" style="margin-bottom:10px;" />
                    <button class="button-class" type="submit">Submit Feedback</button>   
                </form>
            </div>
        <?php
    }

    public function form($instance) {
        $question = $instance['question'] ?? "";
        ?>
            <label for="<?= $this->get_field_id('question'); ?>">
                <?= __("What question would you like to ask the clients?"); ?>
            </label>
            <input 
            class="widefat" 
            id="<?= $this->get_field_id('question'); ?>" 
            name="<?= $this->get_field_name('question'); ?>" 
            type="text" placeholder="Type your question" 
            value="<?= esc_attr($question); ?>"
            >
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance['question'] = isset($new_instance['question']) ? strip_tags($new_instance['question']) : '';
        return $instance;
    }

    public function load_script() {
        $my_js_ver  = date("ymd-Gis", filemtime(plugin_dir_path( __FILE__ ) . 'js/feedback_widget.js'));
        wp_enqueue_script('feedback_widget', plugins_url('js/feedback_widget.js', __FILE__), array(), $my_js_ver, true);
    }
}