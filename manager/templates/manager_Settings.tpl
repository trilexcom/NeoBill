<ul id="tabnav">
  <li class="selected"> <a href="manager_content.php?page=settings&action=general"> [GENERAL] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=themes"> [THEMES] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=billing"> [BILLING] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=dns"> [DNS] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=locale"> [LOCALE] </a> </li>
  <li> <a href="manager_content.php?page=settings&action=payment_gateway"> [PAYMENTS] </a> </li>
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
      <tr>
        <th> {form_description field="notification_email"} </th>
        <td> {form_element field="notification_email" value="$company_notification_email" size="30"} </td>
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

<h2> {echo phrase="ORDER_CONFIRMATION_EMAIL"} </h2>
<div class="form">
  {form name="settings_confirmation"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="subject"} </th>
        <td> {form_element field="subject" value="$confirmation_subject" size="40"} </td>
      </tr>
      <tr>
        <th colspan="2"> {form_description field="email"} </th>
      </tr>
      <tr>
        <td colspan="2"> {form_element field="email" value="$confirmation_email" cols="80" rows="10"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<h2> {echo phrase="ORDER_NOTIFICATION_EMAIL"} </h2>
<div class="form">
  {form name="settings_notification"}
    <table style="width: 95%">
      <tr>
        <th> {form_description field="subject"} </th>
        <td> {form_element field="subject" value="$notification_subject" size="40"} </td>
      </tr>
      <tr>
        <th colspan="2"> {form_description field="email"} </th>
      </tr>
      <tr>
        <td colspan="2"> {form_element field="email" value="$notification_email" cols="80" rows="10"} </td>
      </tr>
      <tr class="footer">
        <td colspan="2">
          {form_element field="save"}
        </td>
      </tr>
    </table>
  {/form}
</div>
