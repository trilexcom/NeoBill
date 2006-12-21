<script type="text/javascript" src="javascript/purchasedomainpage.js"></script>

{form name="purchasedomain"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th colspan="2"> [PURCHASE_A_DOMAIN] </th>
      </tr>
      <tr>
        <td> {form_element field="domainoption" id="New" option="New"} </td>
      </tr>
      <tr>
        <td> {form_element field="domainoption" id="Transfer" option="Transfer"} </td>
      </tr>
      <tr>
        <td class="indent"> 
          <div class="form">
            <table>
              <tr>
                <th> [DOMAIN_NAME]: </th>
                <td> {form_element field="domainname" size="30" value=$domain}.{form_element field="domaintld" onchange="submit()" value=$tld} </td>
              </tr>
              <tr>
                <th> {form_description field="domainterm"} </th>
                <td> {form_element field="domainterm"} </td>
              </tr>
            </table>
          </td>
        </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left">
          {if !$orderDBO->isEmpty()}
            {form_element field="cancel"}
          {/if}
        </td>
        <td class="right">
          {form_element field="continue"}
        </td>
      </tr>
    </table>
  </div>
{/form}