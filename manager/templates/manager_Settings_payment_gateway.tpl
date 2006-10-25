<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=payment_gateway"> {echo phrase="PAYMENTS"} </a> </li>
</ul>

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

<h2> {echo phrase="ORDER_INTERFACE"} </h2>
<div class="form">
  {form name="settings_order_interface"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="accept_checks"} </th>
        <td> {form_element field="accept_checks" option="true"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>