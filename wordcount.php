<?php

/**
 * Plugin Name: Word Count
 * Plugin URI: https://example.com/word-count
 * Description: This is a custom plugin to enhance WordPress functionality.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: word-count
 * Domain Path: /languages
 */


// Exit if accessed directly

if (!defined('ABSPATH')) {
    exit;
}


// function word_count_init() {


// }
// add_action('plugins_loaded', 'word_count_init');

function word_count_load_textdomain() {
    load_plugin_textdomain('word-count', false, dirname(__FILE__) . '/languages');
}

add_action('plugins_loaded', 'worccount_count_words');

function worccount_count_words($content) {
    $striped_content = strip_tags($content);
    $wordCount = str_word_count($striped_content);
    $label = __('Total number of word counts', 'word-count');
    $label = apply_filters('wordcount_change_heading', $label);
    $tag = apply_filters('wordcount_tag', 'h1');
    $content .= sprintf('<%s>%s:%s</%s>', $tag, $label, $wordCount, $tag);
    return $content;
}
add_filter('the_content', 'worccount_count_words');


function wordcount_reading_time($content) {
    $striped_content = strip_tags($content);
    $word_numbers = str_word_count($striped_content);
    $reading_minutes = floor($word_numbers / 200);
    $reading_seconds = floor($word_numbers % 200 / (200 / 60));
    $is_visible = apply_filters('wordcount_display_readingtime', 1);
    if ($is_visible) {

        $label = __('Total reading time is', 'word-count');
        $label = apply_filters('wordcount_change_heading', $label);
        $tag = apply_filters('wordcount_tag', 'h1');
        $content .= sprintf('<%s>%s:%s Minuts %s Seconds</%s>', $tag, $label, $reading_minutes, $reading_seconds, $tag);
    }

    return $content;
}


add_filter('the_content', 'wordcount_reading_time');
