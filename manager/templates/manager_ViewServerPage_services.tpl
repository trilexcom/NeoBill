{dbo_assign dbo="server_dbo" var="serverid" field="id"}

<ul id="tabnav">
  {dbo_assign dbo="server_dbo" field="id" var="id"}
  <li> <a href="manager_content.php?page=services_view_server&id={$id}&action=info"> {echo phrase="SERVER_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&id={$id}&action=ips"> {echo phrase="IP_ADDRESSES"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=services_view_server&id={$id}&action=services"> {echo phrase="HOSTING_SERVICES"} </a> </li>
</ul>

<h2> {echo phrase="HOSTING_SERVICES_ASSIGNED"} {dbo_echo dbo="server_dbo" field="hostname"} </h2>

<div class="table">
  {dbo_table dbo_class="HostingServicePurchaseDBO"
             name="servicedbo_table"
             title="[HOSTING_SERVICES]"
             filter="serverid=$serverid"
             size="25"}

      {dbo_table_column header="[SERVICE_NAME]"}
        {dbo_echo dbo="servicedbo_table" field="title"}
      {/dbo_table_column}

      {dbo_table_column header="[ACCOUNT]"}
        <a href="manager_content.php?page=accounts_view_account&id={dbo_echo dbo="servicedbo_table" field="accountid"}">{dbo_echo dbo="servicedbo_table" field="accountname"}</a>
      {/dbo_table_column}

      {dbo_table_column header="[TERM]"}
        {dbo_echo dbo="servicedbo_table" field="term"}
      {/dbo_table_column}

      {dbo_table_column header="[PURCHASED]"}
        {dbo_echo|datetime:date dbo="servicedbo_table" field="date"}
      {/dbo_table_column}

  {/dbo_table}

</div>
