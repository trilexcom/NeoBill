<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./style.css" />  
    <script type="text/javascript" src="../include/dhtmlxTree/js/dhtmlXCommon.js"></script>
    <script type="text/javascript" src="../include/dhtmlxTree/js/dhtmlXTree.js"></script>
  </head>

  <body class="menu">
    <div id="treeMenu" class="menubox"></div>
    <script type="text/javascript">

      function onMenuNodeSelect( nodeId )
      {ldelim}
        switch( nodeId )
        {ldelim}

          {* This PHP code builds the javascript event handler for the dhtmlxTree menu *}
          {php}
            global $menuItems;

            foreach( $menuItems as $menuItem )
              {
                printf( "\t\tcase %d:\n", $menuItem['id'] );
                printf( "\t\t\tparent.content.location.href = \"%s\";\n", $menuItem['url'] );
                printf( "\t\t\tbreak;\n" );
              }
          {/php}

          default:
            alert( "node: " + nodeId );
           break;
        {rdelim}
      {rdelim}

      tree = new dhtmlXTreeObject( document.getElementById( 'treeMenu' ), "100%", "100%", 0 ); 
      tree.enableCheckBoxes(false);
      tree.enableDragAndDrop( false );
      tree.setOnClickHandler( onMenuNodeSelect );
      tree.setImagePath( "images/" );

      {* This PHP code builds javascript that inserts the dhtmlxTree items *}
      {php}
        global $menuItems;

        foreach( $menuItems as $menuItem )
          {
            printf( "\ttree.insertNewChild( %d, %d, \"%s\", 0, \"%s\", \"%s\", \"%s\", \"\" )\n",
                    $menuItem['parentID'],
                    $menuItem['id'],
                    $menuItem['description'],
                    $menuItem['imageFile'],
                    $menuItem['imageFile'],
                    $menuItem['imageFile'] );
          }
      {/php}
    </script>
  <body>
</html>
