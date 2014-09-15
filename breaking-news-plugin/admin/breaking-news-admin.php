<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       https://github.com/ramiroaraujo/wordpress-breaking-news-plugin
 * @since      1.0.0
 *
 * @package    Breaking_News
 * @subpackage Breaking_News/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Breaking_News
 * @subpackage Breaking_News/admin
 * @author     Your Name <email@example.com>
 */
class Breaking_News_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $name The ID of this plugin.
     */
    private $name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string $name The name of this plugin.
     * @var      string $version The version of this plugin.
     */
    public function __construct($name, $version)
    {
        $this->name = $name;
        $this->version = $version;

    }

    /**
     * Creates the meta_box for the admin area
     */
    public function add_breaking_news_meta_box()
    {
        add_meta_box(
            'breaking_news',
            __('Breaking News', 'breaking-news'),
            array($this, 'breaking_news_display'),
            'post',
            'normal',
            'high'
        );
    }

    /**
     * Creates the checkbox in the meta_box, for storing the metadata
     * @param $post
     */
    function breaking_news_display($post)
    {
        wp_nonce_field(plugin_basename(__FILE__), 'breaking_news_nonce');

        $breaking_news = get_post_meta($post->ID, 'breaking_news', true);

        //lacking a better templating method, plain-old HTML stitching here
        $checkbox = '<input type="checkbox" id="breaking_news" name="breaking_news" value="1"';
        if ($breaking_news) {
            $checkbox .= 'checked="checked" ';
        }
        $checkbox .= '></input><label for="breaking_news">' .
            __('Woa! this is Breaking News', 'breaking-news') .
            '</label>';
        echo $checkbox;
    }

    /**
     * Validates and saves the metadata
     * @param $post_id
     */
    function save_breaking_news($post_id)
    {
        if (isset($_POST['breaking_news_nonce']) && isset($_POST['post_type'])) {

            //verify that the input is coming from the proper form
            if (!wp_verify_nonce($_POST['breaking_news_nonce'], plugin_basename(__FILE__))) {
                return;
            }

            //make sure the user has permissions to post
            if ($_POST['post_type'] == 'post') {
                if (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            //read the post message
            $breaking_news = isset($_POST['breaking_news']) ? $_POST['breaking_news'] : '';

            // Update it for this post.
            update_post_meta($post_id, 'breaking_news', $breaking_news);
        }
    }
}
