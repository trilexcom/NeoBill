<h2>{echo phrase="IP_ADDRESS_POOL"}</h2>
<div class="table">
  {dbo_table dbo_class="IPAddressDBO"
             name="ipaddressdbo_table"
             title="[IP_ADDRESS_POOL]"
             size="25"}

    {dbo_table_column header="[IP_ADDRESS]" sort_field="ip"}
      {dbo_echo dbo="ipaddressdbo_table" field="ipstring"}
    {/dbo_table_column}

    {dbo_table_column header="[SERVER]"}
      <a href="manager_content.php?page=services_view_server&id={dbo_echo dbo="ipaddressdbo_table" field="serverid"}">{dbo_echo dbo="ipaddressdbo_table" field="hostname"}</a>
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
      <a href="manager_content.php?page=services_ip_manager&action=remove_ip&ip={dbo_echo dbo="ipaddressdbo_table" field="ipstring"}">remove</a>
    {/dbo_table_column}

  {/dbo_table}
</div>
