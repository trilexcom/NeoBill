{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

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
        {$products.productname}
      {/form_table_column}

      {form_table_column columnid="note" header="[NOTE]"}
        {$products.note}
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