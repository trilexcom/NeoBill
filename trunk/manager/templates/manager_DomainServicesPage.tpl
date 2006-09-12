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
  {dbo_table dbo_class="DomainServiceDBO" 
             name="domainservicedbo_table" 
             title="[DOMAIN_SERVICES]" 
             size="10"}

    {dbo_table_column header="TLD" sort_field="tld"}
      <a href="manager_content.php?page=services_view_domain_service&tld={dbo_echo dbo="domainservicedbo_table" field="tld"}"> .{dbo_echo dbo="domainservicedbo_table" field="tld"} </a>
    {/dbo_table_column}

    {dbo_table_column header="[DESCRIPTION]"}
      {dbo_echo|truncate:40:"..." dbo="domainservicedbo_table" field="description"}
    {/dbo_table_column}

    {dbo_table_column header="1 yr" sort_field="price1yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price1yr"}<br/>
    {/dbo_table_column}

    {dbo_table_column header="2 yr" sort_field="price2yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price2yr"}<br/>
    {/dbo_table_column}

    {dbo_table_column header="3 yr" sort_field="price3yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price3yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="4 yr" sort_field="price4yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price4yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="5 yr" sort_field="price5yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price5yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="6 yr" sort_field="price6yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price6yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="7 yr" sort_field="price7yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price7yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="8 yr" sort_field="price8yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price8yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="9 yr" sort_field="price9yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price9yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="10 yr" sort_field="price10yr"}
      {dbo_echo|currency dbo="domainservicedbo_table" field="price10yr"} <br/>
    {/dbo_table_column}

    {dbo_table_column header="[TAXABLE]" sort_field="taxable"}
      {dbo_echo dbo="domainservicedbo_table" field="taxable"}
    {/dbo_table_column}

  {/dbo_table}
</div>
