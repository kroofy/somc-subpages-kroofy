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

class SOMC_Walker_Page extends Walker_Page {
  /**
   * Based on WP's Walker_Page class. Used to add extra buttons
   * for sorting and expanding child nodes. Also displays post_thumbnail if available.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $page Page data object.
   * @param int $depth Depth of page. Used for padding.
   * @param int $current_page Page ID.
   * @param array $args
   */
  function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
    if ( $depth )
      $indent = str_repeat("\t", $depth);
    else
      $indent = '';

    extract($args, EXTR_SKIP);
    $css_class = array('page_item', 'page-item-'.$page->ID);

    if( isset( $args['pages_with_children'][ $page->ID ] ) )
      $css_class[] = 'page_item_has_children';

    if ( !empty($current_page) ) {
      $_current_page = get_post( $current_page );
      if ( in_array( $page->ID, $_current_page->ancestors ) )
        $css_class[] = 'current_page_ancestor';
      if ( $page->ID == $current_page )
        $css_class[] = 'current_page_item';
      elseif ( $_current_page && $page->ID == $_current_page->post_parent )
        $css_class[] = 'current_page_parent';
    } elseif ( $page->ID == get_option('page_for_posts') ) {
      $css_class[] = 'current_page_parent';
    }

    $css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

    if ( '' === $page->post_title )
      $page->post_title = sprintf( __( '#%d (no title)' ), $page->ID );

    $output .= $indent . '<li class="' . $css_class . '">';
    // Only add buttons if pages_with_children is true
    if( isset( $args['pages_with_children'][ $page->ID ] ) ) {
      $output .= '<button class="subpages-button subpages-button-expand"></button>';
    }
    // Only add post thumbnail if it exists
    if( has_post_thumbnail($page->ID) ) {
      $output .= get_the_post_thumbnail($page->ID, array(20,20));
    }
    $output .= '<a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'somc_subpages_the_title', $page->post_title, $page->ID ) . $link_after . '</a>';
    // Same thing here, add the button only if pages_With_childern is true
    if( isset( $args['pages_with_children'][ $page->ID ] ) ) {
      $output .= '<button class="subpages-button subpages-button-sort"></button>';
    }

    if ( !empty($show_date) ) {
      if ( 'modified' == $show_date )
        $time = $page->post_modified;
      else
        $time = $page->post_date;

      $output .= " " . mysql2date($date_format, $time);
    }
  }
}