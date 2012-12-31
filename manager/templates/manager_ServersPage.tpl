<div class="manager_content"</div>
<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="servers_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="SERVERS"} </h2>
<div class="search">
  {form name="search_servers"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="hostname"} <br/>
          {form_element field="hostname" size="40"}
        </td>
        <td>
          {form_description field="location"} <br/>
          {form_element field="location" size="40"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="servers"}
    {form_table field="servers"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="manager_content.php?page=services_view_server&server={$servers.id}">{$servers.id}</a>
      {/form_table_column}

      {form_table_column columnid="hostname" header="[HOSTNAME]"}
        <a href="manager_content.php?page=services_view_server&server={$servers.id}">{$servers.hostname}</a>
      {/form_table_column}

      {form_table_column columnid="location" header="[LOCATION]"}
        {$servers.location}
      {/form_table_column}

    {/form_table}
  {/form}
</div>