<ul id="tabnav">
  <li> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li class="selected"> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> {echo phrase="PAYMENT_GATEWAY"} </a> </li>
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
