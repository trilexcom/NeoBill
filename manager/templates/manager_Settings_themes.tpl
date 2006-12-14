<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> [GENERAL] </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=themes"> [THEMES] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> [BILLING] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> [DNS] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> [LOCALE] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> [PAYMENTS] </a> </li>
</ul>

<h2> [THEMES] </h2>
<div class="form">
  {form name="settings_themes"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="managertheme"} </th>
        <td> {form_element field="managertheme" value="$managerTheme"} </td>
      </tr>
      <tr>
        <th> {form_description field="ordertheme"} </th>
        <td> {form_element field="ordertheme" value="$orderTheme"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
