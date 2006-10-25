{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_account_domains"}
    {form_element field="add"}
  {/form}
</div>

  <h2> {echo phrase="DOMAINS"} </h2>
  <div class="table">
    {dbo_table dbo_class="DomainServicePurchaseDBO" 
               filter="accountid=$account_id" 
               name="domainservicedbo_table" 
               title="[DOMAINS]" 
               size="10"}

      {dbo_table_column header="[DOMAIN_NAME]"}
        <a href="manager_content.php?page=domains_edit_domain&id={dbo_echo dbo="domainservicedbo_table" field="id"}">{dbo_echo dbo="domainservicedbo_table" field="fulldomainname"}</a>
      {/dbo_table_column}

      {dbo_table_column header="[TERM]"}
        {dbo_echo dbo="domainservicedbo_table" field="term"}
      {/dbo_table_column}

      {dbo_table_column header="[PURCHASED]"}
        {dbo_echo|datetime:date dbo="domainservicedbo_table" field="date"}
      {/dbo_table_column}

      {dbo_table_column header="[EXPIRES]"}
        {dbo_echo|datetime:date dbo="domainservicedbo_table" field="expiredate"}
      {/dbo_table_column}

      {dbo_table_column header="[ACTION]"}
        <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=delete_domain&dpurchase={dbo_echo dbo="domainservicedbo_table" field="id"}">remove</a>
      {/dbo_table_column}

    {/dbo_table}

  </div>
