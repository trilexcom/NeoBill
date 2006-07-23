<h2>Please Review Your Order</h2>

<div class="domainoption">
  <table>
    <tr class="reverse"> <td> {echo phrase="CONTACT_EMAIL"} </td> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <th> {echo phrase="EMAIL"}: </th>
              <td> {dbo_echo dbo="order" field="contactemail"} </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

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

  </table>

  <table>
    <tr class="reverse"> <td> {echo phrase="LOGIN_INFORMATION"} </td> </tr>
    <tr>
      <td>
        <div class="form">
          <table>
            <tr>
              <th> {echo phrase="USERNAME"}: </th>
              <td> {dbo_echo dbo="order" field="username"} </td>
            </tr>
            <tr>
              <th> {echo phrase="PASSWORD"}: </th>
              <td> <i>{echo phrase="NOT_SHOWN"}</i> </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

</div>

<div class="cart">
  {dbo_table dbo_class="OrderItemDBO"
             name="orderTable"
             method_name="populateOrderTable"
             title="[YOUR_CART]"}

    {dbo_table_column header="[ITEM]"}
      {dbo_echo dbo="orderTable" field="description"}
    {/dbo_table_column}

    {dbo_table_column header="[TERM]"}
      {dbo_echo dbo="orderTable" field="term"}
    {/dbo_table_column}

    {dbo_table_column header="[PRICE]"}
      {dbo_echo|currency dbo="orderTable" field="price"}
    {/dbo_table_column}

    {dbo_table_column header="[SETUP_FEE]"}
      {dbo_echo|currency dbo="orderTable" field="setupfee"}
    {/dbo_table_column}

    {dbo_table_column header="[TAX]"}
      {dbo_echo|currency dbo="orderTable" field="taxamount"}
    {/dbo_table_column}

  {/dbo_table}
</div>

{form name="review"}
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
