{form name="new_user"}

  <h2>{echo phrase="NEW_USER"}</h2>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="username"} </th>
        <td> {form_element field="username" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="repassword"} </th>
        <td> {form_element field="repassword" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element field="type"} </td>
      </tr>
      <tr>
        <th> {form_description field="firstname"} </th>
        <td> {form_element field="firstname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="lastname"} </th>
        <td> {form_element field="lastname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="email"} </th>
        <td> {form_element field="email" size="30"} </td>
      </tr>
      <tr class="footer">
        <th> <input type="submit" value="Create User"/> </th>
	<td/>
      </tr>
    </table>
  </div>

{/form}
