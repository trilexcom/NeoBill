<h2>{echo phrase="PENDING_ORDERS"}</h2>

<div class="table">
  {dbo_table dbo_class="OrderDBO" 
             name="orderdbo_table"
             filter="status='Pending'"
             title="[PENDING_ORDERS]"
             size="10"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a target="content" href="manager_content.php?page=view_order&id={dbo_echo dbo="orderdbo_table" field="id"}">{dbo_echo dbo="orderdbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT]"}
      {dbo_echo dbo="orderdbo_table" field="accounttype"}
    {/dbo_table_column}

    {dbo_table_column header="[ORDER_DATE]"}
      {dbo_echo|datetime dbo="orderdbo_table" field="datecompleted"}
    {/dbo_table_column}

    {dbo_table_column header="[CUSTOMER]"}
      {dbo_echo dbo="orderdbo_table" field="contactname"}
    {/dbo_table_column}

    {dbo_table_column header="[ORDER_IP]"}
      {dbo_echo dbo="orderdbo_table" field="remoteipstring"}
    {/dbo_table_column}

    {dbo_table_column header="[ORDER_TOTAL]"}
      {dbo_echo|currency dbo="orderdbo_table" field="total"}
    {/dbo_table_column}

  {/dbo_table}
</div>
