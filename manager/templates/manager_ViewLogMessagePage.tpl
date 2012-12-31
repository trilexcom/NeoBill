<div class="manager_content"</div>
<h2> {echo phrase="VIEW_LOG_MESSAGE"} </h2>
<div class="properties">
  <table>
    <tr>
      <th> {echo phrase="LOG_MESSAGE_ID"}: </th>
      <td> {dbo_echo dbo="logdbo" field="id"} </td>
    </tr>
    <tr>
      <th> {echo phrase="TYPE"}: </th>
      <td> {dbo_echo dbo="logdbo" field="type"} </td>
    </tr>
    <tr>
      <th> {echo phrase="MODULE"}: </th>
      <td> {dbo_echo dbo="logdbo" field="module"} </td>
    </tr>
    <tr>
      <th> {echo phrase="MESSAGE"}: </th>
      <td> {dbo_echo dbo="logdbo" field="text"} </td>
    </tr>
    <tr>
      <th> {echo phrase="USERNAME"}: </th>
      <td> {dbo_echo dbo="logdbo" field="username"} </td>
    </tr>
    <tr>
      <th> {echo phrase="REMOTE_IP_ADDRESS"}: </th>
      <td> {dbo_echo dbo="logdbo" field="remoteipstring"} </td>
    </tr>
    <tr>
      <th> {echo phrase="DATE"}: </th>
      <td> {dbo_echo|datetime dbo="logdbo" field="date"} </td>
    </tr>
    <tr class="footer">
      <td colspan="2">
        {form name="view_log_message"}
          {form_element field="back"}
        {/form}
      </td>
    </tr>
  </table>
</div>
