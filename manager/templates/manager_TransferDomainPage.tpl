<h2> {echo phrase="TRANSFER_DOMAIN"} </h2>

{form name="transfer_domain"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="domainname"} </th>
        <td> {form_element field="domainname"} . {form_element field="servicetld"} </td>
      </tr>
      <tr>
        <th> {form_description field="secret"} </th>
        <td> {form_element field="secret" size="10"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
        </th>
      </tr>
    </table>
  </div>
{/form}
