<div class="manager_content"</div>
<p class="message">
  {echo phrase="USER_CREATED"}.
</p>

<div class="action">
  <p class="header">Actions</p>
  {form name="new_user_action"}
    {form_element field="add"}
    {form_element field="view"}
  {/form}
</div>

<h2> {echo phrase="NEW_USER"} </h2>
<div class="properties">
  <table style="width: 60%">
    <tr>
      <th> {echo phrase="USERNAME"}: </th>
      <td> {dbo_echo dbo="new_user_dbo" field="username"} </td>
    </tr>
    <tr>
      <th> {echo phrase="PASSWORD"}: </th>
      <td> {dbo_echo|password dbo="new_user_dbo" field="password"}</td>
    </tr>
    <tr>
      <th> {echo phrase="TYPE"}: </th>
      <td> {dbo_echo dbo="new_user_dbo" field="type"} </td>
    </tr>
    <tr>
      <th> {echo phrase="NAME"}: </th>
      <td> 
        {dbo_echo dbo="new_user_dbo" field="contactname"}
      </td>
    </tr>
    <tr>
      <th> {echo phrase="EMAIL"}: </th>
      <td> {dbo_echo|mailto dbo="new_user_dbo" field="email"} </td>
    </tr>
  </table>
</div>
