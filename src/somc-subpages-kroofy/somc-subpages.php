<?php
/*
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

class SOMC_Subpages {

  function render_subpages() {
    // grab the global $post variable
    global $post;

    // init the custom walker
    $walker = new SOMC_Walker_Page();
    
    // setup the arguments to be used by `wp_list_pages`
    $args = array(
      'title_li' => '',
      'child_of' => $post->ID,
      'post_type' => $post->post_type,
      'depth' => 0,
      'echo' => 0,
      'walker' => $walker
    );

    $the_pages = wp_list_pages( $args );

    $output = '';

    if(!is_null($the_pages)) {
      // wrap the output with the sort button and ul tags
      $output .= '<button class="subpages-button subpages-button-sort"></button>';
      $output .= '<ul>';
      $output .= $the_pages;
      $output .= '</ul>';
    }
    
    return $output;
  }
  
} // end class