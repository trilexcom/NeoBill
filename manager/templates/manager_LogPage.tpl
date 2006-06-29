<h2>SolidState {echo phrase="LOG"}</h2>
<div class="table">
  {dbo_table dbo_class="LogDBO"
             name="logdbo_table"
             title="[LOG_ENTRIES]"
             size="25"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="manager_content.php?page=view_log_message&id={dbo_echo dbo="logdbo_table" field="id"}">{dbo_echo dbo="logdbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[TYPE]" sort_field="type"}
      {dbo_echo dbo="logdbo_table" field="type"}
    {/dbo_table_column}

    {dbo_table_column header="[MESSAGE]" sort_field="text"}
      {dbo_echo dbo="logdbo_table" field="text"}
    {/dbo_table_column}

    {dbo_table_column header="[USER]" sort_field="username"}
      {dbo_echo dbo="logdbo_table" field="username"}
    {/dbo_table_column}

    {dbo_table_column header="IP" sort_field="remoteip"}
      {dbo_echo dbo="logdbo_table" field="remoteipstring"}
    {/dbo_table_column}

    {dbo_table_column header="[DATE]
" sort_field="date"}
      {dbo_echo|datetime dbo="logdbo_table" field="date"}
    {/dbo_table_column}

  {/dbo_table}
</div>
