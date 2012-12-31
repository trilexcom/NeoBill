<div class="manager_content"</div>
<h2> {echo phrase="BILLING_SUMMARY"} </h2> 
  <div class="properties">
    <table style="width: 90%">
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="OUTSTANDING_INVOICES"} </a></th>
        <td> {$os_invoices_count}</a> </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_generate">{echo phrase="GENERATE_INVOICES"} </td>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="TOTAL_OUTSTANDING_INVOICES"} </a></th>
        <td> {$os_invoices_total|currency} </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="PAST_DUE_INVOICES"} </a></th>
        <td> {$os_invoices_count_past_due} </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="TOTAL_PAST_DUE"} </a></th>
        <td> {$os_invoices_total_past_due|currency} </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="30_DAYS_PAST_DUE"} </a></th>
        <td> {$os_invoices_count_past_due_30} </td>
      </tr> 
      <tr>
        <th> <a href="manager_content.php?page=billing_invoices_outstanding">{echo phrase="TOTAL_30_PAST_DUE"} </a></th>
        <td> {$os_invoices_total_past_due_30|currency} </td>
        <td class="action_cell"/>
      </tr> 
      <tr>
        <th> {echo phrase="PAYMENTS_RECEIVED"} {$month} </th>
        <td> {$payments_count} </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_add_payment">{echo phrase="ENTER_PAYMENT"}</a> </td>
      </tr>
      <tr>
        <th> {echo phrase="REVENUE_RECEIVED"} {$month} </th>
        <td> {$payments_total|currency} </td>
      </tr>
    </table>
  </div>

<h2> {echo phrase="ACCOUNTS_SUMMARY"} </h2>
<p/>
<div class="properties">
  <table style="width: 90%">
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
