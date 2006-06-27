{form name="transferdomain"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td colspan="2"> 
          {echo phrase="TRANSFER_TERMS"}
        </td>
      </tr>
      <tr> 
        <td style="width: 30%"> {echo phrase="DOMAIN_NAME"}: </td>
        <td> {$domain_name}.{$domain_tld} </td>
      </tr>
      <tr>
        <td style="width: 30%"> {form_description field="secret"}: </td>
        <td> {form_element field="secret" size="10"} </td>
      </tr>
      <tr>
        <td style="width: 30%"> {form_description field="period"} </td>
        <td> {form_element field="period"} </td>
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
          {form_element field="back"}
          {form_element field="another"}
          {form_element field="continue"}
        </td>
    </table>
  </div>
{/form}
