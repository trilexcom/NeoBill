<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="taxes_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="TAXES"} </h2>

<div class="table">
  {dbo_table dbo_class="TaxRuleDBO"
             name="taxruledbo_table"
             title="[TAX_RULES]"}

    {dbo_table_column header="[ID]" sort_field="id"}
      {dbo_echo dbo="taxruledbo_table" field="id"}
    {/dbo_table_column}

    {dbo_table_column header="[COUNTRY]" sort_field="country"}
      {dbo_echo|country dbo="taxruledbo_table" field="country"}
    {/dbo_table_column}

    {dbo_table_column header="[STATE]" sort_field="state"}
      {dbo_assign dbo="taxruledbo_table" field="allstates" var="allstates"}
      {if $allstates == "Yes"}
        {echo phrase="ALL"}
      {else}
        {dbo_echo dbo="taxruledbo_table" field="state"}
      {/if}
    {/dbo_table_column}

    {dbo_table_column header="[DESCRIPTION]" sort_field="description"}
      {dbo_echo dbo="taxruledbo_table" field="description"}
    {/dbo_table_column}

    {dbo_table_column header="[TAX_RATE]" sort_field="rate"}
      {dbo_echo dbo="taxruledbo_table" field="rate"}%
    {/dbo_table_column}

    {dbo_table_column header="[ACTION]"}
      <a href="manager_content.php?page=taxes&action=remove&taxrule={dbo_echo dbo="taxruledbo_table" field="id"}">{echo phrase="REMOVE"}</a>
    {/dbo_table_column}

  {/dbo_table}
</div>
