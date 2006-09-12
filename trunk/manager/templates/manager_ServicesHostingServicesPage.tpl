<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="web_hosting_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
<div class="search">
  {form name="search_servicedbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
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
  {dbo_table dbo_class="HostingServiceDBO" 
             name="servicedbo_table" 
             title="[WEB_HOSTING_SERVICES]"}
    
    {dbo_table_column header="[ID]" sort_field="id"}
      <a target="content" href="manager_content.php?page=services_view_hosting_service&id={dbo_echo dbo="servicedbo_table" field="id"}">{dbo_echo dbo="servicedbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[TITLE]" sort_field="title"}
      <a target="content" href="manager_content.php?page=services_view_hosting_service&id={dbo_echo dbo="servicedbo_table" field="id"}">{dbo_echo dbo="servicedbo_table" field="title"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[DESCRIPTION]"}
      {dbo_echo|truncate:40:"..." dbo="servicedbo_table" field="description"}
    {/dbo_table_column}

    {dbo_table_column header="[UNIQUE_IP_ADDRESS]"}
      {dbo_echo dbo="servicedbo_table" field="uniqueip"}
    {/dbo_table_column}

    {dbo_table_column header="[SETUP_PRICE]" sort_field="setupprice1mo"}
      {dbo_echo|currency dbo="servicedbo_table" field="setupprice1mo"} (1 {echo phrase="MONTH"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="setupprice3mo"} (3 {echo phrase="MONTHS"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="setupprice6mo"} (6 {echo phrase="MONTHS"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="setupprice12mo"} (12 {echo phrase="MONTHS"})
    {/dbo_table_column}

    {dbo_table_column header="[RECURRING_PRICE]" sort_field="price1mo"}
      {dbo_echo|currency dbo="servicedbo_table" field="price1mo"} (1 {echo phrase="MONTH"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="price3mo"} (3 {echo phrase="MONTHS"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="price6mo"} (6 {echo phrase="MONTHS"})<br/>
      {dbo_echo|currency dbo="servicedbo_table" field="price12mo"} (12 {echo phrase="MONTHS"})
    {/dbo_table_column}

    {dbo_table_column header="[TAXABLE]" sort_field="taxable"}
      {dbo_echo dbo="servicedbo_table" field="taxable"}
    {/dbo_table_column}

  {/dbo_table}
</div>
