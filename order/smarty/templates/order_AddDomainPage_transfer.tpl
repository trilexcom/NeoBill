{form name="transferdomain"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td colspan="2"> 
          {echo phrase="TRANSFER_TERMS"}
        </td>
      </tr>
      <tr> 
        <td> {echo phrase="DOMAIN_NAME"}: </td>
        <td> {$domain_name}.{$domain_tld} </td>
      </tr>
      <tr>
        <td> {form_description field="secret"}: </td>
        <td> {form_element field="secret" size="10"} </td>
      </tr>
      <tr>
        <td> {form_description field="period"} </td>
        <td> {form_element field="period"} </td>
      </tr>
      <tr>
        <td> {form_description field="contact"} </td>
        <td> 
          {form_element field="contact" option="Billing"}<br/>
          {form_element field="contact" option="Other"}
        </td>
      </tr>
    </table>
  </div>
  <div class="buttoncontainer">
    <table>
      <tr>
        {if $show_cancel}
          <td class="left">{form_element field="cancel"}</td>
        {/if}
        <td class="right">
          {form_element field="back"}{form_element field="continue"}
        </td>
    </table>
  </div>
{/form}
