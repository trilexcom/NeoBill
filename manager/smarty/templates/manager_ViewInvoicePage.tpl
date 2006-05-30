{dbo_assign dbo="invoice_dbo" var="invoice_id" field="id"}

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_invoice_action"}
    <input type="button" value="Print" onClick="window.open('manager_content.php?page=billing_print_invoice&id={$invoice_id}&no_headers=1','Print Invoice')"/>
    {form_element field="email"}
    {form_element field="delete"}
    {form_element field="add_payment"}
  {/form}
</div>

<h2> {echo phrase="INVOICE"} #{$invoice_id}</h2>

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
  </table>
</div>

<div class="table">
  {dbo_table dbo_class="InvoiceItemDBO" 
             filter="invoiceid=$invoice_id" 
             name="itemdbo_table" 
             sortby="id"
             sortdir="ASEC"
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

    {dbo_table_column header="[ACTION]"}
      <a href="manager_content.php?page=billing_view_invoice&action=delete_item&itemid={dbo_echo dbo="itemdbo_table" field="id"}">remove</a>
    {/dbo_table_column}

  {/dbo_table}
</div>

<div class="form">
  {form name="new_line_item"}
    <table style="width: 100%">
      <tr>
        <th style="width: 50%"> {form_description field="text"} </th>
        <th style="width: 25%"> {form_description field="unitamount"} </th>
        <th style="width: 25%"> {form_description field="quantity"} </th>
      </tr>
      <tr>
        <td style="width: 50%"> {form_element field="text" size="50"} </td>
        <td style="width: 25%"> {form_element field="unitamount" size="7"} </td>
        <td style="width: 25%"> {form_element field="quantity" size="3"} </td>
      </tr>
      <tr class="footer">
        <th colspan="3"> {form_element field="continue"} </th>
      </tr>
    </table>
  {/form}
</div>

<h2> Payments </h2>

<div class="table">
  {dbo_table dbo_class="PaymentDBO" 
             filter="invoiceid=$invoice_id" 
             name="paymentdbo_table" 
             title="[PAYMENTS]"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a href="manager_content.php?page=edit_payment&id={dbo_echo dbo="paymentdbo_table" field="id"}">{dbo_echo dbo="paymentdbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[DATE_RECEIVED]" sort_field="date"}
      {dbo_echo|datetime:date dbo="paymentdbo_table" field="date"}
    {/dbo_table_column}

    {dbo_table_column header="[AMOUNT]" sort_field="amount"}
      {dbo_echo|currency dbo="paymentdbo_table" field="amount"}
    {/dbo_table_column}

    {dbo_table_column header="[PAYMENT_TYPE]" sort_field="type"}
      {dbo_echo dbo="paymentdbo_table" field="type"}
    {/dbo_table_column}

    {dbo_table_column header="[ACTIONS]"}
      <a href="manager_content.php?page=billing_view_invoice&action=delete_payment&paymentid={dbo_echo dbo="paymentdbo_table" field="id"}">remove</a>
    {/dbo_table_column}

  {/dbo_table}
</div>
