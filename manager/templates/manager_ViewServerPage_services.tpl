{dbo_assign dbo="server_dbo" var="serverid" field="id"}

<ul id="tabnav">
  {dbo_assign dbo="server_dbo" field="id" var="id"}
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=info"> {echo phrase="SERVER_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=ips"> {echo phrase="IP_ADDRESSES"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=services_view_server&server={$id}&action=services"> {echo phrase="HOSTING_SERVICES"} </a> </li>
</ul>

<h2> {echo phrase="HOSTING_SERVICES_ASSIGNED"} {dbo_echo dbo="server_dbo" field="hostname"} </h2>

<div class="table">
  {form name="view_server_services"}
    {form_table field="services"}

      {form_table_column columnid="title" header="[SERVICE_NAME]"}
        {$services.title}
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ACCOUNT]"}
        <a href="manager_content.php?page=accounts_view_account&account={$services.accountid}">{$services.accountname}</a>
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$services.term}
      {/form_table_column}

      {form_table_column columnid="date" header="[PURCHASED]"}
        {$services.date|datetime:date}
      {/form_table_column}

    {/form_table}
  {/form}
</div>