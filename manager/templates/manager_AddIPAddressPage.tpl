<h2>{echo phrase="ADD_IPS"} {dbo_echo dbo="server_dbo" field="hostname"}</h2>
<div class="form">
  {form name="add_ip_address"}
    <table>
      <tr>
        <th> {form_description field="begin_address"} </th>
        <td> {form_element field="begin_address"} </td>
      </tr>
      <tr>
        <th> {form_description field="end_address"} </th>
        <td> {form_element field="end_address"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  {/form}
</div>
