<script type="text/javascript" src="javascript/purchasehostingpage.js"></script>

{form name="purchasehosting"}
  <div id="purchaseoption" class="domainoption">
    <table>
    </table>
  </div>

  <div name="hostingoption" class="domainoption">
    <table>
      <tr class="reverse">
        <th colspan="2"> [PLEASE_SELECT_A_HOSTING_OPTION]: </th>
      </tr>
      <tr>
        <td> {form_description field="hostingservice"}</td>
        <td> {form_element field="hostingservice" onchange="submit()"} </td>
      </tr>
      <tr>
        <td> {form_description field="hostingterm"}</td>
        <td> {form_element field="hostingterm"} </td>
      </tr>
    </table>
  </div>
  
  <p/>

  {if $serviceDBO->isDomainRequired()}
    <div name="domainoption" class="domainoption">
      <table name="domainoption">
        <tr class="reverse">
          <th colspan="2"> [PLEASE_SELECT_A_DOMAIN_OPTION]: </th>
        </tr>
        <tr>
          <td> {form_element field="domainoption" id="New" option="New" onchange="showDomainBox()"} </td>
        </tr>
        <tr>
          <td> {form_element field="domainoption" id="Transfer" option="Transfer" onchange="showDomainBox()"} </td>
        </tr>
        <tr>
          <td> {form_element field="domainoption" id="InCart" option="InCart" onchange="showDomainBox()"} </td>
        </tr>
        <tr>
          <td> {form_element field="domainoption" id="Existing" option="Existing" onchange="showDomainBox()"} </td>
        </tr>
        <tr>
          <td class="indent"> 
            <div id="newdomain" class="form">
              <table>
                <tr>
                  <th> [REGISTER_NEW_DOMAIN]: </th>
                  <td> {form_element field="registerdomainname" size="30"}.{form_element field="registerdomaintld" onchange="submit()"} </td>
                </tr>
                <tr>
                  <th> {form_description field="registerdomainterm"} </th>
                  <td> {form_element field="registerdomainterm"} </td>
                </tr>
              </table>
            </div>
            <div id="transferdomain" class="form">
              <table>
                <tr>
                  <th> [DOMAIN_TO_TRANSFER]: </th>
                  <td> {form_element field="transferdomainname" size="30"}.{form_element field="transferdomaintld" onchange="submit()"} </td>
                </tr>
                <tr>
                  <th> {form_description field="transferdomainterm"} </th>
                  <td> {form_element field="transferdomainterm"} </td>
                </tr>
              </table>
            </div>
            <div id="incartdomain" class="form">
              <table>
                <tr>
                  <th> {form_description field="incartdomain"} </th>
                  <td> {form_element field="incartdomain"} </td>
                </tr>
              </table>
            </div>
            <div id="existingdomain" class="form">
              <table>
                <tr>
                  <th> [YOUR_EXISTING_DOMAIN]: </th>
                  <td> {form_element field="existingdomainname" size="40"} </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
  {/if}

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

<script type="text/javascript">
  showDomainBox();
</script>