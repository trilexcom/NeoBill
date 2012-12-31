<div class="manager_content"</div>
<h2> {echo phrase="AUTHORIZENET_AIM_MODULE"} </h2>

{form name="aaim_config"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="loginid"} </th>
        <td> {form_element field="loginid" value="$loginid" size="10"} </td>
      </tr>
      <tr>
        <th> {form_description field="transactionkey"} </th>
        <td> {form_element field="transactionkey" value="$transactionkey" size="50"} </td>
      </tr>
      <tr>
        <th> {form_description field="transactionurl"} </th>
        <td> {form_element field="transactionurl" value="$transactionurl" size="50"} </td>
      </tr>
      <tr>
        <th> {form_description field="delimiter"} </th>
        <td> {form_element field="delimiter" value="$delimiter" size="1"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  </div>
{/form}
