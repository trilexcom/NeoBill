{form name="assign_domain"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [ASSIGN_DOMAIN]: {dbo_echo dbo="account_dbo" field="accountname"} </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="continue"} 
          </th>
        </tr>
      </tfoot>
      <tbody>
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
      </tbody>
    </table>
  </div>
{/form}
