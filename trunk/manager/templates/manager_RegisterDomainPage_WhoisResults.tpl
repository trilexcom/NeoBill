<h2> {echo phrase="REGISTER"} {dbo_echo dbo="dspdbo" field="fulldomainname"} </h2>
{form name="register_domain_service"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="accountid"} </th>
        <td> {form_element field="accountid"} </td>
      </tr>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element field="term"} </td>
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
