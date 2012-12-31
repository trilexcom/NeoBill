<div class="manager_content"</div>
<h2>{echo phrase="BILLING_SUMMARY"}</h2>
  <div class="properties">
    <table style="width: 90%">
      <tr>
        <th> {echo phrase="OUTSTANDING_INVOICES"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_count}</a> </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_generate">{echo phrase="GENERATE_INVOICES"}</a> </td>
      </tr>
      <tr>
        <th> {echo phrase="TOTAL_OUTSTANDING_INVOICES"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_total|currency}</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> {echo phrase="PAST_DUE_INVOICES"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_count_past_due}</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> {echo phrase="TOTAL_PAST_DUE"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_total_past_due|currency}</a> </td>
        <td class="action_cell"/>
      </tr>
      <tr>
        <th> {echo phrase="30_DAYS_PAST_DUE"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_count_past_due_30}</a> </td>
      </tr> 
      <tr>
        <th> {echo phrase="TOTAL_30_PAST_DUE"} </th>
        <td> <a href="manager_content.php?page=billing_invoices_outstanding">{$os_invoices_total_past_due_30|currency}</a> </td>
        <td class="action_cell"/>
      </tr> 
      <tr>
        <th> {echo phrase="PAYMENTS_RECEIVED"} {$month} </th>
        <td> {$payments_count} </td>
        <td class="action_cell">&raquo; <a href="manager_content.php?page=billing_add_payment">Enter Payment</a> </td>
      </tr>
      <tr>
        <th> {echo phrase="REVENUE_RECEIVED"} {$month} </th>
        <td> {$payments_total|currency} </td>
      </tr>
    </table>
  </div>
