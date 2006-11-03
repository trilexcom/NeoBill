<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="taxes_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="TAXES"} </h2>

<div class="table">
  {form name="tax_rules"}
    {form_table field="rules"}

      {form_table_column columnid=""}
        <center> {form_table_checkbox option=$rules.id} </center>
      {/form_table_column}

      {form_table_column columnid="id" header="[ID]"}
        {$rules.id}
      {/form_table_column}

      {form_table_column columnid="country" header="[COUNTRY]"}
        {$rules.country|country}
      {/form_table_column}

      {form_table_column columnid="state" header="[STATE]"}
        {if $rules.allstates == "Yes"}
          [ALL]
        {else}
          {$rules.state}
        {/if}
      {/form_table_column}

      {form_table_column columnid="description" header="[DESCRIPTION]"}
        {$rules.description}
      {/form_table_column}

      {form_table_column columnid="rate" header="[TAX_RATE]"}
        {$rules.rate}%
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>