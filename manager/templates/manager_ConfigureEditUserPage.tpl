<div class="manager_content">

<div id="tabs">
<ul>
<li><a href="#tabs-1">Delete User</a></li>
<li><a href="#tabs-2">Edit Basic Info</a></li>
<li><a href="#tabs-3">Edit Password</a></li>
</ul>
<div id="tabs-1">

  <div id="info" name="[USER_INFO]" width="80">
    <div class="action">
      <p class="header">Actions</p>
      {form name="edit_user_action"}
        {form_element field="delete"}
      {/form}
    </div>

  </div>
</div>
<div id="tabs-2">
    {form name="edit_user"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [EDIT_USER]: {dbo_echo dbo="edit_user_dbo" field="username"} </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left"/>
              <td class="right"> 
                <input type="submit" value="Update User"/> 
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="type"} </th>
              <td> {form_element dbo="edit_user_dbo" field="type"} </td>
            </tr>
            <tr>
              <th> {form_description field="contactname"} </th>
              <td> {form_element dbo="edit_user_dbo" field="contactname" size="30"} </td>
            </tr>
            <tr>
              <th> {form_description field="email"} </th>
              <td> {form_element dbo="edit_user_dbo" field="email" size="30"} </td>
            </tr>
            <tr>
              <th> {form_description field="language"} </th>
              <td> {form_element dbo="edit_user_dbo" field="language"} </td>
            </tr>
            <tr>
              <th> {form_description field="theme"} </th>
              <td> {form_element dbo="edit_user_dbo" field="theme"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div>


<div id="tabs-3">
  <div id="password" name="[PASSWORD]" width="80">
    {form name="edit_user_pass"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [RESET_PASSWORD] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right"> <input type="submit" value="Reset Password"/> </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="password"} </th>
              <td> {form_element field="password" size="20"} </td>
            </tr>
            <tr>
              <th> {form_description field="repassword"} </th>
              <td> {form_element field="repassword" size="20"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div> 
</div>
</div>
</div>
</div>
