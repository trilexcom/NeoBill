{dbo_assign dbo="server_dbo" var="serverid" field="id"}

<ul id="tabnav">
  {dbo_assign dbo="server_dbo" field="id" var="id"}
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=info"> {echo phrase="SERVER_INFO"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=services_view_server&server={$id}&action=ips"> {echo phrase="IP_ADDRESSES"} </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=services"> {echo phrase="HOSTING_SERVICES"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_server_add_ip"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="IP_ADDRESSES_FOR"} {dbo_echo dbo="server_dbo" field="hostname"} </h2>

<div class="table">
  {dbo_table dbo_class="IPAddressDBO"
             name="ipaddressdbo_table"
             title="[IP_ADDRESSES]"
             filter="serverid=$serverid"
             size="25"}

    {dbo_table_column header="[IP_ADDRESS]" sort_field="ip"}
      {dbo_echo dbo="ipaddressdbo_table" field="ipstring"}
    {/dbo_table_column}

    {dbo_table_column header="[ASSIGNED_TO]"}
      {dbo_assign dbo="ipaddressdbo_table" var="accountid" field="accountid"}
      {if $accountid < 1}
        Available
      {else}
        <a href="manager_content.php?page=accounts_view_account&id={$accountid}">{dbo_echo dbo="ipaddressdbo_table" field="accountname"}</a>
      {/if}
    {/dbo_table_column}

    {dbo_table_column header="[SERVICE]"}
      {dbo_echo dbo="ipaddressdbo_table" field="servicetitle"}
    {/dbo_table_column}

    {dbo_table_column header="[ACTION]"}
      <a href="manager_content.php?page=services_view_server&server={$serverid}&action=delete_ip&ip={dbo_echo dbo="ipaddressdbo_table" field="ip"}">remove</a>
    {/dbo_table_column}

  {/dbo_table}

</div>
