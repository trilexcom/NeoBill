<h2> Domain Service (TLD: .{dbo_echo dbo="domain_service_dbo" field="tld"}) </h2>

{form name="edit_domain_service"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="description"} </th>
        <td> {form_element dbo="domain_service_dbo" field="description" cols="40" rows="3"} </td>
      </tr>
      <tr>
        <th> {form_description field="modulename"} </th>
        <td> {form_element dbo="domain_service_dbo" field="modulename"} </td>
      </tr>
      <tr> 
        <th> Period </th>
        <th> Recurring Price</th>
      </tr>
      <tr>
        <th> 1 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price1yr" size="7"} </td>
      </tr>
      <tr>
        <th> 2 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price2yr" size="7"} </td>
      </tr>
      <tr>
        <th> 3 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price3yr" size="7"} </td>
      </tr>
      <tr>
        <th> 4 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price4yr" size="7"} </td>
      </tr>
      <tr>
        <th> 5 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price5yr" size="7"} </td>
      </tr>
      <tr>
        <th> 6 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price6yr" size="7"} </td>
      </tr>
      <tr>
        <th> 7 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price7yr" size="7"} </td>
      </tr>
      <tr>
        <th> 8 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price8yr" size="7"} </td>
      </tr>
      <tr>
        <th> 9 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price9yr" size="7"} </td>
      </tr>
      <tr>
        <th> 10 Year: <b>*</b> </th>
        <td> {form_element dbo="domain_service_dbo" field="price10yr" size="7"} </td>
      </tr>
      <tr>
        <th> {form_description field="taxable"} </th>
        <td> {form_element dbo="domain_service_dbo" field="taxable"} </td>
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
