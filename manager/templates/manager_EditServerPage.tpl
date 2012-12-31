<div class="manager_content"</div>
<div class="form">
  {form name="edit_server"}
    <table>
      <thead>
        <tr>
          <th colspan="2"> [EDIT_SERVER] ([ID]: {dbo_echo dbo="server_dbo" field="id"}) </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="save"}
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {form_description field="hostname"} </th>
          <td> {form_element dbo="server_dbo" field="hostname"} </td>
        </tr>
        <tr>
          <th> {form_description field="location"} </th>
          <td> {form_element dbo="server_dbo" field="location" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="cpmodule"} </th>
          <td> 
            {form_element dbo="server_dbo" field="cpmodule" empty="[NO_CONTROL_PANEL_MODULES_HAVE_BEEN_ENABLED]"}
          </td>
        </tr>
    </table>
  {/form}
</div>
