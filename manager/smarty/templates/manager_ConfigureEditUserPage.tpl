<div class="action">
  <p class="header">Actions</p>
  {form name="edit_user_action"}
    {form_element field="delete"}
  {/form}
</div>

{form name="edit_user"}

  <h2>{echo phrase="EDIT_USER"}: {dbo_echo dbo="edit_user_dbo" field="username"}</h2>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="type"} </th>
        <td> {form_element dbo="edit_user_dbo" field="type"} </td>
      </tr>
      <tr>
        <th> {form_description field="firstname"} </th>
        <td> {form_element dbo="edit_user_dbo" field="firstname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="lastname"} </th>
        <td> {form_element dbo="edit_user_dbo" field="lastname" size="30"} </td>
      </tr>
      <tr>
        <th> {form_description field="email"} </th>
        <td> {form_element dbo="edit_user_dbo" field="email" size="30"} </td>
      </tr>
      <tr class="footer">
        <th> 
          <input type="submit" value="Update User"/> 
        </th>
	<td/>
      </tr>
    </table>
  </div>

{/form}

{form name="edit_user_pass"}

  <h2> {echo phrase="RESET_PASSWORD"} </h2>
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="password"} </th>
        <td> {form_element field="password" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="repassword"} </th>
        <td> {form_element field="repassword" size="20"} </td>
      </tr>
      <tr class="footer">
        <th> <input type="submit" value="Reset Password"/> </th>
	<td/>
      </tr>
    </table>
  </div>

{/form}
