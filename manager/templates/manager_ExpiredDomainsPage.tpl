<h2> {echo phrase="EXPIRED_DOMAINS"} </h2>

<div class="table">
  {form name="expired_domains"}
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
