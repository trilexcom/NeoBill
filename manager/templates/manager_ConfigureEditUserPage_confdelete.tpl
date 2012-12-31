<div class="manager_content">
<p class="message">
  {echo phrase="REMOVE_USER_NOTICE"}:
</p>

<h2> {echo phrase="REMOVE_USER"} </h2>
{form name="delete_user_confirm"}
  <div class="properties">
    <table style="width: 60%">
      <tr>
        <th> {echo phrase="USERNAME"}: </th>
        <td> {dbo_echo dbo="edit_user_dbo" field="username"} </td>
      </tr>
      <tr>
        <th> {echo phrase="NAME"}: </th>
        <td> 
          {dbo_echo dbo="edit_user_dbo" field="contactname"} 
        </td>
      </tr>
      <tr>
        <th> {echo phrase="EMAIL"}: </th>
        <td> {dbo_echo|mailto dbo="edit_user_dbo" field="email"} </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          {form_element field="continue"}
          {form_element field="goback"}
        </th>
        <td/>
      </tr>
    </table>
  </div>
{/form}
</div>
