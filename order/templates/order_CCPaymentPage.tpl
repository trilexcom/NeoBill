{form name="creditcard"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> {echo phrase="BILLING_INFORMATION"} </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td colspan="2"> {echo phrase="BILLING_INFO_NOTE"}<p/> </td>
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
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> {echo phrase="CREDIT_CARD_INFORMATION"} </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="cardnumber"} </th>
                <td> {form_element field="cardnumber" size="16"} {echo phrase="CARD_NUMBER_FORMAT"}</td>
              </tr>
              <tr>
                <th> {form_description field="cardexpire"} </th>
                <td> {form_element field="cardexpire" size="4"} </td>
              </tr>            
              <tr>
                <th> {form_description field="cardcode"} </th>
                <td> {form_element field="cardcode" size="4"} {echo phrase="CARD_CODE_FORMAT"}</td>
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
          {form_element field="authorize"}
        </td>
      </tr>
    </table>
  </div>
{/form}