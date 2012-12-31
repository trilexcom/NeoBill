<div class="manager_content">
{form name="welcome_email"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [SEND_WELCOME_EMAIL_CUSTOMER] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="continue"}
          </td>
        </tr>
      </tfoot>
      <tbody>
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
      </tbody>
    </table>
  </div>
{/form}
</div>
