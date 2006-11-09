<div class="action">
  <p class="header">Actions</p>
  {form name="browse_invoices_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="INVOICES"} </h2>

<div class="search">
  {form name="search_invoices"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="accountname"} <br/>
          {form_element field="accountname" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="browse_invoices"}
    {form_table field="invoices" size="10"}

      {form_table_column columnid="id" header="[ID]"}
        <a href="./manager_content.php?page=billing_view_invoice&invoice={$invoices.id}">{$invoices.id}</a>
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ACCOUNT]"}
        <a href="./manager_content.php?page=accounts_view_account&account={$invoices.id}">{$invoices.accountname}</a>
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
