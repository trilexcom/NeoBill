{dbo_assign dbo="server_dbo" var="serverid" field="id"}

<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXCommon.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar_start.js"></script>

{if $tab != null}
  <script type="text/javascript">
    var activeTab = "{$tab}";
  </script>
{/if}
<div class="manager_content"
<div id="a_tabbar" 
     class="dhtmlxTabBar" 
     style="margin-top: 0.5em;"  
     imgpath="../include/dhtmlxTabbar/imgs/"
     skinColors="#FFFFFF,#F4F3EE">

  <div id="info" name="[SERVER_INFO]" width="80">
    <h2> {echo phrase="SERVER_INFORMATION"} </h2>

    <div class="properties">
      <table>
        <tr>
          <th> {echo phrase="HOSTNAME"}: </th>
          <td> {dbo_echo dbo="server_dbo" field="hostname"} </td>
        </tr>
        <tr>
          <th> {echo phrase="LOCATION"}: </th>
          <td> {dbo_echo dbo="server_dbo" field="location"} </td>
        </tr>
        <tr>
          <th> [CONTROL_PANEL_MODULE]: </th>
          <td> 
            {dbo_assign dbo="server_dbo" field="cpmodule" var="cpmodule"} 
            {if $cpmodule != null}
              {$cpmodule} (<a href="manager_content.php?page={$ServerConfigPage}&server={$id}">[CONFIGURE]</a>)
            {else}
              [NONE]
            {/if}
          </td>
        </tr>
        <tr class="footer">
           <td colspan="2">
             {form name="view_server"}
               {form_element field="edit"}
               {form_element field="delete"}
             {/form}
           </td>
        </tr>
      </table>
    </div>
  </div>

  <div id="ips" name="[IP_ADDRESSES]" width="80">
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
  </div>

  <div id="services" name="[HOSTING_SERVICES]" width="160">
    <h2> {echo phrase="HOSTING_SERVICES_ASSIGNED"} {dbo_echo dbo="server_dbo" field="hostname"} </h2>

    <div class="table">
      {form name="view_server_services"}
        {form_table field="services"}

          {form_table_column columnid="title" header="[SERVICE_NAME]"}
            {$services.title}
          {/form_table_column}

          {form_table_column columnid="accountname" header="[ACCOUNT]"}
            <a href="manager_content.php?page=accounts_view_account&account={$services.id}">{$services.accountname}</a>
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
  </div>

</div>
