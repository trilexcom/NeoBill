{form name="hostingservice"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td colspan="2"> {echo phrase="SELECT_HOSTING_SERVICE"}: </td>
      </tr>
      <tr>
        <td class="ident"> {form_description field="serviceid"}</td>
        <td> {form_element field="serviceid" onchange="submit()"} </td>
      </tr>
      <tr>
        <td class="ident"> {form_description field="term"}</td>
        <td> {form_element field="term"} </td>
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
          {if $show_skip} 
            {form_element field="skip"}
          {/if}
          {form_element field="continue"}
        </td>
      </tr>
    </table>
  </div>
{/form}
