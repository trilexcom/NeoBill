<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script src="../include/dhtmlxTree/js/dhtmlXCommon.js"></script>
    <script src="../include/dhtmlxTree/js/dhtmlXTree.js"></script>
  </head>

  <body class="menu">
    <div id="treeMenu" class="menubox"></div>
    <script type="text/javascript">
      {$menuEventHandler}

      tree = new dhtmlXTreeObject( document.getElementById( 'treeMenu' ), "100%", "100%", 0 ); 
      tree.enableCheckBoxes(false);
      tree.enableDragAndDrop( false );
      tree.setOnClickHandler( onMenuNodeSelect );
      tree.setImagePath( "images/" ); 

      {$menuData}
    </script>
  <body>
</html>
