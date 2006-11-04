<div class="action">
  <p class="header">Actions</p>
  {form name="users_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> [USERS] </h2>
<div class="search">
  {form name="search_userdbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="username"} <br/>
          {form_element field="username" size="10"}
        </td>
        <td>
          {form_description field="firstname"} <br/>
          {form_element field="firstname" size="20"}
        </td>
        <td>
          {form_description field="lastname"} <br/>
          {form_element field="lastname" size="20"}
        </td>
        <td>
          {form_description field="type"} <br/>
          {form_element field="type"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="users"}
    {form_table field="users"}

      {form_table_column columnid="username" header="[USERNAME]"}
        <a href="manager_content.php?page=config_edit_user&user={$users.username}">{$users.username}</a>
      {/form_table_column}

      {form_table_column columnid="type" header="[TYPE]"}
        {$users.type}
      {/form_table_column}

      {form_table_column columnid="lastname" header="[NAME]"}
        {$users.firstname} {$users.lastname}
      {/form_table_column}

      {form_table_column columnid="email" header="[EMAIL]"}
        {$users.email|mailto}
      {/form_table_column}

    {/form_table}
  {/form}
</div>