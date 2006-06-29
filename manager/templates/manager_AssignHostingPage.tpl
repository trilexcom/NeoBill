<h2> {echo phrase="ASSIGN_HOSTING"}: {dbo_echo dbo="account_dbo" field="accountname"} </h2>

{form name="assign_hosting"}

  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="serviceid"} </th>
        <td> {form_element field="serviceid"} </td>
      </tr>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element field="term"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="server"} </th>
        <td> {form_element field="server"} </td>
      </tr>
      <tr>
        <th> {form_description field="ipaddress"} </th>
        <td> {form_element field="ipaddress"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>

{/form}
