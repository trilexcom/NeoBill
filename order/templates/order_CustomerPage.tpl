{form name="customer_information"}

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> E-Mail </th>
      </tr>
      <tr> <td> {echo phrase="EMAIL_TEXT"} </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="contactemail"} </td>
                <td> {form_element dbo="order" field="contactemail" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="verifyemail"} </td>
                <td> {form_element field="verifyemail" size="50"} </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> {echo phrase="CONTACT_INFORMATION"} </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="businessname"} </td>
                <td> {form_element dbo="order" field="businessname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="contactname"} </td>
                <td> {form_element dbo="order" field="contactname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="address1"} </td>
                <td> {form_element dbo="order" field="address1" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element dbo="order" field="address2" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="city"} </td>
                <td> {form_element dbo="order" field="city" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="state"} </td>
                <td> {form_element dbo="order" field="state" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="postalcode"} </td>
                <td> {form_element dbo="order" field="postalcode" size="10"} </td>
              </tr>
              <tr>
                <td> {form_description field="country"} </td>
                <td> {form_element dbo="order" field="country"} </td>
              </tr>
              <tr>
                <td> {form_description field="phone"} </td>
                <td> {form_element dbo="order" field="phone"} </td>
              </tr>
              <tr>
                <td> {form_description field="mobilephone"} </td>
                <td> {form_element dbo="order" field="mobilephone"} </td>
              </tr>
              <tr>
                <td> {form_description field="fax"} </td>
                <td> {form_element dbo="order" field="fax"} </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
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
            
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th>Login</th> <!-- hardcoded in english -->
      </tr>
      <tr> <td> {echo phrase="LOGIN_TEXT"} </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="username"} </td>
                <td> {form_element dbo="order" field="username"} </td>
              </tr>
              <tr>
                <td> {form_description field="password"} </td>
                <td> {form_element field="password"} </td>
              </tr>
              <tr>
                <td> {form_description field="repassword"} </td>
                <td> {form_element field="repassword"} </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> [ADDITIONAL_INFORMATION] </th>
      </tr>
      <tr>
        <td>
          <p> [FEEL_FREE_TO_USE_THIS_SPACE_TO_ASK_QUESTIONS_OR]: </p>
          {form_element field="note" rows="5" cols="60"}
        </td>
      </tr>
    </table>
  </div>

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
