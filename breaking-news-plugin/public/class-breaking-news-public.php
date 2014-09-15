<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/ramiroaraujo/wordpress-breaking-news-plugin
 * @since      1.0.0
 *
 * @package    Breaking_News
 * @subpackage Breaking_News/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Breaking_News
 * @subpackage Breaking_News/admin
 * @author     Your Name <email@example.com>
 */
class Breaking_News_Public
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
     * @var      string $name The name of the plugin.
     * @var      string $version The version of this plugin.
     */
    public function __construct($name, $version)
    {
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * Prepends the "Breaking" text to the title if the post is marked as breaking_news
     *
     * @param $title
     * @return string
     */
    public function prepend_breaking_news($title)
    {
        if (get_post_meta(get_the_ID(), 'breaking_news', true)) {
            $title = __('Breaking', 'breaking-news') . ': ' . $title;
        }

        return $title;
    }
}
