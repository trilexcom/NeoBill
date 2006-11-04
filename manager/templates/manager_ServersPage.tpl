<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="servers_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="SERVERS"} </h2>
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