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
  {form name="registered_domains"}
    {form_table field="domains"}

      {form_table_column columnid="domainname" header="[DOMAIN_NAME]"}
        <a href="manager_content.php?page=domains_edit_domain&dpurchase={$domains.id}">{$domains.domainname}</a>
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ACCOUNT]"}
        <a href="manager_content.php?page=accounts_view_account&account={$domains.accountid}">{$domains.accountname}</a>
      {/form_table_column}

      {form_table_column columnid="date" header="[REGISTRATION_DATE]"}
        {$domains.date|datetime:date}
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$domains.term}
      {/form_table_column}

      {form_table_column columnid="expiredate" header="[EXPIRATION_DATE]"}
        {$domains.expiredate|datetime:date}
      {/form_table_column}

    {/form_table}
  {/form}
</div>