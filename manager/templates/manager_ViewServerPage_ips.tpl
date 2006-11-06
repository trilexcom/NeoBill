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
  {form name="view_server_ips"}
    {form_table field="ips"}

      {form_table_column columnid=""}
        {form_table_checkbox option=$ips.ipaddress}
      {/form_table_column}

      {form_table_column columnid="ipaddressstring" header="[IP_ADDRESS]"}
        {$ips.ipaddressstring}
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ASSIGNED_TO]"}
        {if $ips.accountid < 1}
          [AVAILABLE]
        {else}
          <a href="manager_content.php?page=accounts_view_account&account={$ips.accountid}">{$ips.accountname}</a>
        {/if}
      {/form_table_column}

      {form_table_column columnid="service" header="[SERVICE]"}
        {$ips.service}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>