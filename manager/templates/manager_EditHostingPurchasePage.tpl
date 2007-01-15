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

{form name="edit_hosting_purchase"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [EDIT_HOSTING_SERVICE_PURCHASE] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left">
             {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="save"}
          </td>
        </tr>
      </tfoot>
      <tbody>
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
        </tr>
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
        <tr>
          <th> {form_description field="note"} </th>
          <td> {form_element field="note" value=$purchaseDBO->getNote() rows=4 cols=50} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}