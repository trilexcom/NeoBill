<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="outstanding_invoices_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="OUTSTANDING_INVOICES"} </h2>

<div class="search">
  {form name="search_outstanding_invoicedbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
        <td>
          {form_description field="account"} <br/>
          {form_element field="account" nulloption="true"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="outstanding_invoices"}
    {form_table field="invoices" size="10"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="./manager_content.php?page=billing_view_invoice&invoice={$invoices.id}">{$invoices.id}</a>
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ACCOUNT]"}
        <a href="./manager_content.php?page=accounts_view_account&account={$invoices.accountid}">{$invoices.accountname}</a>
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