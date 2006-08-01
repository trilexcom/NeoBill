{form name="repeat_customer"}
  <div class="domainoption">
  <table>
    <tr class="reverse"> <td> Account Information </td> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <th> {echo phrase="BUSINESS_NAME"}: </th>
              <td> {dbo_echo dbo="order" field="businessname"} </td>
            </tr>
            <tr>
              <th> {echo phrase="CONTACT_NAME"}: </th>
              <td> {dbo_echo dbo="order" field="contactname"} </td>
            </tr>
            <tr>
              <th> {echo phrase="ADDRESS"}: </th>
              <td> {dbo_echo dbo="order" field="address1"} </td>
            </tr>
            <tr>
              <th> </th>
              <td> {dbo_echo dbo="order" field="address2"} </td>
            </tr>
            <tr>
              <th> {echo phrase="CITY"}: </th>
              <td> {dbo_echo dbo="order" field="city"} </td>
            </tr>
            <tr>
              <th> {echo phrase="STATE"}: </th>
              <td> {dbo_echo dbo="order" field="state"} </td>
            </tr>
            <tr>
              <th> {echo phrase="COUNTRY"}: </th>
              <td> {dbo_echo|country dbo="order" field="country"} </td>
            </tr>
            <tr>
              <th> {echo phrase="POSTALCODE"}: </th>
              <td> {dbo_echo dbo="order" field="postalcode"} </td>
            </tr>
            <tr>
              <th> {echo phrase="PHONE"}: </th>
              <td> {dbo_echo dbo="order" field="phone"} </td>
            </tr>
            <tr>
              <th> {echo phrase="MOBILE_PHONE"}: </th>
              <td> {dbo_echo dbo="order" field="mobilephone"} </td>
            </tr>
            <tr>
              <th> {echo phrase="FAX"}: </th>
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
          <td> {echo phrase="DOMAIN_CONTACT_INFORMATION"} </td>
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