<ul id="tabnav">
  <li class="selected"> <a href="manager_content.php?page=settings&action=general"> {echo phrase="GENERAL"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> {echo phrase="BILLING"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> {echo phrase="DNS"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> {echo phrase="LOCALE"} </a> </li>
  <li> <a href="manager_content.php?page=settings&action=order"> {echo phrase="ORDER_INTERFACE"} </a> </li>
</ul>

<h2> {echo phrase="COMPANY"} </h2>
<div class="form">
  {form name="settings_company"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="name"} </th>
        <td> {form_element field="name" value="$company_name" size="40"} </td>
      </tr>
      <tr>
        <th> {form_description field="email"} </th>
        <td> {form_element field="email" value="$company_email" size="30"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<h2> {echo phrase="WELCOME_EMAIL"} </h2>
<div class="form">
  {form name="settings_welcome"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="subject"} </th>
        <td> {form_element field="subject" value="$welcome_subject" size="40"} </td>
      </tr>
      <tr>
        <th colspan="2"> {form_description field="email"} </th>
      </tr>
      <tr>
        <td colspan="2"> {form_element field="email" value="$welcome_email" cols="80" rows="10"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
