<h2> {echo phrase="RESELLER_CLUB_MODULE"} </h2>

{form name="rcm_config"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" value="$rcusername" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" value="$password"} </td>
      </tr>
      <tr>
        <th> {form_description field="resellerid"} </th>
        <td> {form_element field="resellerid" value="$resellerid"} </td>
      </tr>
      <tr>
        <th> {form_description field="parentid"} </th>
        <td> {form_element field="parentid" value="$parentid"} </td>
      </tr>
      <tr>
        <th> {form_description field="role"} </th>
        <td> {form_element field="role" value="$role"} </td>
      </tr>
      <tr>
        <th> {form_description field="langpref"} </th>
        <td> {form_element field="langpref" value="$langpref"} </td>
      </tr>
      <tr>
        <th> {form_description field="serviceurl"} </th>
        <td> {form_element field="serviceurl" value="$serviceurl" size="60"} </td>
      </tr>
      <tr>
        <th> {form_description field="debug"} </th>
        <td> {form_element field="debug" value="$debug"} </td>
      </tr>
      <tr>
        <th> {form_description field="defaultcustomerpassword"} </th>
        <td> {form_element field="defaultcustomerpassword" value="$defaultcustomerpassword"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  </div>
{/form}
