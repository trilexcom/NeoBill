{form name="new_invoice"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [CREATE_INVOICE] </th>
        </tr>
      </thead>
      <tfoot>
      <tr>
          <td class="left">
            {form_element field="cancel"}
          </td>
          <td class="right">
            {form_element field="continue"} 
          </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {form_description field="account"} </th>
          <td> 
            {if isset($account_name)}
              {$account_name}
              <input type="hidden" name="account" value="{$account}"/>
            {else}
              {form_element field="account"}
            {/if}
          </td>
        </tr>
        <tr>
          <th> {form_description field="date"} </th>
          <td> {form_element field="date"} </td>
        </tr>
        <tr>
          <th> [INVOICE_PERIOD] </th>
          <td> 
            {form_element field="periodbegin"} to
            {form_element field="periodend" value=$nextMonth}
          </td>
        </tr>
        <tr>
          <th> {form_description field="terms"} </th>
          <td> {form_element field="terms" size="2"} </td>
        </tr>
        <tr>
          <th> {form_description field="note"} </th>
          <td> {form_element field="note"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
