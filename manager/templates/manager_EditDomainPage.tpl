<h2> {echo phrase="EDIT_DOMAIN"} </h2>
{form name="edit_domain"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="domainname"} </th>
        <td>
          {form_element dbo="domain_dbo" field="domainname"}
          . {form_element dbo="domain_dbo" field="tld"}
        </td>
      </tr>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element dbo="domain_dbo" field="term"} </td>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element dbo="domain_dbo" field="date"} </td>
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

<h2> {echo phrase="RENEW_DOMAIN"} </h2>
{form name="renew_domain"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="term"} </th> 
        <td> {form_element dbo="domain_dbo" field="term"} </td> 
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="registrar"} </th>
        <td> {form_element field="registrar"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
        </th>
      </tr>
    </table>
  </div>
{/form}
