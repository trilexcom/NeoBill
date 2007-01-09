<h2> {echo phrase="NEW_PRODUCT"} </h2>

{form name="new_product"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="name"} </th>
        <td> {form_element field="name" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="public"} </th>
        <td> {form_element field="public" option="Yes"} </td>
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
