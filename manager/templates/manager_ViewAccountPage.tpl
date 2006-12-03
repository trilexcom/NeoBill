{dbo_assign dbo="account_dbo" var="account_id" field="id"}

<ul id="tabnav">
  <li class="selected"> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=account_info"> {echo phrase="ACCOUNT_INFO"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=services"> {echo phrase="WEB_HOSTING_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=domains"> {echo phrase="DOMAINS"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=products"> {echo phrase="OTHER_PRODUCTS_SERVICES"} </a> </li>
  <li> <a href="manager_content.php?page=accounts_view_account&account={$account_id}&action=billing"> {echo phrase="BILLING"} </a> </li>
</ul>

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
        <th> {echo phrase="COUNTRY"}: </th>
        <td> {dbo_echo|country dbo="account_dbo" field="country"} </td>
      </tr>
      <tr>
        <th> {echo phrase="ZIP_CODE"}: </th>
        <td> {dbo_echo dbo="account_dbo" field="postalcode"} </td>
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
    <table style="width: 500px">
      <tr>
        <th> {form_description field="text"} </th>
        <td> {form_element field="text" cols="45" rows="5"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2"> {form_element field="add"} </th>
      </tr>
    </table>         
    </div>

{/form}
