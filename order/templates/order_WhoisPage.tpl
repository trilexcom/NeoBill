<h3> {$fqdn} [IS_AVAILABLE]! </h3>

{form name="whoispurchase"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> [REGISTER_DOMAIN] </th>
      </tr>
      <tr>
        <td class="indent"> {form_element field="option" option="hosting"} </td>
      </tr>
      <tr>
        <td class="indent"> {form_element field="option" option="nohosting"} </td>
      </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="right"> {form_element field="continue"} </td>
      </tr>
    </table>
  </div>
{/form}
