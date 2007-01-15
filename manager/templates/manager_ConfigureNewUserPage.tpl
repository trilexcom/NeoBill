{form name="new_user"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [NEW_USER] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
	  <td class="left"/>
          <td class="right"> <input type="submit" value="Create User"/> </th>
        </tr>
      </tfoot>
      <tbody>
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
          <th> {form_description field="contactname"} </th>
          <td> {form_element field="contactname" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="email"} </th>
          <td> {form_element field="email" size="30"} </td>
        </tr>
        <tr>
          <th> {form_description field="language"} </th>
          <td> {form_element field="language"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
