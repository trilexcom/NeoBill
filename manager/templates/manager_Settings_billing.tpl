<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> [GENERAL] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=themes"> [THEMES] </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=billing"> [BILLING] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> [DNS] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> [LOCALE] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> [PAYMENTS] </a> </li>
</ul>

<h2> {echo phrase="INVOICE"} </h2>
<div class="form">
  {form name="settings_invoice"}
    <table style="width: 95%">
      <tr>
        <th colspan="2"> {form_description field="subject"} </th>
      </tr>
      <tr>
        <td colspan="2"> {form_element field="subject" value="$invoice_subject" size="80"} </td>
      </tr>
      <tr>
        <th colspan="2"> {form_description field="text"} </th>
      </tr>
      <tr>
        <td colspan="2"> {form_element field="text" value="$invoice_text" cols="80" rows="20"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
