<div class="form">
  {form name="add_ip_address"}
    <table>
      <thead>
        <tr>
          <th colspan="2"> [ADD_IPS] {dbo_echo dbo="server_dbo" field="hostname"} </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
            {form_element field="continue"}
          </td>
          <td class="right">
            {form_element field="cancel"}
          </td>
        </tr>
      </tfoot>
      <tr>
        <th> {form_description field="begin_address"} </th>
        <td> {form_element field="begin_address"} </td>
      </tr>
      <tr>
        <th> {form_description field="end_address"} </th>
        <td> {form_element field="end_address"} </td>
      </tr>
    </table>
  {/form}
</div>
