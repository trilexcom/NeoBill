{form name="new_domain_service"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [NEW_DOMAIN_SERVICE] </th>
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
          <th> {form_description field="tld"} </th>
          <td> .&nbsp;{form_element field="tld" size="8"} (com, net, org, ...) </td>
        </tr>
        <tr>
          <th> {form_description field="modulename"} </th>
          <td> {form_element field="modulename"} </td>
        </tr>
        <tr>
          <th> {form_description field="description"} </th>
          <td> {form_element field="description" cols="40" rows="3"} </td>
        </tr>
        <tr>
          <th> {form_description field="public"} </th>
          <td> {form_element field="public" option="Yes"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
