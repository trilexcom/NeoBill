<h2>SolidState {echo phrase="LOG"}</h2>
<div class="table">
  {form name="log"}
    {form_table field="log"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="manager_content.php?page=view_log_message&log={$log.id}">{$log.id}</a>
      {/form_table_column}

      {form_table_column columnid="type" header="[TYPE]"}
        {$log.type}
      {/form_table_column}

      {form_table_column columnid="message" header="[MESSAGE]"}
        {$log.text}
      {/form_table_column}

      {form_table_column columnid="username" header="[USER]"}
        {$log.username}
      {/form_table_column}

      {form_table_column columnid="ip" header="[IP]"}
        {$log.ip}
      {/form_table_column}

      {form_table_column columnid="date" header="[DATE]"}
        {$log.date|datetime}
      {/form_table_column}

    {/form_table}
  {/form}
</div>