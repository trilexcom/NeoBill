<div class="manager_content"</div>
<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="domain_services_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="DOMAIN_SERVICES"} </h2>
<div class="search">
  {form name="search_domain_services"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="tld"} <br/>
          {form_element field="tld" size="6"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="domain_services"}
    {form_table field="services" size="10" style="width: 67%"}

      {form_table_column columnid="tld" header=""}
        <center> {form_table_checkbox option=$services.tld} </center>
      {/form_table_column}

      {form_table_column columnid="tld" header="[TLD]"}
        <a href="manager_content.php?page=services_edit_domain_service&dservice={$services.tld}"> .{$services.tld} </a>
      {/form_table_column}

      {form_table_column columnid="module" header="[MODULE]"}
        {$services.module}
      {/form_table_column}

      {form_table_column columnid="pricing" header="[PRICING]"}
        {$services.pricing}
      {/form_table_column}

      {form_table_column columnid="public" header="[PUBLIC]"}
        {$services.public}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>