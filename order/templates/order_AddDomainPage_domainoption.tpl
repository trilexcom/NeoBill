<script type="text/javascript" src="./include.js"></script>

{form name="domainoption"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> 
          {form_element field="domainaction" option="Register Domain"} 
        </td>
      </tr>
      <tr> 
        <td class="indent">
          {form_description field="registerdomainname"}
          {form_element field="registerdomainname" size="30"}.{form_element field="registerdomaintld"}
          <p> {echo phrase="REGISTER_DOMAIN_OPTION_TEXT"} </p>
        </td>
      </tr>
    </table>

    <table>
      <tr class="reverse">
        <td> {form_element field="domainaction" option="Transfer Domain"} </td>
     </tr>
      <tr> 
        <td class="indent">
          {form_description field="transferdomainname"}
          {form_element field="transferdomainname" size="30"}.{form_element field="transferdomaintld"}
          <p> {echo phrase="TRANSFER_DOMAIN_OPTION_TEXT"} </p>
        </td>
      </tr>
    </table>

    <table>
      <tr class="reverse">
        <td> {form_element field="domainaction" option="Existing Domain"} </td>
      </tr>
      <tr> 
        <td class="indent">
          {form_description field="existingdomainname"}
          {form_element field="existingdomainname" size="40"}
          <p> {echo phrase="EXISTING_DOMAIN_OPTION_TEXT"} </p>
          <p>
            {foreach key=key item=nameserver from=$nameservers}
              {if !empty($nameserver)}
                {echo phrase="NAMESERVER"} #{$key+1} - {$nameserver} <br/>
              {/if}
            {/foreach}
          </p>
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
        <td class="right">{form_element field="continue"}</td>
      </tr>
    </table>
  </div>
{/form}
