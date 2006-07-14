<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> {echo phrase="PAYMENT_GATEWAY"} </a> </li> </li>
</ul>

<h2> {echo phrase="LOCALE"} </h2>
<div class="form">
  {form name="settings_locale"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="language"} </th>
        <td> {form_element field="language"} </td>
      </tr>
      <tr>
        <th> {form_description field="currency"} </th>
        <td> {form_element field="currency" value="$currency" size="5"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
