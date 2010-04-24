<h2> [CPANEL_SERVER_CONFIGURATION] </h2>

<div class="form">
  {form name="cp_server_config"}
    <table>
      <tr>
        <th> [HOSTNAME]: </th>
        <td> {$hostname} </td>
      </tr>
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" size="10" value=$WHMUsername} </th>
      </tr>
      <tr>
        <th> {form_description field="accesshash"} </th>
        <td> {form_element field="accesshash" rows="28" cols="32" value=$accessHash} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="cancel"}
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>