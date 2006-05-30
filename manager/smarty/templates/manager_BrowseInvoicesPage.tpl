<div class="action">
  <p class="header">Actions</p>
  {form name="browse_invoices_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="INVOICES"} </h2>

<div class="search">
  {form name="search_invoicedbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
        <td>
          {form_description field="accountid"} <br/>
          {form_element field="accountid" size="4"}
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
             name="invoicedbo_table" 
             title="[INVOICES]" 
             size="10"}
  
    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="./manager_content.php?page=billing_view_invoice&id={dbo_echo dbo="invoicedbo_table" field="id"}">{dbo_echo dbo="invoicedbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT]" sort_field="accountid"}
      <a href="./manager_content.php?page=accounts_view_account&id={dbo_echo dbo="invoicedbo_table" field="accountid"}">{dbo_echo dbo="invoicedbo_table" field="accountname"}</a>
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
