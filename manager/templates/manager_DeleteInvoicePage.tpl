{dbo_assign dbo="invoice_dbo" var="invoice_id" field="id"}

<p class="message">
  {echo phrase="DELETE_INVOICE"}
</p>

<h2> {echo phrase="INVOICE"} #{$invoice_id}</h2>

{form name="delete_invoice"}
  <div class="properties">
    <table>
      <tr>
        <th> {echo phrase="ACCOUNT"}: </th>
        <td> {dbo_echo dbo="invoice_dbo" field="accountname"} (ID: {dbo_echo dbo="invoice_dbo" field="accountid"})</td>
      </tr>
      <tr>
        <th> {echo phrase="PERIOD"}: </th>
        <td> 
          {dbo_echo|datetime:date dbo="invoice_dbo" field="periodbegin"} -
          {dbo_echo|datetime:date dbo="invoice_dbo" field="periodend"}
        </td>
      </tr>
      <tr>
       <th> {echo phrase="AMOUNT_DUE"}: </th>
        <td> {dbo_echo|currency dbo="invoice_dbo" field="balance"} </td>
      </tr>
      <tr>
        <th> {echo phrase="INVOICE_DATE"}: </th>
        <td> {dbo_echo|datetime:date dbo="invoice_dbo" field="date"} </td>
     </tr>
      <tr>
        <th> {echo phrase="INVOICE_TOTAL"}: </th>
        <td> {dbo_echo|currency dbo="invoice_dbo" field="total"} </td>
      </tr>
      <tr>
        <th> {echo phrase="NOTE_TO_CUSTOMER"}: </th>
        <td> {dbo_echo dbo="invoice_dbo" field="note"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="delete"}
          {form_element field="cancel"}
        </td>
      </tr>
    </table>
  </div>
{/form}

<div class="table">
  {dbo_table dbo_class="InvoiceItemDBO" 
             filter="invoiceid=$invoice_id" 
             name="itemdbo_table" 
             title="[LINE_ITEMS]"}

    {dbo_table_column header="[ITEM]" sort_field="text"}
      {dbo_echo dbo="itemdbo_table" field="text"}
    {/dbo_table_column}

    {dbo_table_column header="[UNIT_PRICE]" sort_field="unitamount"}
      {dbo_echo|currency dbo="itemdbo_table" field="unitamount"}
    {/dbo_table_column}

    {dbo_table_column header="[QUANTITY]" sort_field="quantity"}
      {dbo_echo dbo="itemdbo_table" field="quantity"}
    {/dbo_table_column}

    {dbo_table_column header="[TOTAL]"}
      {dbo_echo|currency dbo="itemdbo_table" field="amount"}
    {/dbo_table_column}

  {/dbo_table}
</div>
