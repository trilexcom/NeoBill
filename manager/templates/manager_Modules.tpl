<h2> {echo phrase="MODULES"} </h2>

<div class="table">
  {form name="modules"}
    {form_table field="modules"}

      {form_table_column columnid="" header="[ENABLED]"}
        <center> {form_table_checkbox option=$modules.name} </center>
      {/form_table_column}

      {form_table_column columnid="name" header="[MODULE_NAME]"}
        {if $modules.configpage == null}
          {$modules.name}
        {else}
          <a href="manager_content.php?page={$modules.configpage}">{$modules.name}</a>
        {/if}
      {/form_table_column}

      {form_table_column columnid="type" header="[TYPE]"}
        {$modules.type}
      {/form_table_column}

      {form_table_column columnid="description" header="[DESCRIPTION]"}
        {$modules.description}
      {/form_table_column}

      {form_table_footer}
        {form_element field="update"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>