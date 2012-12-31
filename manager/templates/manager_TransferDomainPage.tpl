<div class="manager_content"</div>
{form name="transfer_domain"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [TRANSFER_DOMAIN] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left"/>
          <td class="right">
            {form_element field="continue"} 
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {form_description field="domainname"} </th>
          <td> {form_element field="domainname"} . {form_element field="servicetld"} </td>
        </tr>
        <tr>
          <th> {form_description field="secret"} </th>
          <td> {form_element field="secret" size="10"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
