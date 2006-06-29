<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="servers_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="SERVERS"} </h2>
<div class="table">
  {dbo_table dbo_class="ServerDBO"
             name="serverdbo_table"
             title="[SERVERS]"
             size="10"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="manager_content.php?page=services_view_server&id={dbo_echo dbo="serverdbo_table" field="id"}">{dbo_echo dbo="serverdbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[HOSTNAME]"}
      <a href="manager_content.php?page=services_view_server&id={dbo_echo dbo="serverdbo_table" field="id"}">{dbo_echo dbo="serverdbo_table" field="hostname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[LOCATION]"}
      {dbo_echo dbo="serverdbo_table" field="location"}
    {/dbo_table_column}

  {/dbo_table}
</div>
