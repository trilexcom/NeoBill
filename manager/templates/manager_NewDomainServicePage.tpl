<h2> {echo phrase="NEW_DOMAIN_SERVICE"} </h2>

{form name="new_domain_service"}
  <div class="form">
    <table style="width: 70%">
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
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </th>
	<td/>
      </tr>
    </table>
  </div>
{/form}
