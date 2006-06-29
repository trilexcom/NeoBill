<h2> {echo phrase="SEND_WELCOME_EMAIL_CUSTOMER"} </h2>

{form name="welcome_email"}
  <div class="form">
    <table style="width: 95%">
      <tr>
        <th style="width: 30%"> {form_description field="email"} </th>
        <td style="width: 70%"> {form_element field="email" size="30" value="$email"} </td>
      </tr>
      <tr>
        <th style="width: 30%"> {form_description field="subject"} </th>
        <td style="width: 70%"> {form_element field="subject" size="30" value="$subject"} </td>
      </tr>
      <tr>
        <th style="width: 30%"> {form_description field="email_body"} </th>
        <td style="width: 70%"> {form_element field="email_body" cols="60" rows="20" value="$email_body"} </td>
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
