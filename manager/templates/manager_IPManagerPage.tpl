<h2>{echo phrase="IP_ADDRESS_POOL"}</h2>
<div class="table">
  {form name="ippool"}
    {form_table field="ipaddresses" size="20"}

      {form_table_column columnid="ipaddress" header="[IP_ADDRESS]"}
        {$ipaddresses.ipaddressstring}
      {/form_table_column}

      {form_table_column columnid="server" header="[SERVER]"}
        <a href="manager_content.php?page=services_view_server&server={$ipaddresses.server}">{$ipaddresses.hostname}</a>
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ASSIGNED_TO]"}
        {if $ipaddresses.isAvailable}
          [AVAILABLE]
        {else}
          <a href="manager_content.php?page=accounts_view_account&account={$ipaddresses.accountid}">{$ipaddresses.accountname}</a>
        {/if}
      {/form_table_column}

      {form_table_column columnid="service" header="[SERVICE]"}
        {if $ipaddresses.isAvailable}
          [N/A]
        {else}
          {$ipaddresses.service}
        {/if}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>
