{if $serverDBO != null && $serverDBO->getCPModule() != null}
  {form name="edit_hosting_purchase_action"}
    <div class="action">
      <p class="header_long">[SERVER_CONTROL_PANEL_ACTIONS]</p>
      {form_element field="createaccount"}
      {form_element field="suspendaccount"}
      {form_element field="unsuspendaccount"}
      {form_element field="killaccount"}
    </div>
  {/form}
{/if}

<h2> [EDIT_HOSTING_SERVICE_PURCHASE] </h2>

{form name="edit_hosting_purchase"}
  <div class="form">
    <table>
      <tr>
        <th> [ACCOUNT]: </th>
        <td> {$purchaseDBO->getAccountName()} </td>
      </tr>
      <tr>
        <th> [HOSTING_SERVICE]: </th>
        <td> {$purchaseDBO->getTitle()} </td>
      </tr>
      <tr>
        <th> [PURCHASED]: </th>
        <td> {$purchaseDBO->getDate()|datetime:date} </td>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element field="term" value=$purchaseDBO->getTermID()} </td>
      </tr>
      <tr>
        <th> {form_description field="nextbillingdate"} </th>
        <td> {form_element field="nextbillingdate" value=$purchaseDBO->getNextBillingDate()} </td>
      </tr>
      <tr>
        <th> {form_description field="server"} </th>
        <td> {form_element field="server" value=$purchaseDBO->getServerID() nulloption="true"}
      </tr>
      {assign var="domainIsRequired" value=$purchaseDBO->isDomainRequired()}
      {if $domainIsRequired}
        <tr>
          <th> {form_description field="domain"} </th>
          <td> {form_element field="domain" value=$purchaseDBO->getDomainName()}
        </tr>
      {/if}
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"} {form_element field="cancel"}
        </td>
      </tr>
    </table>
  </div>
{/form}