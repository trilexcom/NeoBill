<div class="action">
  <p class="header">Actions</p>
  {form name="users_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo field="USERS"} </h2>
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
  {dbo_table dbo_class="UserDBO" 
             name="userdbo_table" 
             title="[USERS]" 
             size="10"}

    {dbo_table_column header="[USERNAME]" sort_field="username"}
      <a href="manager_content.php?page=config_edit_user&username={dbo_echo dbo="userdbo_table" field="username"}">{dbo_echo dbo="userdbo_table" field="username"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[TYPE]" sort_field="type"}
      {dbo_echo dbo="userdbo_table" field="type"}
    {/dbo_table_column}

    {dbo_table_column header="[NAME]" sort_field="lastname"}
      {dbo_echo dbo="userdbo_table" field="firstname"}
      {dbo_echo dbo="userdbo_table" field="lastname"}
    {/dbo_table_column}

    {dbo_table_column header="[EMAIL]" sort_field="email"}
      {dbo_echo|mailto dbo="userdbo_table" field="email"}
    {/dbo_table_column}

  {/dbo_table}
</div>
