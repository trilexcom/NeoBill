<h2>Please Review Your Order</h2>

<div class="domainoption">
  <table>
    <tr class="reverse"> <th> {echo phrase="CONTACT_EMAIL"} </th> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> {echo phrase="EMAIL"}: </td>
              <td> {dbo_echo dbo="order" field="contactemail"} </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <table>
    <tr class="reverse"> <th> Account Information </th> </tr> <!-- hardcoded english -->
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

  </table>
</div>

<div class="domainoption">
  <table>
    <tr class="reverse"> <th> {echo phrase="LOGIN_INFORMATION"} </th> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <td> {echo phrase="USERNAME"}: </td>
              <td> {dbo_echo dbo="order" field="username"} </td>
            </tr>
            <tr>
              <td> {echo phrase="PASSWORD"}: </td>
              <td> <i>{echo phrase="NOT_SHOWN"}</i> </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

</div>

{form name="review"}
  <div class="cart">
    {form_table field="cart"}

      {form_table_column columnid="description" header="[ITEM]"}
        {$cart.description}
      {/form_table_column}

      {form_table_column columnid="term" header="[TERM]"}
        {$cart.term}
      {/form_table_column}

      {form_table_column columnid="setupfee" header="[SETUP_FEE]"}
        {$cart.setupfee|currency}
      {/form_table_column}

      {form_table_column columnid="price" header="[PRICE]"}
        {$cart.price|currency}
      {/form_table_column}

    {/form_table}
  </div>

  {dbo_assign dbo="order" field="accounttype" var="accounttype"}
  {if $accounttype == "New Account"}
    <div class="cart_total">
      <table>
        <tr>
          <th>{echo phrase="RECURRING_TOTAL"}:</th>
          <td>{dbo_echo|currency dbo="order" field="recurringtotal"}</td>
        </tr>
        <tr>
          <th>{echo phrase="NONRECURRING_TOTAL"}:</th>
          <td>{dbo_echo|currency dbo="order" field="nonrecurringtotal"}</td>
        </tr>
        <tr>
          <th>{echo phrase="SUB_TOTAL"}:</th>
          <td>{dbo_echo|currency dbo="order" field="subtotal"}</td>
        </tr>
        <tr>
          <th>{echo phrase="TAXES"}:</th>
          <td>{dbo_echo|currency dbo="order" field="taxtotal"}</td>
        </tr>
        <tr>
          <th>{echo phrase="TOTAL"}:</th>
          <td>{dbo_echo|currency dbo="order" field="total"}</td>
        </tr>
        <tr>
          <th>{form_description field="module"}&nbsp;&nbsp;</th>
          <td>{form_element field="module"}</td>
        </tr>
      </table>
    </div>
  {else}
    <p> <b>{echo phrase="YOUR_ACCOUNT_WILL_BE_BILLED"}</b> </p>
  {/if}

  <p/>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="left"> {form_element field="startover"} </td>
        <td class="right">
          {form_element field="back"}
          {form_element field="checkout"}
        </td>
      </tr>
    </table>
  </div>
{/form}

<p/>
