<h2> {echo phrase="MODULES"} </h2>

{form name="modules"}
  <div class="table">
    {dbo_table dbo_class="ModuleDBO"
               name="moduledbo_table"
               title="[INSTALLED_MODULES]"}

      {dbo_table_column header="[ENABLED]"}
        {dbo_assign dbo="moduledbo_table" field="name" var="module_name"}
        {dbo_assign dbo="moduledbo_table" field="enabled" var="enabled"}
        <center>
          {if $enabled == "Yes"}
            {form_element field="enabled" value="$module_name" checked="true"}
          {else}
            {form_element field="enabled" value="$module_name"}
          {/if}
        </center>
      {/dbo_table_column}

      {dbo_table_column header="[MODULE_NAME]"}
        {dbo_assign dbo="moduledbo_table" field="configpage" var="configpage"}
        {if $configpage == null}
          {$module_name}
        {else}
          <a href="manager_content.php?page={$configpage}">{$module_name}</a>
        {/if}
      {/dbo_table_column}

      {dbo_table_column header="[TYPE]"}
        {dbo_echo dbo="moduledbo_table" field="type"}
      {/dbo_table_column}

      {dbo_table_column header="[DESCRIPTION]"}
        {dbo_echo dbo="moduledbo_table" field="description"}
      {/dbo_table_column}

    {/dbo_table}

  {form_element field="update"}

  </div>
{/form}
