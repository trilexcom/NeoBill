<h2> {echo phrase="EMAIL_INVOICE"} </h2>

{form name="email_invoice"}
  <div class="form">
    <table style="width: 95%">
      <tr>
        <th style="width: 30%"> {form_description field="email"} </th>
        <td style="width: 70%"> {form_element field="email" size="30" value="$email"} </td>
      </tr>
      <tr>
        <th style="width: 30%"> {form_description field="invoice"} </th>
        <td style="width: 70%"> {form_element field="invoice" cols="60" rows="20" value="$body"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </td>
      </tr>
    </table>
  </div>
{/form}
