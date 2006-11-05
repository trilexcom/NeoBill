{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_account_billing_action"}
    {form_element field="add_invoice"}
    {form_element field="add_payment"}
  {/form}
</div>

<h2> {echo phrase="BILLING"} </h2>

<div class="properties">
  <table>
    <tr>
      <th> Billing Status: </th>
      <td> {dbo_echo dbo="account_dbo" field="billingstatus"} </td>
    </tr>
    <tr>
      <th> Billing Day </th>
      <td> {dbo_echo dbo="account_dbo" field="billingday"} </td>
    </tr>
    <tr>
      <th> Account Balance: </th>
      <td> {dbo_echo|currency dbo="account_dbo" field="balance"} </td>
    </tr>
  </table>
</div>

<div class="table">
  {form name="view_account_invoices"}
    {form_table field="invoices"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="./manager_content.php?page=billing_view_invoice&invoice={$invoices.id}">{$invoices.id}</a>
      {/form_table_column}

      {form_table_column columnid="date" header="[INVOICE_DATE]"}
        {$invoices.date|datetime:date}
      {/form_table_column}

      {form_table_column columnid="periodbegin" header="[BILLING_PERIOD]"}
        {$invoices.periodbegin|datetime:date} - {$invoices.periodend|datetime:date}
      {/form_table_column}

      {form_table_column columnid="total" header="[INVOICE_TOTAL]"}
        {$invoices.total|currency}
      {/form_table_column}

      {form_table_column columnid="totalpayments" header="[AMOUNT_PAID]"}
        {$invoices.totalpayments|currency}
      {/form_table_column}

      {form_table_column columnid="balance" header="[AMOUNT_DUE]"}
        {$invoices.balance|currency}
      {/form_table_column}

    {/form_table}
  {/form}
</div>