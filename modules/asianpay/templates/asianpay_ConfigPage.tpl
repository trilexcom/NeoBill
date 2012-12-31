<div class="manager_content"</div>
<h2> {echo phrase="ASIANPAY_MODULE"} </h2>

{form name="asianpay_config"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="receiverid"} </th>
        <td> {form_element field="receiverid" value="$receiverid" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="accountid"} </th>
        <td> {form_element field="accountid" value="$accountid" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="secretcode"} </th>
        <td> {form_element field="secretcode" value="$secretcode" size="20"} </td>
      </tr>
      <tr>
        <th> {form_description field="receiveremail"} </th>
        <td> {form_element field="receiveremail" value="$receiveremail" size="10"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  </div>
{/form}
