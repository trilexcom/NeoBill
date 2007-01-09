{form name="repeat_customer"}
  <div class="domainoption">
  <table>
    <tr class="reverse"> <th> Account Information </th> </tr> <!-- hardcoded in english -->
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> {echo phrase="BUSINESS_NAME"}: </td>
              <td> {dbo_echo dbo="order" field="businessname"} </td>
            </tr>
            <tr>
              <td> {echo phrase="CONTACT_NAME"}: </td>
              <td> {dbo_echo dbo="order" field="contactname"} </td>
            </tr>
            <tr>
              <td> {echo phrase="ADDRESS"}: </td>
              <td> {dbo_echo dbo="order" field="address1"} </td>
            </tr>
            <tr>
              <td> </td>
              <td> {dbo_echo dbo="order" field="address2"} </td>
            </tr>
            <tr>
              <td> {echo phrase="CITY"}: </td>
              <td> {dbo_echo dbo="order" field="city"} </td>
            </tr>
            <tr>
              <td> {echo phrase="STATE"}: </td>
              <td> {dbo_echo dbo="order" field="state"} </td>
            </tr>
            <tr>
              <td> {echo phrase="ZIP_POSTAL_CODE"}: </td>
              <td> {dbo_echo dbo="order" field="postalcode"} </td>
            </tr>
            <tr>
              <td> {echo phrase="COUNTRY"}: </td>
              <td> {dbo_echo|country dbo="order" field="country"} </td>
            </tr>
            <tr>
              <td> {echo phrase="PHONE"}: </td>
              <td> {dbo_echo dbo="order" field="phone"} </td>
            </tr>
            <tr>
              <td> {echo phrase="MOBILE_PHONE"}: </td>
              <td> {dbo_echo dbo="order" field="mobilephone"} </td>
            </tr>
            <tr>
              <td> {echo phrase="FAX"}: </td>
              <td> {dbo_echo dbo="order" field="fax"} </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </div>

  {if $orderHasDomains}
    <div class="domainoption">
      <table>
        <tr class="reverse">
          <th> {echo phrase="DOMAIN_CONTACT_INFORMATION"} </th>
        </tr>
        <tr>
          <td>
            {echo phrase="DOMAIN_CONTACT_INFORMATION_TEXT"}
          </td>
        </tr>
        <tr>
          <td>
            {form_element field="domaincontact" option="same"}<br/>
            {form_element field="domaincontact" option="new"}
          </td>
        </tr>
      </table>
    </div>
  {else}
    <input type="hidden" name="domaincontact" value="same"/>
  {/if}
            
  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left"> {form_element field="startover"} </td>
        <td class="right">
          {form_element field="back"}
          {form_element field="continue"}
        </td>
      </tr>
    </table>
  </div>
{/form}
