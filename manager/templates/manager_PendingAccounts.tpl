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
  {dbo_table dbo_class="AccountDBO" 
             name="pending_accountdbo_table" 
             filter="status='Pending'" 
             title="[ACCOUNTS]"
             size="10"}

    {dbo_table_column header="[ID]" sort_field="id"}
      <a target="content" href="manager_content.php?page=accounts_view_account&id={dbo_echo dbo="pending_accountdbo_table" field="id"}">{dbo_echo dbo="pending_accountdbo_table" field="id"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[ACCOUNT_NAME]"}
      <a target="content" href="manager_content.php?page=accounts_view_account&id={dbo_echo dbo="pending_accountdbo_table" field="id"}">{dbo_echo dbo="pending_accountdbo_table" field="accountname"}</a>
    {/dbo_table_column}

    {dbo_table_column header="[BALANCE]"}
      {dbo_echo|currency dbo="pending_accountdbo_table" field="balance"}
    {/dbo_table_column}

    {dbo_table_column header="[STATUS]" sort_field="status"}
      {dbo_echo dbo="pending_accountdbo_table" field="status"}
    {/dbo_table_column}

  {/dbo_table}
</div>
