{form name="transfer_domain_service"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [TRANSFER] {dbo_echo dbo="dspdbo" field="fulldomainname"} </th>
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
          <th> {form_description field="account"} </th>
          <td> {form_element field="account"} </td>
        </tr>
        <tr>
          <th> {form_description field="term"} </th>
          <td> {form_element field="term"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
