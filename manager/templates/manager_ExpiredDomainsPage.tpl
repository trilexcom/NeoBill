<h2> {echo phrase="EXPIRED_DOMAINS"} </h2>

<div class="table">
  {dbo_table dbo_class="DomainServicePurchaseDBO" 
             name="domaindbo_table"
             title="[EXPIRED_DOMAINS]" 
             size="10"}

    {dbo_table_column header="[DOMAIN_NAME]" sort_field="domainname"}
      <a href="manager_content.php?page=domains_edit_domain&dpurchase={dbo_echo dbo="domaindbo_table" field="id"}">{dbo_echo dbo="domaindbo_table" field="fulldomainname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT]" sort_field="accountname"}
      <a href="manager_content.php?page=accounts_view_account&account={dbo_echo dbo="domaindbo_table" field="accountid"}">{dbo_echo dbo="domaindbo_table" field="accountname"}</a>
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
