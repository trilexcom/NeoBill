<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> {echo phrase="PAYMENTS"} </a> </li>
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
