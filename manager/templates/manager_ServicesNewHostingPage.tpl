<h2> {echo phrase="NEW_HOSTING_SERVICE"} </h2>
{form name="new_hosting"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="title"} </th>
        <td> {form_element field="title" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="uniqueip"} </th>
        <td> {form_element field="uniqueip"} </td>
      </tr>
      <tr>
        <th>{form_description field="allow1"}</th>
        <td>
          <table class="inner">
            <tr>
              <td>{form_element field="allow1"}  1 {echo phrase="MONTH"} </td>
              <td>{form_element field="allow3"}  3 {echo phrase="MONTHS"} </td>
              <td>{form_element field="allow6"}  6 {echo phrase="MONTHS"} </td>
              <td>{form_element field="allow12"}  12 {echo phrase="MONTHS"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="SETUP_PRICE"}: <b>*</b></th>
        <td>
          <table class="inner">
            <tr>
              <td> {form_element field="setupprice1mo" size="7"} </td>
              <td> {form_element field="setupprice3mo" size="7"} </td>
              <td> {form_element field="setupprice6mo" size="7"} </td>
              <td> {form_element field="setupprice12mo" size="7"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="RECURRING_PRICE"}: <b>*</b></th>
        <td> 
          <table class="inner">
            <tr>
              <td> {form_element field="price1mo" size="7"} </td>
              <td> {form_element field="price3mo" size="7"} </td>
              <td> {form_element field="price6mo" size="7"} </td>
              <td> {form_element field="price12mo" size="7"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {form_description field="taxable"} </th>
        <td> {form_element field="taxable"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </td>
	<td/>
      </tr>
    </table>
  </div>
{/form}
