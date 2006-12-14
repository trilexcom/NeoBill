<?php
/**
 * SolidStateMenuItem.class.php
 *
 * This file contains the definition of the SolidStateMenuItem class
 *
 * @package SolidState
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * SolidStateMenuItem
 *
 * @package SolidState
 * @author John Diamond <jdiamond@solid-state.org>
 */
class SolidStateMenuItem
{
  /**
   * @var array Menu item children
   */
  protected $children = array();

  /**
   * @var string Item description
   */
  protected $description = null;

  /**
   * @var integer Menu item ID
   */
  protected $id = null;

  /**
   * @var string Icon image file
   */
  protected $imageFile = null;

  /**
   * @var string Item name
   */
  protected $name = null;

  /**
   * @var integer Item's parent ID
   */
  protected $parentID = null;

  /**
   * @var string Item URL
   */
  protected $url = null;

  /**
   * Constructor
   *
   * @param string $name Item name
   * @param string $description Item description
   * @param string $imageFile Item icon image file
   * @param string $url Item action URL
   */
  public function __construct( $name, $description = null, $imageFile = null, $url = null )
  {
    $this->name = $name;
    $this->description = $description;
    $this->imageFile = $imageFile;
    $this->url = $url;
  }

  /**
   * Add Item
   *
   * @param SolidStateMenuItem New menu item child
   */
  public function addItem( SolidStateMenuItem $item )
  {
    $item->setParentID( $this->id );
    $this->children[] = $item;
  }

  /**
   * Get Item
   *
   * @param string $name The name of the item
   */
  public function getItem( $name )
  {
    // If this is the item being searched for, return "this"
    if( $name == $this->name )
      {
	return $this;
      }

    // Otherwise search all of the children
    foreach( $this->children as $childItem )
      {
	if( null != ($result = $childItem->getItem( $name )) )
	  {
	    return $result;
	  }
      }

    // And return null if nothing was found
    return null;
  }

  /**
   * Get Name
   *
   * @return string Menu item name
   */
  public function getName() { return $this->name; }

  /**
   * Set Menu Item ID
   *
   * @param integer $id Menu item ID
   */
  public function setID( $id ) { $this->id = $id; }

  /**
   * Set Parent ID
   *
   * @param integer $id Menu item's parent ID
   */
  public function setParentID( $id ) { $this->parentID = $id; }

  /**
   * To Array
   *
   * Flatten the menu item in an array
   *
   * @return array An array of menu item data along with children
   */
  public function toArray()
  {
    $result = array();
    if( $this->name != "root" )
      {
	$result = array( $this->name => array( "id" => $this->id,
					       "parentID" => $this->parentID,
					       "description" => $this->description,
					       "url" => $this->url,
					       "imageFile" => $this->imageFile ) );
      }

    foreach( $this->children as $childItem )
      {
	$result = array_merge( $result, $childItem->toArray() );
      }

    return $result;
  }
}
?>