{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&action=billing"> {echo phrase="BILLING"} </a> </li>
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
  {dbo_table dbo_class="InvoiceDBO" 
             filter="accountid=$account_id" 
             name="invoicedbo_table" 
             title="[INVOICES]" 
             size="10"
             url="&action=billing"}
  
    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="./manager_content.php?page=billing_view_invoice&id={dbo_echo dbo="invoicedbo_table" field="id"}">{dbo_echo dbo="invoicedbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[INVOICE_DATE]" sort_field="date"}
      {dbo_echo|datetime:date dbo="invoicedbo_table" field="date"}
    {/dbo_table_column}

    {dbo_table_column header="[BILLING_PERIOD]" sort_field="periodbegin"}
      {dbo_echo|datetime:date dbo="invoicedbo_table" field="periodbegin"} -
      {dbo_echo|datetime:date dbo="invoicedbo_table" field="periodend"}
    {/dbo_table_column}

    {dbo_table_column header="[INVOICE_TOTAL]"}
      {dbo_echo|currency dbo="invoicedbo_table" field="total"}
    {/dbo_table_column}

    {dbo_table_column header="[AMOUNT_PAID]"}
      {dbo_echo|currency dbo="invoicedbo_table" field="totalpayments"}
    {/dbo_table_column}

    {dbo_table_column header="[AMOUNT_DUE]"}
      {dbo_echo|currency dbo="invoicedbo_table" field="balance"}
    {/dbo_table_column}

  {/dbo_table}
</div>
