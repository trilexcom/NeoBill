<script type="text/javascript" src="./include.js"></script>

{form name="domain_contact"}
  <h2> {echo phrase="DOMAIN_CONTACT_INFORMATION_FOR"}: {$fqdn} </h2>
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> {echo phrase="ADMINISTRATIVE_CONTACT"} </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="abusinessname"} </th>
                <td> {form_element field="abusinessname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="acontactname"} </th>
                <td> {form_element field="acontactname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="acontactemail"} </th>
                <td> {form_element field="acontactemail" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="aaddress1"} </th>
                <td> {form_element field="aaddress1" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="aaddress2" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="aaddress3" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="acountry"} </th>
                <td> {form_element field="acountry"} </td>
              </tr>
              <tr>
                <th> {form_description field="acity"} </th>
                <td> {form_element field="acity" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="astate"} </th>
                <td> {form_element field="astate" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="apostalcode"} </th>
                <td> {form_element field="apostalcode" size="10"} </td>
              </tr>
              <tr>
                <th> {form_description field="aphone"} </th>
                <td> {form_element field="aphone"} </td>
              </tr>
              <tr>
                <th> {form_description field="afax"} </th>
                <td> {form_element field="afax"} </td>
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
        <td> 
          {echo phrase="BILLING_CONTACT"} 
          &nbsp;(<input name="billingcopy" type="checkbox" onClick="javascript:adminToBilling( this.form );"> {echo phrase="USE_ADMIN_CONTACT"})
        </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="bbusinessname"} </th>
                <td> {form_element field="bbusinessname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="bcontactname"} </th>
                <td> {form_element field="bcontactname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="bcontactemail"} </th>
                <td> {form_element field="bcontactemail" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="baddress1"} </th>
                <td> {form_element field="baddress1" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="baddress2" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="baddress3" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="bcountry"} </th>
                <td> {form_element field="bcountry"} </td>
              </tr>
              <tr>
                <th> {form_description field="bcity"} </th>
                <td> {form_element field="bcity" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="bstate"} </th>
                <td> {form_element field="bstate" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="bpostalcode"} </th>
                <td> {form_element field="bpostalcode" size="10"} </td>
              </tr>
              <tr>
                <th> {form_description field="bphone"} </th>
                <td> {form_element field="bphone"} </td>
              </tr>
              <tr>
                <th> {form_description field="bfax"} </th>
                <td> {form_element field="bfax"} </td>
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
        <td> 
          {echo phrase="TECHNICAL_CONTACT"} 
          &nbsp;(<input name="techcopy" type="checkbox" onClick="javascript:billingToTech( this.form );"> {echo phrase="USE_BILLING_CONTACT"})
        </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="tbusinessname"} </th>
                <td> {form_element field="tbusinessname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="tcontactname"} </th>
                <td> {form_element field="tcontactname" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="tcontactemail"} </th>
                <td> {form_element field="tcontactemail" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="taddress1"} </th>
                <td> {form_element field="taddress1" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="taddress2" size="50"} </td>
              </tr>
              <tr>
                <th> </th>
                <td> {form_element field="taddress3" size="50"} </td>
              </tr>
              <tr>
                <th> {form_description field="tcountry"} </th>
                <td> {form_element field="tcountry"} </td>
              </tr>
              <tr>
                <th> {form_description field="tcity"} </th>
                <td> {form_element field="tcity" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="tstate"} </th>
                <td> {form_element field="tstate" size="30"} </td>
              </tr>
              <tr>
                <th> {form_description field="tpostalcode"} </th>
                <td> {form_element field="tpostalcode" size="10"} </td>
              </tr>
              <tr>
                <th> {form_description field="tphone"} </th>
                <td> {form_element field="tphone"} </td>
              </tr>
              <tr>
                <th> {form_description field="tfax"} </th>
                <td> {form_element field="tfax"} </td>
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
        <td> {echo phrase="APPLY_TO_THESE_DOMAINS"}: </td>
      </tr>
      <tr>
        <td> {form_element field="domains"} </td>
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
