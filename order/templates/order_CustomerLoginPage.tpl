{form name="login"}
  <div class="domainoption">
    <table>
      <tr class="reverse">
        <td> {echo phrase="CUSTOMER_LOGIN"} </td>
      </tr>
      <tr>
        <td>
          <div class="form">
            <table>
              <tr>
                <th> {form_description field="username"} </th>
                <td> {form_element field="username"} </td>
              </tr>
              <tr>
                <th> {form_description field="password"} </th>
                <td> {form_element field="password"} </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="buttoncontainer">
    <table>
      <tr>
        <td class="right">
          {form_element field="back"}
          {form_element field="login"}
        </td>
      </tr>
    </table>
  </div>
{/form}