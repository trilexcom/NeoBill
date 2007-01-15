{form name="assign_hosting"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [ASSIGN_HOSTING]: {dbo_echo dbo="account_dbo" field="accountname"} </th>
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
          <th> {form_description field="service"} </th>
          <td> {form_element field="service" onChange="submit()"} </td>
        </tr>
        <tr>
          <th> {form_description field="term"} </th>
          <td> {form_element field="term"} </td>
        </tr>
        <tr>
          <th> {form_description field="date"} </th>
          <td> {form_element field="date"} </td>
        </tr>
        <tr>
          <th> {form_description field="server"} </th>
          <td> 
            {form_element field="server" nulloption="true"} <br/>
          </td>
        </tr>
        <tr>
          <th> {form_description field="ipaddress"} </th>
          <td> {form_element field="ipaddress" nulloption="true"} </td>
        </tr>
        {if $domainIsRequired}
          <tr>
            <th> {form_description field="domainname"} </th>
            <td> {form_element field="domainname"} </td>
          </tr>
        {/if}
        <tr>
          <th> {form_description field="note"} </th>
          <td> {form_element field="note" rows=4 cols=50}
        </tr>
      </tbody>
    </table>
  </div>
{/form}
