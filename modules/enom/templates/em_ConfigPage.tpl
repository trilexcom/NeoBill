<h2> [ENOM] </h2>
<div class="form">
  {form name="em_config"}
    <table>
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" value=$enomusername} </td>
      </tr>
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" value=$enompassword} </td>
      </tr>
      <tr>
        <th> {form_description field="url"} </th>
        <td>
          {form_element field="url" option="reseller.enom.com" value=$apiurl} <br/>
          {form_element field="url" option="resellertest.enom.com" value=$apiurl}
        </td>
      </tr>
      <tr class="footer">
        <td colspan="2"> {form_element field="save"} </td>
      </tr>
    </table>
  {/form}
</div>