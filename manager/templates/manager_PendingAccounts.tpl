<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="pending_accounts_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="PENDING_ACCOUNTS"} </h2>
<div class="search">
  {form name="search_pending_accountdbo_table"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="id"} <br/>
          {form_element field="id" size="4"}
        </td>
        <td>
          {form_description field="contactname"} <br/>
          {form_element field="contactname" size="30"}
        </td>
        <td>
          {form_description field="businessname"} <br/>
          {form_element field="businessname" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="pending_accounts"}
    {form_table field="accounts" size="10"}

      {form_table_column columnid="id" header="[ID]"}
        <a target="content" href="manager_content.php?page=accounts_view_account&account={$accounts.id}">{$accounts.id}</a>
      {/form_table_column}

      {form_table_column columnid="accountname" header="[ACCOUNT_NAME]"}
        <a target="content" href="manager_content.php?page=accounts_view_account&account={$accounts.id}">{$accounts.accountname}</a>
      {/form_table_column}

      {form_table_column columnid="type" header="[TYPE]"}
        {$accounts.type}
      {/form_table_column}

      {form_table_column columnid="billingstatus" header="[BILL]"}
        {$accounts.billingstatus}
      {/form_table_column}

      {form_table_column columnid="balance" header="[BALANCE]"}
        {$accounts.balance|currency}
      {/form_table_column}

    {/form_table}
  {/form}
</div>