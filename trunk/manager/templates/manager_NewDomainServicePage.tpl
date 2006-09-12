<h2> {echo phrase="NEW_DOMAIN_SERVICE"} </h2>

{form name="new_domain_service"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="tld"} </th>
        <td> .&nbsp;{form_element field="tld" size="8"} (com, net, org, ...) </td>
      </tr>
      <tr>
        <th> {form_description field="modulename"} </th>
        <td> {form_element field="modulename"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element field="description" cols="40" rows="3"} </td>
      </tr>
      <tr> 
        <th> {echo phrase="PERIOD"} </th>
        <th> {echo phrase="RECURRING_PRICE"} </th>
      </tr>
      <tr>
        <th> 1 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price1yr" size="7"} </td>
      </tr>
      <tr>
        <th> 2 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price2yr" size="7"} </td>
      </tr>
      <tr>
        <th> 3 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price3yr" size="7"} </td>
      </tr>
      <tr>
        <th> 4 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price4yr" size="7"} </td>
      </tr>
      <tr>
        <th> 5 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price5yr" size="7"} </td>
      </tr>
      <tr>
        <th> 6 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price6yr" size="7"} </td>
      </tr>
      <tr>
        <th> 7 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price7yr" size="7"} </td>
      </tr>
      <tr>
        <th> 8 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price8yr" size="7"} </td>
      </tr>
      <tr>
        <th> 9 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price9yr" size="7"} </td>
      </tr>
      <tr>
        <th> 10 {echo phrase="YEAR"}: <b>*</b> </th>
        <td> {form_element field="price10yr" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="taxable"} </th>
        <td> {form_element field="taxable"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </th>
	<td/>
      </tr>
    </table>
  </div>
{/form}
