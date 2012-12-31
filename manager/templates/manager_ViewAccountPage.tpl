
<div class="manager_content">

<div id="tabs">
	<ul>		
<li><a href="#tabs-1">Account Information</a></li>
<li><a href="#tabs-2">Notes</a></li>
<li><a href="#tabs-3">Hostings</a></li>
<li><a href="#tabs-4">Domains</a></li>
<li><a href="#tabs-5">Products</a></li>
<li><a href="#tabs-6">Billing</a></li>
	</ul>

<div id="tabs-1">
<div id="info" name="[ACCOUNT_INFO]">
    {form name="view_account_action"}
      <h2> {echo phrase="ACCOUNT_INFORMATION"} </h2>
      <div class="properties">
        <table>
          <tr>
            <th> {echo phrase="ACCOUNT_ID"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="id"} </td>
            <td class="action_cell">&raquo; <a href="manager_content.php?page=accounts_welcome&account={$account_id}">{echo phrase="SEND_WELCOME_EMAIL"}</a> </td>
          </tr>
          <tr>
            <th> {echo phrase="ACCOUNT_NAME"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="accountname"} </td>
          </tr>
          <tr>
            <th> {echo phrase="ACCOUNT_TYPE"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="type"} </td>
          </tr>
          <tr>
            <th> [USERNAME]: </th>
            <td> <a href="manager_content.php?page=config_edit_user&user={dbo_echo dbo="account_dbo" field="username"}">{dbo_echo dbo="account_dbo" field="username"}</a> </td>
          </tr>
          <tr>
            <th> {echo phrase="ACCOUNT_STATUS"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="status"} </td>
          </tr>
          <tr>
            <th> {echo phrase="BILLING_STATUS"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="billingstatus"} </td>
          </tr>
          <tr>
            <th> {echo phrase="BILLING_DAY"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="billingday"} </td>
          </tr>
          <tr>
            <th> {echo phrase="CONTACT_NAME"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="contactname"} </td>
          </tr>
          <tr>
            <th> {echo phrase="CONTACT_EMAIL"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="contactemail"} </td>
          </tr>
          <tr>
            <th> {echo phrase="ADDRESS"}: </th>
            <td>
              {dbo_echo dbo="account_dbo" field="address1"} <br/>
              {dbo_echo dbo="account_dbo" field="address2"} <br/>
            </td>
          </tr>
          <tr> 
            <th> {echo phrase="CITY"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="city"} </td>
          </tr>
          <tr>
            <th> {echo phrase="STATE"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="state"} </td>
          </tr>
          <tr>
            <th> {echo phrase="ZIP_POSTAL_CODE"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="postalcode"} </td>
          </tr>
          <tr>
            <th> {echo phrase="COUNTRY"}: </th>
            <td> {dbo_echo|country dbo="account_dbo" field="country"} </td>
          </tr>
          <tr>
            <th> {echo phrase="PHONE"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="phone"} </td>
          </tr>
          <tr>
            <th> {echo phrase="MOBILE_PHONE"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="mobilephone"} </td>
          </tr>
          <tr>
            <th> {echo phrase="FAX"}: </th>
            <td> {dbo_echo dbo="account_dbo" field="fax"} </td>
          </tr>
          <tr class="footer">
            <th class="footer"> 
              {form_element field="edit"}
              {form_element field="delete"}
            </th>
            <td/>
          </tr>
        </table>
      </div>
    {/form}
</div>
</div>

<div id="tabs-2">
    {form name="view_account_note"}
      <h2> {echo phrase="NOTES"} </h2>
      <div class="table">
        {form_table field="notes"}

          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$notes.id} </center>
          {/form_table_column}

          {form_table_column columnid="updated" header="[POSTED]"}
            [BY]: {$notes.username} <br/>
            {$notes.updated|datetime}
          {/form_table_column}

          {form_table_column columnid="text" header="[NOTE]"}
            {$notes.text}
          {/form_table_column}

          {form_table_footer}
            {form_element field="remove"}
          {/form_table_footer}
      
        {/form_table}
      </div>
    {/form}
    {form name="view_account_add_note"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ADD_NOTE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left"/>
              <td class="right"> {form_element field="add"} </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="text"} </th>
              <td> {form_element field="text" cols="45" rows="5"} </td>
            </tr>
          </tbody>
        </table>         
      </div>
    {/form}


</div>

