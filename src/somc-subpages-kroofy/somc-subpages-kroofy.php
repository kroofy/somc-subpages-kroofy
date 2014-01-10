<?php
/*
Plugin Name: SOMC Subpages kroofy
Plugin URI: http://kroofy.se
Description: List subpages by using widget or the shortcode [somc­-subpages-kroofy].
Version: 0.1
Author: Rikard Ekberg
Author Email: rikard.ekberg@gmail.com
License:

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

include_once dirname( __FILE__ ) . '/somc-subpages.php';
include_once dirname( __FILE__ ) . '/somc-walker_page.php';
include_once dirname( __FILE__ ) . '/somc-widget-subpages.php';

class SOMC_Subpages_kroofy {

  /*--------------------------------------------*
   * Constants
   *--------------------------------------------*/
  const name = 'SOMC Subpages kroofy';
  const slug = 'somc_subpages_kroofy';
  
  /**
   * Constructor
   */
  function __construct() {
    add_action( 'init', array( &$this, 'init_somc_subpages_kroofy' ) );
  }
  
  /**
   * Runs when the plugin is initialized
   */
  function init_somc_subpages_kroofy() {
    // Load JavaScript and stylesheets
    $this->register_scripts_and_styles();

    // Register the shortcode [somc­-subpages-kroofy]
    add_shortcode( 'somc­-subpages-kroofy', array( &$this, 'render_shortcode' ) );

    add_filter( 'somc_subpages_the_title', array( &$this, 'somc_filter_truncate_title' ) ); 
  }

  /**
   * Filter function that truncates titles longer than 20 chars
   */
  function somc_filter_truncate_title($title) {
    $new_title = $title;

    if(strlen($new_title) > 20) {
      $new_title = substr($new_title, 0, 20) . '…';
    }

    return $new_title;
  }

  function render_shortcode($atts) {
    $subpages = new SOMC_Subpages();

    if( $subpages->render_subpages() ) {
      echo '<div class="subpages-container">';
      echo $subpages->render_subpages();
      echo '</div>';
    }
  }
  
  /**
   * Registers and enqueues stylesheets for the administration panel and the
   * public facing site.
   */
  private function register_scripts_and_styles() {
    if ( is_admin() ) {
      // $this->load_file( self::slug . '-admin-script', '/js/admin.js', true );
      // $this->load_file( self::slug . '-admin-style', '/css/admin.css' );
    } else {
      $this->load_file( self::slug . '-script', 'js/somc-subpages-kroofy.js', true );
      $this->load_file( self::slug . '-style', 'css/somc-subpages-kroofy.css' );
    } // end if/else
  } // end register_scripts_and_styles
  
  /**
   * Helper function for registering and enqueueing scripts and styles.
   *
   * @name  The   ID to register with WordPress
   * @file_path   The path to the actual file
   * @is_script   Optional argument for if the incoming file_path is a JavaScript source file.
   */
  private function load_file( $name, $file_path, $is_script = false ) {

    $url = plugins_url($file_path, __FILE__);
    $file = plugin_dir_path(__FILE__) . $file_path;

    if( file_exists( $file ) ) {
      if( $is_script ) {
        wp_register_script( $name, $url, array('jquery') ); //depends on jquery
        wp_enqueue_script( $name );
      } else {
        wp_register_style( $name, $url );
        wp_enqueue_style( $name );
      } // end if
    } // end if

  } // end load_file
  
} // end class

new SOMC_Subpages_kroofy();