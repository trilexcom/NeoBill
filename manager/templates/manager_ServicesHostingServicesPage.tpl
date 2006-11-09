<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="web_hosting_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
<div class="search">
  {form name="search_hosting_services"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="title"} <br/>
          {form_element field="title" size="30"}
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
  {form name="hosting_services"}
    {form_table field="hosting_services"}

      {form_table_column columnid="id" header="[ID]"}
        <a target="content" href="manager_content.php?page=services_view_hosting_service&hservice={$hosting_services.id}">{$hosting_services.id}</a>
      {/form_table_column}

      {form_table_column columnid="title" header="[TITLE]"}
        <a target="content" href="manager_content.php?page=services_view_hosting_service&hservice={$hosting_services.id}">{$hosting_services.title}</a>
      {/form_table_column}

      {form_table_column columnid="description" header="DESCRIPTION"}
        {$hosting_services.description|truncate:40:"..."}
      {/form_table_column}

      {form_table_column columnid="uniqueip" header="[UNIQUE_IP_ADDRESS]"}
        {$hosting_services.uniqueip}
      {/form_table_column}

      {form_table_column columnid="setupprice1mo" header="[SETUP_PRICE]"}
        {$hosting_services.setupprice1mo|currency} (1 [MONTH]) <br/>
        {$hosting_services.setupprice3mo|currency} (3 [MONTH]) <br/>
        {$hosting_services.setupprice6mo|currency} (6 [MONTH]) <br/>
        {$hosting_services.setupprice12mo|currency} (12 [MONTH])
      {/form_table_column}

      {form_table_column columnid="price1mo" header="[RECURRING_PRICE]"}
        {$hosting_services.price1mo|currency} (1 [MONTH]) <br/>
        {$hosting_services.price3mo|currency} (3 [MONTH]) <br/>
        {$hosting_services.price6mo|currency} (6 [MONTH]) <br/>
        {$hosting_services.price12mo|currency} (12 [MONTH])
      {/form_table_column}

      {form_table_column columnid="taxable" header="[TAXABLE]"}
        {$hosting_services.taxable}
      {/form_table_column}

    {/form_table}
  {/form}
</div>