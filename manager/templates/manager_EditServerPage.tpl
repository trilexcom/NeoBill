<h2> {echo phrase="EDIT_SERVER"} (ID: {dbo_echo dbo="server_dbo" field="id"})</h2>
<div class="form">
  {form name="edit_server"}
    <table>
      <tr>
        <th> {form_description field="hostname"} </th>
        <td> {form_element dbo="server_dbo" field="hostname"} </td>
      </tr>
      <tr>
        <th> {form_description field="location"} </th>
        <td> {form_element dbo="server_dbo" field="location" size="30"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
          {form_element field="cancel"}
        </td>
      </tr>
    </table>
  {/form}
</div>
