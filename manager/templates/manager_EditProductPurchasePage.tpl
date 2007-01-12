<h2> [EDIT_PRODUCT_PURCHASE] </h2>

{form name="edit_product_purchase"}
  <div class="form">
    <table>
      <tr>
        <th> [ACCOUNT]: </th>
        <td> {$purchaseDBO->getAccountName()} </td>
      </tr>
      <tr>
        <th> [PRODUCT]: </th>
        <td> {$purchaseDBO->getTitle()} </td>	
      </tr>
      <tr>
        <th> [PURCHASED]: </th>
        <td> {$purchaseDBO->getDate()|datetime:date} </td>
      </tr>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element field="term" value=$purchaseDBO->getTermID()} </td>
      </tr>
      <tr>
        <th> {form_description field="nextbillingdate"} </th>
        <td> {form_element field="nextbillingdate" value=$purchaseDBO->getNextBillingDate()} </td>
      </tr>
      <tr>
        <th> {form_description field="note"} </th>
        <td> {form_element field="note" size="40" rows="4" cols="50" value=$purchaseDBO->getNote()} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"} {form_element field="cancel"}
        </td>
      </tr>
    </table>
  </div>
{/form}