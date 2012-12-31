<div class="manager_content"</div>
{form name="view_hosting_action"}
  <h2> {echo phrase="WEB_HOSTING_SERVICE"} </h2>
  <div class="properties">
    <table>
        <tr>
          <th style="width: 200px"> {echo phrase="ID"}: </th>
          <td> {dbo_echo dbo="hosting_dbo" field="id"} </td>
        </tr>
        <tr>
          <th> {echo phrase="TITLE"}: </th>
          <td> {dbo_echo dbo="hosting_dbo" field="title"} </td>
        </tr>
        <tr>
          <th> {echo phrase="DESCRIPTION"}: </th>
          <td> 
            <textarea cols="40" rows="3" readonly="readonly">{dbo_echo dbo="hosting_dbo" field="description"}</textarea>
          </td>
        </tr>
        <tr>
          <th> {echo phrase="SETUP_PRICE"} (1 {echo phrase="MONTH"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="setupprice1mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="SETUP_PRICE"} (3 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="setupprice3mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="SETUP_PRICE"} (6 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="setupprice6mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="SETUP_PRICE"} (12 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="setupprice12mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="RECURRING_PRICE"} (1 {echo phrase="MONTH"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="price1mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="RECURRING_PRICE"} (3 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="price3mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="RECURRING_PRICE"} (6 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="price6mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="RECURRING_PRICE"} (12 {echo phrase="MONTHS"}): </th>
          <td> {dbo_echo|currency dbo="hosting_dbo" field="price12mo"} </td>
        </tr>
        <tr>
          <th> {echo phrase="UNIQUE_IP_ADDRESS"}: </th>
          <td> {dbo_echo dbo="hosting_dbo" field="uniqueip"} </td>
        </tr>
        <tr>
          <th> {echo phrase="TAXABLE"}: </th>
          <td> {dbo_echo dbo="hosting_dbo" field="taxable"} </td>
        </tr>
        <tr class="footer">
          <th class="footer"> 
            {form_element field="edit"}
            {form_element field="delete"}
          </th>
          <td/>
        </tr>
    </table>
  </div>
{/form}
