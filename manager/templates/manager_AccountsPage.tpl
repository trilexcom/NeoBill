<h2>{echo phrase="ACCOUNTS_SUMMARY"}</h2>
<div class="search">
  {form name="search_accountdbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
        <td>
          {form_description field="contactname"} <br/>
          {form_element field="contactname" size="30"}
        </td>
        <td>
          {form_description field="businessname"} <br/>
          {form_element field="businessname" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>
<p/>
<div class="properties">
  <table width="90%">
    <tr>
      <th> {echo phrase="ACTIVE_ACCOUNTS"} </th>
      <td> <a href="manager_content.php?page=accounts_browse">{$active_accounts_count}</a> </td>
      <td class="action_cell"> &raquo; <a href="manager_content.php?page=accounts_new_account">{echo phrase="CREATE_NEW_ACCOUNT"}</a> </td>
    </tr>
    <tr>
      <th> {echo phrase="INACTIVE_ACCOUNTS"} </th>
      <td> <a href="manager_content.php?page=accounts_browse_inactive">{$inactive_accounts_count}</a> </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> {echo phrase="ALL_ACCOUNTS"} </th>
      <td> {$total_accounts} </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> {echo phrase="PENDING_ACCOUNTS"} </th>
      <td> <a href="manager_content.php?page=accounts_browse_pending">{$pending_accounts_count}</a> </td>
      <td class="action_cell"/>
    </tr>
  </table>
</div>
