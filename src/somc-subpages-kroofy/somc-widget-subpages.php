<?php
/*
  Based heavily around WP's Pages widget

  Copyright 2014 Rikard Ekberg (rikard.ekberg@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class SOMC_Widget_Subpages extends WP_Widget {

  function __construct() {
    $widget_ops = array('classname' => 'somc_widget_subpages subpages-container', 'description' => __( 'A list of subpages that are children of the current page.') );
    parent::__construct('subpages', __('Subpages'), $widget_ops);
  }

  function widget( $args, $instance ) {
    extract( $args );

    $title = apply_filters('widget_title', empty( $instance['title'] ) ? null : $instance['title'], $instance, $this->id_base);

    $subpages = new SOMC_Subpages();

    if( !is_null( $subpages->render_subpages() ) ) {
      echo $before_widget;
      if ( $title )
        echo $before_title . $title . $after_title;
      echo $subpages->render_subpages();
      echo $after_widget;
    }
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }

  function form( $instance ) {
    //Defaults
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = esc_attr( $instance['title'] );
  ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
<?php
  }
}

function somc_widget_subpages_load() {
  register_widget('SOMC_Widget_Subpages');
}

add_action( 'widgets_init', 'somc_widget_subpages_load' );

