<h2> [CPANEL_CONFIGURATION] </h2>

{form name="cp_config"}
  <div class="form">
    <table>
      <tr>
        <th> {form_description field="libpath"} </th>
        <td> {form_element field="libpath" value=$CPModule->getLibPath() size="60"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2"> {form_element field="save"} </td>
      </tr>
    </table>
  </div>
{/form}