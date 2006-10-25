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
  {dbo_table dbo_class="InvoiceDBO" 
             name="outstanding_invoicedbo_table" 
             title="[OUTSTANDING_INVOICES]" 
             size="10"
             filter="outstanding = 'yes'"}
  
    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="./manager_content.php?page=billing_view_invoice&invoice={dbo_echo dbo="outstanding_invoicedbo_table" field="id"}">{dbo_echo dbo="outstanding_invoicedbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT]" sort_field="accountid"}
      <a href="./manager_content.php?page=accounts_view_account&account={dbo_echo dbo="outstanding_invoicedbo_table" field="accountid"}">{dbo_echo dbo="outstanding_invoicedbo_table" field="accountname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[INVOICE_DATE]" sort_field="date"}
      {dbo_echo|datetime:date dbo="outstanding_invoicedbo_table" field="date"}
    {/dbo_table_column}

    {dbo_table_column header="[BILLING_PERIOD]" sort_field="periodbegin"}
      {dbo_echo|datetime:date dbo="outstanding_invoicedbo_table" field="periodbegin"} -
      {dbo_echo|datetime:date dbo="outstanding_invoicedbo_table" field="periodend"}
    {/dbo_table_column}

    {dbo_table_column header="[INVOICE_TOTAL]"}
      {dbo_echo|currency dbo="outstanding_invoicedbo_table" field="total"}
    {/dbo_table_column}

    {dbo_table_column header="[AMOUNT_PAID]"}
      {dbo_echo|currency dbo="outstanding_invoicedbo_table" field="totalpayments"}
    {/dbo_table_column}

    {dbo_table_column header="[AMOUNT_DUE]"}
      {dbo_echo|currency dbo="outstanding_invoicedbo_table" field="balance"}
    {/dbo_table_column}

  {/dbo_table}
</div>
