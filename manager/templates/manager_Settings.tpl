<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXCommon.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar_start.js"></script>

{if $tab != null}
  <script type="text/javascript">
    var activeTab = "{$tab}";
  </script>
{/if}

<div id="a_tabbar" 
     class="dhtmlxTabBar" 
     style="margin-top: 0.5em;"  
     imgpath="../include/dhtmlxTabbar/imgs/"
     skinColors="#FFFFFF,#F4F3EE">

  <div id="general" name="[GENERAL]" width="80">
    <h2> {echo phrase="COMPANY"} </h2>
    <div class="form">
      {form name="settings_company"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="name"} </th>
            <td> {form_element field="name" value="$company_name" size="40"} </td>
          </tr>
          <tr>
            <th> {form_description field="email"} </th>
            <td> {form_element field="email" value="$company_email" size="30"} </td>
          </tr>
          <tr>
            <th> {form_description field="notification_email"} </th>
            <td> {form_element field="notification_email" value="$company_notification_email" size="30"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>

    <h2> {echo phrase="WELCOME_EMAIL"} </h2>
    <div class="form">
      {form name="settings_welcome"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="subject"} </th>
            <td> {form_element field="subject" value="$welcome_subject" size="40"} </td>
          </tr>
          <tr>
           <th colspan="2"> {form_description field="email"} </th>
          </tr>
          <tr>
            <td colspan="2"> {form_element field="email" value="$welcome_email" cols="80" rows="10"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
       </table>
      {/form}
    </div>

    <h2> {echo phrase="ORDER_CONFIRMATION_EMAIL"} </h2>
    <div class="form">
      {form name="settings_confirmation"}
        <table style="width: 95%">
            <tr>
             <th> {form_description field="subject"} </th>
             <td> {form_element field="subject" value="$confirmation_subject" size="40"} </td>
            </tr>
            <tr>
              <th colspan="2"> {form_description field="email"} </th>
            </tr>
            <tr>
              <td colspan="2"> {form_element field="email" value="$confirmation_email" cols="80" rows="10"} </td>
            </tr>
            <tr class="footer">
              <td colspan="2">
                {form_element field="save"}
              </td>
            </tr>
        </table>
      {/form}
    </div>

    <h2> {echo phrase="ORDER_NOTIFICATION_EMAIL"} </h2>
    <div class="form">
      {form name="settings_notification"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="subject"} </th>
            <td> {form_element field="subject" value="$notification_subject" size="40"} </td>
          </tr>
          <tr>
            <th colspan="2"> {form_description field="email"} </th>
          </tr>
          <tr>
            <td colspan="2"> {form_element field="email" value="$notification_email" cols="80" rows="10"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div>  

  <div id="themes" name="[THEMES]" width="80">
    <h2> [THEMES] </h2>
    <div class="form">
      {form name="settings_themes"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="managertheme"} </th>
            <td> {form_element field="managertheme" value="$managerTheme"} </td>
          </tr>
          <tr>
            <th> {form_description field="ordertheme"} </th>
            <td> {form_element field="ordertheme" value="$orderTheme"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div>

  <div id="billing" name="[BILLING]" width="80">
    <h2> {echo phrase="INVOICE"} </h2>
    <div class="form">
      {form name="settings_invoice"}
        <table style="width: 95%">
          <tr>
            <th colspan="2"> {form_description field="subject"} </th>
          </tr>
          <tr>
            <td colspan="2"> {form_element field="subject" value="$invoice_subject" size="80"} </td>
          </tr>
          <tr>
            <th colspan="2"> {form_description field="text"} </th>
          </tr>
          <tr>
            <td colspan="2"> {form_element field="text" value="$invoice_text" cols="80" rows="20"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div> 

  <div id="dns" name="[DNS]" width="80">
    <h2> {echo phrase="NAME_SERVERS"} </h2>
    <div class="form">
      {form name="settings_nameservers"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="nameservers_ns1"} </th>
            <td> {form_element field="nameservers_ns1" value="$nameservers_ns1" size="40"} </td>
          </tr>
          <tr>
            <th> {form_description field="nameservers_ns2"} </th>
            <td> {form_element field="nameservers_ns2" value="$nameservers_ns2" size="40"} </td>
          </tr>
          <tr>
            <th> {form_description field="nameservers_ns3"} </th>
            <td> {form_element field="nameservers_ns3" value="$nameservers_ns3" size="40"} </td>
          </tr>
          <tr>
            <th> {form_description field="nameservers_ns4"} </th>
            <td> {form_element field="nameservers_ns4" value="$nameservers_ns4" size="40"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div> 

  <div id="locale" name="[LOCALE]" width="80">
    <h2> {echo phrase="LOCALE"} </h2>
    <div class="form">
      {form name="settings_locale"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="language"} </th>
            <td> {form_element field="language"} </td>
          </tr>
          <tr>
            <th> {form_description field="currency"} </th>
            <td> {form_element field="currency" value="$currency" size="5"} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div> 

  <div id="payment_gateway" name="[PAYMENT_GATEWAY]" width="120">
    <h2> {echo phrase="PAYMENT_GATEWAY"} </h2>
    {if $gatewaysAreEnabled}
      <div class="form">
        {form name="settings_payment_gateway"}
          <table style="width: 95%">
            <tr>
              <th> {form_description field="default_module"} </th>
              <td> {form_element field="default_module"} </td>
            </tr>
            <tr>
              <th> {form_description field="order_method"} </th>
              <td> {form_element field="order_method"} </td>
            </tr>
            <tr class="footer">
              <td colspan="2">
                {form_element field="save"}
              </td>
            </tr>
          </table>
        {/form}
      </div>
    {else}
      <p> {echo phrase="THERE_ARE_NO_GATEWAY_MODULES"} </p>
    {/if}
  </div>

  <div id="order_interface" name="[ORDER_INTERFACE]" width="120">
    <h2> {echo phrase="ORDER_INTERFACE"} </h2>
    <div class="form">
      {form name="settings_order_interface"}
        <table style="width: 95%">
          <tr>
            <th> {form_description field="title"} </th>
            <td> {form_element field="title" size="40" value=$order_title} </td>
          </tr>
          <tr>
            <th> {form_description field="accept_checks"} </th>
            <td> {form_element field="accept_checks" option="true" value=$order_accept_checks} </td>
          </tr>
          <tr class="footer">
            <td colspan="2">
              {form_element field="save"}
            </td>
          </tr>
        </table>
      {/form}
    </div>
  </div>
</div> 
