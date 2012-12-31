<div class="manager_content"
<h2>{echo phrase="ACCOUNTS_SUMMARY"}</h2>
<p/>
<div class="properties">
  <table width="90%">
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse">{echo phrase="ACTIVE_ACCOUNTS"} </a></th>
      <td> {$active_accounts_count} </td>
      <td class="action_cell"> &raquo; <a href="manager_content.php?page=accounts_new_account">{echo phrase="CREATE_NEW_ACCOUNT"}</a> </td>
    </tr>
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse_inactive">{echo phrase="INACTIVE_ACCOUNTS"} </a></th>
      <td> {$inactive_accounts_count} </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> {echo phrase="ALL_ACCOUNTS"} </th>
      <td> {$total_accounts} </td>
      <td class="action_cell"/>
    </tr>
    <tr>
      <th> <a href="manager_content.php?page=accounts_browse_pending">{echo phrase="PENDING_ACCOUNTS"} </a></th>
      <td> {$pending_accounts_count} </td>
      <td class="action_cell"/>
    </tr>
  </table>
</div>
</div>
