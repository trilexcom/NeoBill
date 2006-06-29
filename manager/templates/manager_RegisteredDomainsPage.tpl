<h2> {echo phrase="REGISTERED_DOMAINS"} </h2>

<div class="search">
  {form name="search_domaindbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td> 
          {form_description field="domainname"} <br/>
          {form_element field="domainname"}
        </td>
        <td>
          {form_description field="tld"} <br/>
          {form_element field="tld"}
        </td>
        <td class="submit">
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {dbo_table dbo_class="DomainServicePurchaseDBO" 
             name="domaindbo_table" 
             title="[REGISTERED_DOMAINS]" 
             size="10"}

    {dbo_table_column header="[DOMAIN_NAME]" sort_field="domainname"}
      <a href="manager_content.php?page=domains_edit_domain&id={dbo_echo dbo="domaindbo_table" field="id"}">{dbo_echo dbo="domaindbo_table" field="fulldomainname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT]" sort_field="accountname"}
      <a href="manager_content.php?page=accounts_view_account&id={dbo_echo dbo="domaindbo_table" field="accountid"}">{dbo_echo dbo="domaindbo_table" field="accountname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[REGISTRATION_DATE]" sort_field="date"}
      {dbo_echo|datetime:date dbo="domaindbo_table" field="date"}
    {/dbo_table_column}

    {dbo_table_column header="[TERM]" sort_field="term"}
      {dbo_echo dbo="domaindbo_table" field="term"}
    {/dbo_table_column}

    {dbo_table_column header="[EXPIRATION_DATE]" sort_field="expiredate"}
      {dbo_echo|datetime:date dbo="domaindbo_table" field="expiredate"}
    {/dbo_table_column}

  {/dbo_table}
</div>
