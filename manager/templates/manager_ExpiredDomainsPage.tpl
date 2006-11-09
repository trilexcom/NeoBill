<h2> {echo phrase="EXPIRED_DOMAINS"} </h2>

<div class="search">
  {form name="search_expired_domains"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td> 
          {form_description field="fulldomainname"} <br/>
          {form_element field="fulldomainname" size="30"}
        </td>
        <td>
          {form_description field="tld"} <br/>
          {form_element field="tld" size="6"}
        </td>
        <td>
          {form_description field="accountname"} <br/>
          {form_element field="accountname" size="30"}
        </td>
        <td class="submit">
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="expired_domains"}
    {form_table field="domains"}

      {form_table_column columnid="fulldomainname" header="[DOMAIN_NAME]"}
        <a href="manager_content.php?page=domains_edit_domain&dpurchase={$domains.id}">{$domains.fulldomainname}</a>
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
