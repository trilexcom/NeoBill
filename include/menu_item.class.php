<?php
/*
 * @(#)include/menu_item.class.php
 *
 *    Version: 0.50.20090330
 * Written by: John Diamond <mailto:jdiamond@solid-state.org>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2006-2008 by John Diamond
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

  class Menu_Item {
    /*
     * @var integer
     */
    var $id = null;
    var $parent = null;
    
    /*
     * @var string
     */
    var $name = null;
    var $description = null;
    var $icon = null;
    var $url = null;
    
    /*
     * @var array
     */
    var $children = array();
    
    /*
     * @param string $name
     * @param string $description
     * @param string $icon
     * @param string $url
     */
    function Menu_Item($name, $description, $icon, $url) {
      $this->name        = $name;
      $this->description = $description;
      $this->icon        = $icon;
      $this->url         = $url;
    }
    
    /*
     * @param Menu_Item $item
     */
    function add_item($item) {
      $item->set_parent($this->id);
      $this->children[] = $item;
    }
    
    /*
     * @param string $name
     */
    function get_item($name) {
      if ($name == $this->name) {
        return $this;
      }
      foreach($this->children as $child) {
        if(null != ($result = $child->get_item($name))) {
          return $result;
        }
      }
      return null;
    }
    
    /*
     * @return string
     */
    function get_name() {
      return $this->name;
    }
    
    /*
     * @param integer $id
     */
    function set_id($id) {
      $this->id = $id;
    }
    
    /*
     * @param integer $parent
     */
    function set_parent($parent) {
      $this->parent = $parent;
    }
    
    /*
     * @return array
     */
    function to_array() {
      $result = array();
      if ('root' != $this->name) {
        $result = array($this->name => array('id'          => $this->id,
                                             'parent'      => $this->parentID,
                                             'description' => $this->description,
                                             'url'         => $this->url,
                                             'icon'        => $this->imageFile ) );
      }
      
      foreach($this->children as $child) {
        $result = array_merge($result, $child->to_array());
      }
      
      return $result;
    }
  }
?>