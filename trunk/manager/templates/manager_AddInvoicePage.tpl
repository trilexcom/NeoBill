<h2> {echo phrase="CREATE_INVOICE"} </h2>

{form name="new_invoice"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="accountid"} </th>
        <td> 
          {if isset($account_name)}
            {$account_name}
            <input type="hidden" name="accountid" value="{$account}"/>
          {else}
            {form_element field="accountid"}
          {/if}
        </td>
      </tr>
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="periodbegin"} </th>
        <td> {form_element field="periodbegin"} </td>
      </tr>
      <tr>
        <th> {form_description field="terms"} </th>
        <td> {form_element field="terms" size="2"} </td>
      </tr>
      <tr>
        <th> {form_description field="note"} </th>
        <td> {form_element field="note"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"} 
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>
{/form}
