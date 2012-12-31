<div class="manager_content"</div>
{form name="new_hosting"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [NEW_HOSTING_SERVICE] </th>
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
          <th> {form_description field="domainrequirement"} </th>
          <td> {form_element field="domainrequirement"} </td>
        </tr>
        <tr>
          <th> {form_description field="public"} </th>
          <td> {form_element field="public" option="Yes"} </td>
        </tr>
      </tbody>
    </table>
  </div>
{/form}
