<h2> {echo phrase="TRANSFER"} {dbo_echo dbo="dspdbo" field="fulldomainname"} </h2>
{form name="transfer_domain_service"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="account"} </th>
        <td> {form_element field="account"} </td>
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
