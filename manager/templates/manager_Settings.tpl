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
    {form name="settings_general"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [COMPANY] </th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
        </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [WELCOME_EMAIL] </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th> {form_description field="welcome_subject"} </th>
              <td> {form_element field="welcome_subject" value="$welcome_subject" size="40"} </td>
            </tr>
            <tr>
             <th colspan="2"> {form_description field="welcome_email"} </th>
            </tr>
            <tr>
              <td colspan="2"> {form_element field="welcome_email" value="$welcome_email" cols="70" rows="10"} </td>
            </tr>
         </tbody>
       </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_CONFIRMATION_EMAIL] </th>
            </tr>
          </thead>
          <tbody>
            <tr>
             <th> {form_description field="confirm_subject"} </th>
             <td> {form_element field="confirm_subject" value="$confirmation_subject" size="40"} </td>
            </tr>
            <tr>
              <th colspan="2"> {form_description field="confirm_email"} </th>
            </tr>
            <tr>
              <td colspan="2"> {form_element field="confirm_email" value="$confirmation_email" cols="70" rows="10"} </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_NOTIFICATION_EMAIL] </th>
            </tr>
          </thead>
          <tfoot>
            <tr> 
              <td class="left"/>
              <td class="right"> {form_element field="save"} </th> 
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="notify_subject"} </th>
              <td> {form_element field="notify_subject" value="$notification_subject" size="40"} </td>
            </tr>
            <tr>
              <th colspan="2"> {form_description field="notify_email"} </th>
            </tr>
            <tr>
              <td colspan="2"> {form_element field="notify_email" value="$notification_email" cols="70" rows="10"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div>  

  <div id="themes" name="[THEMES]" width="80">
    <div class="form">
      {form name="settings_themes"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [THEMES] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                {form_element field="save"}
              </td>
          </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="managertheme"} </th>
              <td> {form_element field="managertheme" value="$managerTheme"} </td>
            </tr>
            <tr>
              <th> {form_description field="ordertheme"} </th>
              <td> {form_element field="ordertheme" value="$orderTheme"} </td>
            </tr>
          </tbody>
        </table>
      {/form}
    </div>
  </div>

  <div id="billing" name="[BILLING]" width="80">
    <div class="form">
      {form name="settings_invoice"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [INVOICE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="right">
                {form_element field="save"}
              </td>
            </tr>
          </tfoot>
          <tbody>
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
              <td colspan="2"> {form_element field="text" value="$invoice_text" cols="70" rows="20"} </td>
            </tr>
          </tbody>
        </table>
      {/form}
    </div>
  </div> 

  <div id="dns" name="[DNS]" width="80">
    <div class="form">
      {form name="settings_nameservers"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [NAME_SERVERS] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                {form_element field="save"}
              </td>
            </tr>
          </tfoot>
          <tbody>
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
          </tbody>
        </table>
      {/form}
    </div>
  </div> 

  <div id="locale" name="[LOCALE]" width="80">
    <div class="form">
      {form name="settings_locale"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [LOCALE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                {form_element field="save"}
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="language"} </th>
              <td> {form_element field="language"} </td>
            </tr>
            <tr>
              <th> {form_description field="currency"} </th>
              <td> {form_element field="currency" value="$currency" size="5"} </td>
            </tr>
          </tbody>
        </table>
      {/form}
    </div>
  </div> 

  <div id="payment_gateway" name="[PAYMENT_GATEWAY]" width="120">
    <div class="form">
      {form name="settings_payment_gateway"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [PAYMENT_GATEWAY] </th>
            </tr>
          </thead>
          <tfoot>
            {if $gatewaysAreEnabled}
              <tr>
                <td/>
                <td class="right">
                 {form_element field="save"}
                </td>
              </tr>
            {/if}
          </tfoot>
          <tbody>
            {if $gatewaysAreEnabled}
              <tr>
                <th> {form_description field="default_module"} </th>
                <td> {form_element field="default_module"} </td>
              </tr>
              <tr>
                <th> {form_description field="order_method"} </th>
                <td> {form_element field="order_method"} </td>
              </tr>
            {else}
              <tr>
                <th colspan="2"> [THERE_ARE_NO_GATEWAY_MODULES] </th>
              </tr>
            {/if}
          </tbody>
        </table>
      {/form}
    </div>
  </div>

  <div id="order_interface" name="[ORDER_INTERFACE]" width="120">
    <div class="form">
      {form name="settings_order_interface"}
        <table>
          <thead>
            <tr>
              <th colspan="2"> [ORDER_INTERFACE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right">
                {form_element field="save"}
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="title"} </th>
              <td> {form_element field="title" size="40" value=$order_title} </td>
            </tr>
            <tr>
              <th> {form_description field="accept_checks"} </th>
              <td> {form_element field="accept_checks" option="true" value=$order_accept_checks} </td>
            </tr>
            <tr>
              <th> {form_description field="tos_url"} </th>
              <td> {form_element field="tos_url" value=$order_tos_url size="50"} </td>
            </tr>
            <tr>
              <th> {form_description field="tos_required"} </th>
              <td> {form_element field="tos_required" option="true" value=$order_tos_required} </td>
            </tr>
          </tbody>
        </table>
      {/form}
    </div>
  </div>
</div> 
