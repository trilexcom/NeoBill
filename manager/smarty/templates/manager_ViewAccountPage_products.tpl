{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li> <a href="manager_content.php?page=accounts_view_account&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="view_account_products"}
    {form_element field="add"}
  {/form}
</div>

  <h2> {echo phrase="OTHER_PRODUCTS"} </h2>
  <div class="table">
    {dbo_table dbo_class="ProductPurchaseDBO" 
               filter="accountid=$account_id" 
               name="productdbo_table" 
               title="[OTHER_PRODUCTS]" 
               size="10"}

      {dbo_table_column header="[PRODUCT_NAME]"}
        {dbo_echo dbo="productdbo_table" field="productname"}
      {/dbo_table_column}

      {dbo_table_column header="[NOTE]"}
        {dbo_echo dbo="productdbo_table" field="note"}
      {/dbo_table_column}

      {dbo_table_column header="[PURCHASED]"}
        {dbo_echo|datetime:date dbo="productdbo_table" field="date"}
      {/dbo_table_column}

      {dbo_table_column header="[ACTION]"}
        <a href="manager_content.php?page=accounts_view_account&action=delete_product&purchase_id={dbo_echo dbo="productdbo_table" field="id"}">remove</a>
      {/dbo_table_column}

    {/dbo_table}

  </div>
