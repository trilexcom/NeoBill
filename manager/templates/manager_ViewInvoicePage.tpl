{dbo_assign dbo="invoice_dbo" var="invoice_id" field="id"}

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_invoice_action"}
    <input type="button" value="Print" onClick="window.open('manager_content.php?page=billing_print_invoice&invoice={$invoice_id}&no_headers=1','Print Invoice')"/>
    {form_element field="email"}
    {form_element field="delete"}
    {form_element field="add_payment"}
  {/form}
</div>

<h2> {echo phrase="INVOICE"} #{$invoice_id}</h2>
<table style="width: 100%">
  <tr>
    <td style="vertical-align: top">
      <div class="properties">
        <table style="width:350px">
          <tr>
            <th> {echo phrase="INVOICE_DATE"}: </th>
            <td> {dbo_echo|datetime:date dbo="invoice_dbo" field="date"} </td>
          </tr>
          <tr>
            <th> {echo phrase="PERIOD"}: </th>
            <td> 
              {dbo_echo|datetime:date dbo="invoice_dbo" field="periodbegin"} -
              {dbo_echo|datetime:date dbo="invoice_dbo" field="periodend"}
            </td>
          </tr>
          <tr>
            <th> {echo phrase="ACCOUNT"}: </th>
            <td> <a href="manager_content.php?page=accounts_view_account&account={dbo_echo dbo="invoice_dbo" field="accountid"}">{dbo_echo dbo="invoice_dbo" field="accountname"}</a> (ID: {dbo_echo dbo="invoice_dbo" field="accountid"})</td>
          </tr>
          <tr>
            <th> {echo phrase="NOTE_TO_CUSTOMER"}: </th>
            <td> {dbo_echo dbo="invoice_dbo" field="note"} </td>
          </tr>
        </table>
      </div>
    </td>
    <td>
      <div class="properties">
        <table style="width: 350px">
          <tr>
            <th> {echo phrase="SUB_TOTAL"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="subtotal"} </td>
          </tr>
          <tr>
            <th> {echo phrase="TAXES"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="taxtotal"} </td>
          </tr>
          <tr>
            <th> {echo phrase="INVOICE_TOTAL"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="total"} </td>
          </tr>
          <tr>
            <th> {echo phrase="PAYMENTS"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="totalpayments"} </td>
          </tr>
          <tr>
            <th> {echo phrase="INVOICE_BALANCE"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="balance"} </td>
          </tr>
          <tr>
            <th> {echo phrase="OUTSTANDING_BALANCE"}: </th>
            <td> {dbo_echo|currency dbo="invoice_dbo" field="outstandingbalance"} </td>
          </tr>
        </table>
      </div>
    </td>
  <tr>
</table>
<div class="table">
  {form name="view_invoice_items"}
    {form_table field="items"}

      {form_table_column columnid=""}
        <center> {form_table_checkbox option=$items.id} </center>
      {/form_table_column}

      {form_table_column columnid="text" header="[ITEM]"}
        {$items.text}
      {/form_table_column}

      {form_table_column columnid="unitamount" header="[UNIT_PRICE]"}
        {$items.unitamount|currency}
      {/form_table_column}

      {form_table_column columnid="quantity" header="[QUANTITY]"}
        {$items.quantity}
      {/form_table_column}

      {form_table_column columnid="amount" header="[TOTAL]"}
        {$items.amount|currency}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
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
  {form name="view_invoice_payments"}
    {form_table field="payments"}

      {form_table_column columnid=""}
        <center> {form_table_checkbox option=$payments.id} </center>
      {/form_table_column}

      {form_table_column columnid="id" header="[ID]"}
        <a href="manager_content.php?page=edit_payment&payment={$payments.id}">{$payments.id}</a>
      {/form_table_column}

      {form_table_column columnid="date" header="[DATE_RECEIVED]"}
        {$payments.date|datetime:date}
      {/form_table_column}

      {form_table_column columnid="amount" header="[AMOUNT]"}
        {$payments.amount|currency}
      {/form_table_column}

      {form_table_column columnid="type" header="[PAYMENT_TYPE]"}
        {$payments.type}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}
    
    {/form_table}
  {/form}
</div>

<h2> {echo phrase="OUTSTANDING_INVOICES"} </h2>
<div class="table">
  {form name="view_invoice_outstanding_invoices"}
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