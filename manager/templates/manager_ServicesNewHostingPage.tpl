<h2> {echo phrase="NEW_HOSTING_SERVICE"} </h2>
{form name="new_hosting"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="title"} </th>
        <td> {form_element field="title" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="uniqueip"} </th>
        <td> {form_element field="uniqueip"} </td>
      </tr>
      <tr>
        <th> {form_description field="domainrequirement"} </th>
        <td> {form_element field="domainrequirement"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </td>
	<td/>
      </tr>
    </table>
  </div>
{/form}
