<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=order"> {echo phrase="ORDER_INTERFACE"} </a> </li>
</ul>

<h2> {echo phrase="AUTHENTICATION"} </h2>
<div class="form">
  {form name="settings_order_password"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="repassword"} </th>
        <td> {form_element field="repassword" size="20"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
