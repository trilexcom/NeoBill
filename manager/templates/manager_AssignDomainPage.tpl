<h2> {echo phrase="ASSIGN_DOMAIN"}: {dbo_echo dbo="account_dbo" field="accountname"} </h2>

{form name="assign_domain"}

  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="domainname"} </th>
        <td> 
          {form_element field="domainname"}
          . {form_element field="tld" onChange="submit()"}
        </td>
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
        <th> {form_description field="note"} </th>
        <td> {form_element field="note" rows=4 cols=50} </td>
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
