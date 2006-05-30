{form name="customer_information"}

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> E-Mail </td>
      </tr>
      <tr> <td> {echo phrase="EMAIL_TEXT"} </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="contactemail"} </th>
                <td> {form_element dbo="order" field="contactemail" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="verifyemail"} </th>
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
        <td> {echo phrase="CONTACT_INFORMATION"} </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="businessname"} </th>
                <td> {form_element dbo="order" field="businessname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="contactname"} </th>
                <td> {form_element dbo="order" field="contactname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="address1"} </th>
                <td> {form_element dbo="order" field="address1" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element dbo="order" field="address2" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="country"} </th>
                <td> {form_element dbo="order" field="country"} </td>
              </tr>
              <tr>
                <th> {form_description field="city"} </th>
                <td> {form_element dbo="order" field="city" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="state"} </th>
                <td> {form_element dbo="order" field="state" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="postalcode"} </th>
                <td> {form_element dbo="order" field="postalcode" size="10"} </td>
              </tr>
              <tr>
                <th> {form_description field="phone"} </th>
                <td> {form_element dbo="order" field="phone"} </td>
              </tr>
              <tr>
                <th> {form_description field="mobilephone"} </th>
                <td> {form_element dbo="order" field="mobilephone"} </td>
              </tr>
              <tr>
                <th> {form_description field="fax"} </th>
                <td> {form_element dbo="order" field="fax"} </td>
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
        <td>Login</td>
      </tr>
      <tr> <td> {echo phrase="LOGIN_TEXT"} </td> </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="username"} </th>
                <td> {form_element dbo="order" field="username"} </td>
              </tr>
              <tr>
                <th> {form_description field="password"} </th>
                <td> {form_element field="password"} </td>
              </tr>
              <tr>
                <th> {form_description field="repassword"} </th>
                <td> {form_element field="repassword"} </td>
              </tr>
            </table>
          </div>
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
