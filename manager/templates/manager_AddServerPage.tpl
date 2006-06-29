<h2>{echo phrase="ADD_SERVER_PAGE"}</h2>
<div class="form">
  {form name="add_server"}
    <table>
      <tr>
        <th> {form_description field="hostname"} </th>
        <td> {form_element field="hostname"} </td>
      </tr>
      <tr>
        <th> {form_description field="location"} </th>
        <td> {form_element field="location" size="30"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </td>
      </tr>
    </table>
  {/form}
</div>
