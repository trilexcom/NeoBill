<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="domain_services_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="DOMAIN_SERVICES"} </h2>
<div class="search">
  {form name="search_domainservicedbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="tld"} <br/>
          {form_element field="tld" size="4"}
        </td>
        <td>
          {form_description field="description"} <br/>
          {form_element field="description" size="30"}
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
    {form_table field="services" size="10"}

      {form_table_column columnid="tld" header="[TLD]"}
        <a href="manager_content.php?page=services_view_domain_service&dservice={$services.tld}"> .{$services.tld} </a>
      {/form_table_column}

      {form_table_column columnid="price1yr" header="1 yr"}
        {$services.price1yr|currency}
      {/form_table_column}

      {form_table_column columnid="price2yr" header="2 yr"}
        {$services.price2yr|currency}
      {/form_table_column}

      {form_table_column columnid="price3yr" header="3 yr"}
        {$services.price3yr|currency}
      {/form_table_column}

      {form_table_column columnid="price4yr" header="4 yr"}
        {$services.price4yr|currency}
      {/form_table_column}

      {form_table_column columnid="price5yr" header="5 yr"}
        {$services.price5yr|currency}
      {/form_table_column}

      {form_table_column columnid="price6yr" header="6 yr"}
        {$services.price6yr|currency}
      {/form_table_column}

      {form_table_column columnid="price7yr" header="7 yr"}
        {$services.price7yr|currency}
      {/form_table_column}

      {form_table_column columnid="price8yr" header="8 yr"}
        {$services.price8yr|currency}
      {/form_table_column}

      {form_table_column columnid="price9yr" header="9 yr"}
        {$services.price9yr|currency}
      {/form_table_column}

      {form_table_column columnid="price10yr" header="10 yr"}
        {$services.price10yr|currency}
      {/form_table_column}

      {form_table_column columnid="taxable" header="[TAXABLE]"}
        {$services.taxable}
      {/form_table_column}

    {/form_table}
  {/form}
</div>