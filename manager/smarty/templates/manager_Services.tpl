<h2> {echo phrase="PRODUCTS_SERVICES_SUMMARY"} </h2>
<div class="properties">
  <table style="width: 90%">
    <tr>
      <th> {echo phrase="WEB_HOSTING_SERVICES"} </th>
      <td> <a href="manager_content.php?page=services_web_hosting">{$services_count}</a> </td>
      <td class="action_cell">&raquo; <a href="manager_content.php?page=services_new_hosting">{echo phrase="NEW_HOSTING_SERVICE"}</a> </td>
    </tr>
    <tr>
      <th> {echo phrase="DOMAIN_SERVICES"} </th>
      <td> <a href="manager_content.php?page=services_domain_services">{$domain_services_count}</a> </td>
      <td class="action_cell">&raquo; <a href="manager_content.php?page=services_new_domain_service">{echo phrase="NEW_DOMAIN_SERVICE"}</a> </td>
    </tr>
    <tr>
      <th> {echo phrase="PRODUCTS"} </th>
      <td> <a href="manager_content.php?page=services_products">{$products_count}</a> </td>
      <td class="action_cell">&raquo; <a href="manager_content.php?page=services_new_product">{echo phrase="NEW_PRODUCT"}</a> </td>
    </tr>
  </table>
</div>
