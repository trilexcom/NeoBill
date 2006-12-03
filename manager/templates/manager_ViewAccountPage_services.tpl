{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_account_hosting"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
<div class="table">
  {form name="hosting_purchases"}
    {form_table field="services"}

      {form_table_column columnid=""}
        <center> {form_table_checkbox option=$services.id} </center>
      {/form_table_column}

      {form_table_column columnid="id" header="[ID]"}
        <center>
          <a href="manager_content.php?page=edit_hosting_purchase&hspurchase={$services.id}">{$services.id}</a>
        </center>
      {/form_table_column}

      {form_table_column columnid="title" header="[SERVICE_NAME]"}
        {$services.title}
      {/form_table_column}

      {form_table_column columnid="domainname" header="[DOMAIN]"}
        {$services.domainname}
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$services.term} [MONTHS]
      {/form_table_column}

      {form_table_column columnid="hostname" header="[SERVER]"}
        {if $services.serverid < 1}
          {$services.hostname}
        {else}
          <a href="manager_content.php?page=services_view_server&server={$services.serverid}">{$services.hostname}</a>
        {/if}
      {/form_table_column}

      {form_table_column columnid="date" header="[PURCHASED]"}
        {$services.date|datetime:date}
      {/form_table_column}

      {form_table_column columnid="nextbillingdate" header="[NEXT_BILLING_DATE]"}
        {$services.nextbillingdate|datetime:date}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>