<div class="form">
  {form name="add_server"}
    <table>
      <thead>
        <tr>
          <th colspan="2"> [ADD_SERVER_PAGE] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
           <td class="left">
            {form_element field="continue"}
          </td>
           <td class="right">
              {form_element field="cancel"}
           </td>
        </tr>
      </tfoot>
      <tbody>
        <tr>
          <th> {form_description field="hostname"} </th>
          <td> {form_element field="hostname"} </td>
        </tr>
        <tr>
          <th> {form_description field="location"} </th>
          <td> {form_element field="location" size="30"} </td>
        </tr>
      </tbody>
    </table>
  {/form}
</div>
