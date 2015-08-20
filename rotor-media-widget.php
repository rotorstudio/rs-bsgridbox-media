<?php
/*
* Plugin Name: rs-bsgridbox-media
* Plugin URI: https://github.com/rotorstudio/rs-bsgridbox-media
* Description: Wordpress Widget to display Images in Bootstrap Grid System
* Version: 0.1-dev
* Author: Robert Torkuhl
* Author URI: http://rotorstudio.de
* License: GPL2

Copyright 2015  Robert Torkuhl

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License,
version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("rs_bsgridbox_media_widget");' ) );

class rs_bsgridbox_media_widget extends WP_Widget
{
    /**
     * Constructor
     **/
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'rs_gridbox_media_widget',
            'description' => 'Widget to display Images in Bootstrap Grid System'
        );

        parent::__construct( 'rotor_media_widget', 'rotor Media Widget', $widget_ops );

        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('upload_media_widget', plugin_dir_url(__FILE__) . 'upload-media.js', array('jquery'));

        wp_enqueue_style('thickbox');
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    public function widget( $args, $instance )
    {
        // Add any html to output the image in the $instance array
        echo $before_widget;
        echo '<a class="col-md-3 col-xs-6 text-center '.$instance['extraclass'].'" href="'.$instance['link'].'">';
        echo '<div class="inner">';
        echo '<h3 class="text-center">'.$instance['title'].'</h3>';
        echo '<img src="'.$instance['image'].'" class="img-responsive center-block" alt="">';
        echo '<p class="text-left">'.$instance['excerpt'].'</p>';
        echo '</div>';
        echo '</a>';
        echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    public function update( $new_instance, $old_instance ) {
        // update logic goes here
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['extraclass'] = strip_tags($new_instance['extraclass']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['excerpt'] = strip_tags($new_instance['excerpt']);
        $instance['link'] = strip_tags($new_instance['link']);
        return $instance;

    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void
     **/
    public function form( $instance )
    {
        $title = __('Widget Image');
        if(isset($instance['title']))
        {
            $title = $instance['title'];
        }

        $extraclass = '';
        if(isset($instance['extraclass']))
        {
            $extraclass = $instance['extraclass'];
        }

        $image = '';
        if(isset($instance['image']))
        {
            $image = $instance['image'];
        }

        $excerpt = '';
        if(isset($instance['excerpt']))
        {
            $excerpt = $instance['excerpt'];
        }

        $link = '';
        if(isset($instance['link']))
        {
            $link = $instance['link'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'extraclass' ); ?>"><?php _e( 'Extra Class Attribute' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'extraclass' ); ?>" name="<?php echo $this->get_field_name( 'extraclass' ); ?>" type="text" value="<?php echo esc_attr( $extraclass ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_name( 'excerpt' ); ?>"><?php _e( 'Excerpt:' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>"><?php echo esc_attr( $excerpt ); ?></textarea>
        </p>
    <?php
    }
}
?>
