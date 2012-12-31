<div class="manager_content"</div>
<p class="message"> 
  {echo phrase="CONFIRM_DOMAIN_SERVICE"}
</p>
{form name="new_domain_service_confirm"}
  <h2> {echo phrase="ADD_DOMAIN_SERVICE"} </h2>
  <div class="properties">
    <table style="width: 70%">
      <tr>
        <th> TLD: </th>
        <td> .{dbo_echo dbo="new_domain_service_dbo" field="tld"} </td>
      </tr>
      <tr>
        <th> {echo phrase="REGISTRAR_MODULE"}: </th>
        <td> {dbo_echo dbo="new_domain_service_dbo" field="modulename"} </td>
      </tr>
      <tr>
        <th> {echo phrase="DESCRIPTION"}: </th>
        <td>
          <textarea cols="40" rows="3" readonly="readonly">{dbo_echo dbo="new_domain_service_dbo" field="description"}</textarea>
        </td>
      </tr>
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (1 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price1yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (2 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price2yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (3 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price3yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (4 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price4yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (5 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price5yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (6 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price6yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (7 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price7yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (8 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price8yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (9 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price9yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="RECURRING_PRICE"} (10 {echo phrase="YEAR"}): </th>
        <td> {dbo_echo|currency dbo="new_domain_service_dbo" field="price10yr"} </td>
      </tr>      
      <tr>
        <th> {echo phrase="TAXABLE"}: </th>
        <td> {dbo_echo dbo="new_domain_service_dbo" field="taxable"} </td>
      </tr>
      <tr class="footer">
        <th class="footer"> 
          {form_element field="continue"}
          {form_element field="goback"}
        </th>
        <td/>
      </tr>
    </table>
  </div>
{/form}
