<h2> {echo phrase="HOSTING_SERVICE"} ({echo phrase="ID"}: {dbo_echo dbo="hosting_dbo" field="id"}) </h2>

{form name="edit_hosting"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="title"} </th>
        <td> {form_element dbo="hosting_dbo" field="title" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element dbo="hosting_dbo" field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="uniqueip"} </th>
        <td> {form_element dbo="hosting_dbo" field="uniqueip"} </td>
      </tr>
      <tr>
        <th/>
        <td>
          <table class="inner">
            <tr>
              <th> 1 {echo phrase="MONTH"} </td>
              <th> 3 {echo phrase="MONTHS"} </td>
              <th> 6 {echo phrase="MONTHS"} </td>
              <th> 12 {echo phrase="MONTHS"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="SETUP_PRICE"}: <b>*</b></th>
        <td>
          <table class="inner">
            <tr>
              <td> {form_element dbo="hosting_dbo" field="setupprice1mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="setupprice3mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="setupprice6mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="setupprice12mo" size="7"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="RECURRING_PRICE"}: <b>*</b></th>
        <td> 
          <table class="inner">
            <tr>
              <td> {form_element dbo="hosting_dbo" field="price1mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="price3mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="price6mo" size="7"} </td>
              <td> {form_element dbo="hosting_dbo" field="price12mo" size="7"} </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <th> {form_description field="taxable"} </th>
        <td> {form_element dbo="hosting_dbo" field="taxable"} </td>
      </tr>
      <tr class="footer">
        <th> 
          {form_element field="save"}
          {form_element field="cancel"}
        </th>
	<td/>
      </tr>
    </table>
  </div>
{/form}