<div id="tabs-3">

  <div id="hosting" name="[WEB_HOSTING_SERVICES] ({$hosting_count})">
    <div class="action">
      <p class="header">{echo phrase="ACTIONS"}</p>
      {form name="view_account_hosting"}
        {form_element field="add"}
      {/form}
    </div>


    <h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
    <div class="table">
      {form name="hosting_purchases"}
        {form_table field="services"}

          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$services.id} </center>
          {/form_table_column}

          {form_table_column columnid="title" header="[SERVICE_NAME]"}
            <a href="manager_content.php?page=edit_hosting_purchase&hspurchase={$services.id}">{$services.title}</a>
          {/form_table_column}

          {form_table_column columnid="domainname" header="[DOMAIN]"}
            {$services.domainname}
          {/form_table_column}

          {form_table_column columnid="term" header="[TERM]"}
            {$services.term} [MONTHS]
          {/form_table_column}

          {form_table_column columnid="hostname" header="[SERVER]"}
            {if $services.serverid < 1}
              {$services.hostname}
            {else}
              <a href="manager_content.php?page=services_view_server&server={$services.serverid}">{$services.hostname}</a>
            {/if}
          {/form_table_column}

          {form_table_column columnid="date" header="[PURCHASED]"}
            {$services.date|datetime:date}
          {/form_table_column}

          {form_table_column columnid="nextbillingdate" header="[NEXT_BILLING_DATE]"}
            {$services.nextbillingdate|datetime:date}
          {/form_table_column}

          {form_table_footer}
            {form_element field="remove"}
          {/form_table_footer}

        {/form_table}
      {/form}
    </div>
  </div>
</div>

<div id="tabs-4">
  <div id="domains" name="[DOMAINS] ({$domain_count})">
    <div class="action">
      <p class="header">{echo phrase="ACTIONS"}</p>
      {form name="view_account_domains"}
        {form_element field="add"}
      {/form}
    </div>

    <h2> {echo phrase="DOMAINS"} </h2>
    <div class="table">
      {form name="domain_purchases"}
        {form_table field="domains"}

          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$domains.id} </center>
          {/form_table_column}

          {form_table_column columnid="fulldomainname" header="[DOMAIN_NAME]"}
            <a href="manager_content.php?page=domains_edit_domain&dpurchase={$domains.id}">{$domains.fulldomainname}</a>
          {/form_table_column}

          {form_table_column columnid="term" header="[TERM]"}
            {$domains.term} [MONTHS]
          {/form_table_column}

          {form_table_column columnid="date" header="[PURCHASED]"}
            {$domains.date|datetime:date}
          {/form_table_column}

          {form_table_column columnid="expiredate" header="[EXPIRES]"}
            {$domains.expiredate|datetime:date}
          {/form_table_column}

          {form_table_column columnid="nextbillingdate" header="[NEXT_BILLING_DATE]"}
            {$domains.nextbillingdate|datetime:date}
          {/form_table_column}

          {form_table_footer}
            {form_element field="remove"}
          {/form_table_footer}

        {/form_table}
      {/form}
    </div>

  </div>

</div>


<div id="tabs-5">
  <div id="products" name="[OTHER_PRODUCTS_SERVICES] ({$product_count})">
    <div class="action">
      <p class="header">{echo phrase="ACTIONS"}</p>
      {form name="view_account_products"}
        {form_element field="add"}
      {/form}
    </div>

    <h2> {echo phrase="OTHER_PRODUCTS"} </h2>
    <div class="table">
      {form name="product_purchases"}
        {form_table field="products"}
    
          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$products.id} </center>
          {/form_table_column}

          {form_table_column columnid="productname" header="[PRODUCT_NAME]"}
            <a href="manager_content.php?page=edit_product_purchase&ppurchase={$products.id}">{$products.productname}</a>
          {/form_table_column}

          {form_table_column columnid="term" header="[TERM]"}
            {if $products.term != 0}
              {$products.term} [MONTHS]
            {else}
              [N/A]
            {/if}
          {/form_table_column}

          {form_table_column columnid="date" header="[DATE]"}
            {$products.date|datetime:date}
          {/form_table_column}

          {form_table_column columnid="nextbillingdate" header="[NEXT_BILLING_DATE]"}
            {$products.nextbillingdate|datetime:date}
          {/form_table_column}

          {form_table_footer}
            {form_element field="remove"}
          {/form_table_footer}

        {/form_table}
      {/form}
    </div>

  </div>
</div>

<div id="tabs-6">

  <div id="billing" name="[BILLING]">
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

  </div>
</div>

</div>
</div>
