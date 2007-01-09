<script type="text/javascript" src="./include.js"></script>

{form name="domain_contact"}
  <h2> {echo phrase="ENTER_DOMAIN_CONTACT_INFORMATION"}: {$fqdn} </h2>
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> {echo phrase="ADMINISTRATIVE_CONTACT"} </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="abusinessname"} </td>
                <td> {form_element field="abusinessname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="acontactname"} </td>
                <td> {form_element field="acontactname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="acontactemail"} </td>
                <td> {form_element field="acontactemail" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="aaddress1"} </td>
                <td> {form_element field="aaddress1" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="aaddress2" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="aaddress3" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="acity"} </td>
                <td> {form_element field="acity" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="astate"} </td>
                <td> {form_element field="astate" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="apostalcode"} </td>
                <td> {form_element field="apostalcode" size="10"} </td>
              </tr>
              <tr>
                <td> {form_description field="acountry"} </td>
                <td> {form_element field="acountry"} </td>
              </tr>
              <tr>
                <td> {form_description field="aphone"} </td>
                <td> {form_element field="aphone"} </td>
              </tr>
              <tr>
                <td> {form_description field="afax"} </td>
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
        <th> 
          {echo phrase="BILLING_CONTACT"} 
          &nbsp;(<input name="billingcopy" value="true" type="checkbox" onClick="javascript:adminToBilling( this.form );"> {echo phrase="USE_ADMIN_CONTACT"})
        </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="bbusinessname"} </td>
                <td> {form_element field="bbusinessname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="bcontactname"} </td>
                <td> {form_element field="bcontactname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="bcontactemail"} </td>
                <td> {form_element field="bcontactemail" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="baddress1"} </td>
                <td> {form_element field="baddress1" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="baddress2" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="baddress3" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="bcity"} </td>
                <td> {form_element field="bcity" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="bstate"} </td>
                <td> {form_element field="bstate" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="bpostalcode"} </td>
                <td> {form_element field="bpostalcode" size="10"} </td>
              </tr>
              <tr>
                <td> {form_description field="bcountry"} </td>
                <td> {form_element field="bcountry"} </td>
              </tr>
              <tr>
                <td> {form_description field="bphone"} </td>
                <td> {form_element field="bphone"} </td>
              </tr>
              <tr>
                <td> {form_description field="bfax"} </td>
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
        <th> 
          {echo phrase="TECHNICAL_CONTACT"} 
          &nbsp;(<input name="techcopy" value="true" type="checkbox" onClick="javascript:billingToTech( this.form );"> {echo phrase="USE_BILLING_CONTACT"})
        </th>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <td> {form_description field="tbusinessname"} </td>
                <td> {form_element field="tbusinessname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="tcontactname"} </td>
                <td> {form_element field="tcontactname" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="tcontactemail"} </td>
                <td> {form_element field="tcontactemail" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="taddress1"} </td>
                <td> {form_element field="taddress1" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="taddress2" size="50"} </td>
              </tr>
              <tr>
                <td> </td>
                <td> {form_element field="taddress3" size="50"} </td>
              </tr>
              <tr>
                <td> {form_description field="tcity"} </td>
                <td> {form_element field="tcity" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="tstate"} </td>
                <td> {form_element field="tstate" size="30"} </td>
              </tr>
              <tr>
                <td> {form_description field="tpostalcode"} </td>
                <td> {form_element field="tpostalcode" size="10"} </td>
              </tr>
              <tr>
                <td> {form_description field="tcountry"} </td>
                <td> {form_element field="tcountry"} </td>
              </tr>
              <tr>
                <td> {form_description field="tphone"} </td>
                <td> {form_element field="tphone"} </td>
              </tr>
              <tr>
                <td> {form_description field="tfax"} </td>
                <td> {form_element field="tfax"} </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="cart">
        {form_table field="domains"}

          {form_table_column columnid=""}
            <center> {form_table_checkbox option=$domains.orderitemid} </center>
          {/form_table_column}

          {form_table_column columnid="domainname" header="[DOMAIN_NAME]"}
            {$domains.domainname}
          {/form_table_column}

        {/form_table}
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
