<h3> {$fqdn} [IS_ALREADY_REGISTERED] </h3>

{form name="whois"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <th> [TRY_ANOTHER_DOMAIN] </th>
      </tr>
      <tr>
        <td class="indent"> [DOMAIN_NAME]: {form_element field="domain"}.{form_element field="tld"} </td>
      </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="right"> {form_element field="submit"} </td>
      </tr>
    </table>
  </div>
{/form}
