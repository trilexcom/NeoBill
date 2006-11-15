{form name="creditcard"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> {echo phrase="BILLING_INFORMATION"} </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td colspan="2"> {echo phrase="BILLING_INFO_NOTE"}<p/> </td>
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
                <td> {form_description field="country"} </td>
                <td> {form_element dbo="order" field="country"} </td>
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
                <td> {form_description field="phone"} </td>
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
        <th> {echo phrase="CREDIT_CARD_INFORMATION"} </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="cardnumber"} </td>
                <td> {form_element field="cardnumber" size="16"} {echo phrase="CARD_NUMBER_FORMAT"}</td>
              </tr>
              <tr>
                <td> {form_description field="cardexpire"} </td>
                <td> {form_element field="cardexpire" size="5"} (MM/YY) </td>
              </tr>            
              <tr>
                <td> {form_description field="cardcode"} </td>
                <td> {form_element field="cardcode" size="4"}</td>
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
