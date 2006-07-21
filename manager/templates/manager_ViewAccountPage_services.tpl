{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_account_hosting"}
    {form_element field="add"}
  {/form}
</div>

  <h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
  <div class="table">
    {dbo_table dbo_class="HostingServicePurchaseDBO" 
               filter="accountid=$account_id" 
               name="hostingdbo_table" 
               title="[WEB_HOSTING_SERVICES]" 
               size="10"}

      {dbo_table_column header="[SERVICE_NAME]"}
        {dbo_echo dbo="hostingdbo_table" field="title"}
      {/dbo_table_column}

      {dbo_table_column header="[TERM]"}
        {dbo_echo dbo="hostingdbo_table" field="term"}
      {/dbo_table_column}

      {dbo_table_column header="[SERVER]"}
        {dbo_assign dbo="hostingdbo_table" var="serverid" field="serverid"}
        {if $serverid < 1}
          {dbo_echo dbo="hostingdbo_table" field="hostname"}
        {else}
          <a href="manager_content.php?page=services_view_server&id={dbo_echo dbo="hostingdbo_table" field="serverid"}">{dbo_echo dbo="hostingdbo_table" field="hostname"}</a>
        {/if}
      {/dbo_table_column}

      {dbo_table_column header="[PRICE]"}
        {dbo_echo|currency dbo="hostingdbo_table" field="price"}
      {/dbo_table_column}

      {dbo_table_column header="[PURCHASED]"}
        {dbo_echo|datetime:date dbo="hostingdbo_table" field="date"}
      {/dbo_table_column}

      {dbo_table_column header="[ACTION]"}
        <a href="manager_content.php?page=accounts_view_account&action=delete_hosting&purchase_id={dbo_echo dbo="hostingdbo_table" field="id"}">remove</a>
      {/dbo_table_column}

    {/dbo_table}

  </div>
