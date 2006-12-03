<ul id="tabnav">
  {dbo_assign dbo="server_dbo" field="id" var="id"}
  <li class="selected"> <a href="manager_content.php?page=services_view_server&server={$id}&action=info"> {echo phrase="SERVER_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=ips"> {echo phrase="IP_ADDRESSES"} </a> </li>
  <li> <a href="manager_content.php?page=services_view_server&server={$id}&action=services"> {echo phrase="HOSTING_SERVICES"} </a> </li>
</ul>

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
