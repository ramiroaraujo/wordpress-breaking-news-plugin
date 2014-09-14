<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
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

    public function add_notice_metabox()
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

    function breaking_news_display($post)
    {
        wp_nonce_field(plugin_basename(__FILE__), 'breaking_news_nonce');

        $breaking_news = get_post_meta($post->ID, 'breaking_news', true);

        $checkbox = '<input type="checkbox" id="breaking_news" name="breaking_news" value="1"';
        if ($breaking_news) $checkbox .= 'checked="checked" ';
        $checkbox.= '></input><label for="breaking_news">Woa! this is Breaking News</label>';
        echo $checkbox;
    }

    function save_breaking_news($post_id)
    {
        if (isset($_POST['breaking_news_nonce']) && isset($_POST['post_type'])) {

            // Don't save if the user hasn't submitted the changes
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            // Verify that the input is coming from the proper form
            if (!wp_verify_nonce($_POST['breaking_news_nonce'], plugin_basename(__FILE__))) {
                return;
            }

            // Make sure the user has permissions to post
            if ($_POST['post_type'] == 'post') {
                if (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }

            // Read the post message
            $breaking_news = isset($_POST['breaking_news']) ? $_POST['breaking_news'] : '';

            // If the value for the post message exists, delete it first. Don't want to write extra rows into the table.
            if (count(get_post_meta($post_id, 'breaking_news')) == 0) {
                delete_post_meta($post_id, 'breaking_news');
            }

            // Update it for this post.
            update_post_meta($post_id, 'breaking_news', $breaking_news);
        }
    }
}
