<div class="manager_content"</div>
<h2> {echo phrase="PAYPAL_WPS_MODULE"} </h2>

{form name="psm_config"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="account"} </th>
        <td> {form_element field="account" value="$account" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="carturl"} </th>
        <td> {form_element field="carturl" value="$cartURL" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="idtoken"} </th>
        <td> {form_element field="idtoken" value="$idToken" size="80"} </td>
      </tr>
      <tr>
        <th> {form_description field="currency"} </th>
        <td> {form_element field="currency" value="$currency"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2"> {form_element field="save"} </td>
      </tr>
    </table>
  </div>
{/form}
