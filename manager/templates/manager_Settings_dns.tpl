<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> [GENERAL] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=themes"> [THEMES] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> [BILLING] </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=dns"> [DNS] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> [LOCALE] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> [PAYMENTS] </a> </li>
</ul>

<h2> {echo phrase="NAME_SERVERS"} </h2>
<div class="form">
  {form name="settings_nameservers"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="nameservers_ns1"} </th>
        <td> {form_element field="nameservers_ns1" value="$nameservers_ns1" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="nameservers_ns2"} </th>
        <td> {form_element field="nameservers_ns2" value="$nameservers_ns2" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="nameservers_ns3"} </th>
        <td> {form_element field="nameservers_ns3" value="$nameservers_ns3" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="nameservers_ns4"} </th>
        <td> {form_element field="nameservers_ns4" value="$nameservers_ns4" size="40"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
