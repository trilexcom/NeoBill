<h2> {echo phrase="EDIT_DOMAIN"} </h2>
{form name="edit_domain"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> [DOMAIN_NAME]: </th>
        <td> {$domainDBO->getFullDomainName()}</td>
      </tr>
      <tr>
        <th> [ACTIVATION_DATE]: </th>
        <td> {$domainDBO->getDate()|datetime:date} </td>
      </tr>
      <tr>
        <th> {form_description field="term"} </th>
        <td> {form_element value=$domainDBO->getTermID() field="term"} </td>
      </tr>
      <tr>
        <th> {form_description field="nextbillingdate"} </th>
        <td> {form_element value=$domainDBO->getNextBillingDate() field="nextbillingdate"} </td>
      </tr>
      <tr>
        <th> {form_description field="note"} </th>
        <td> {form_element value=$domainDBO->getNote() field="note" rows=4 cols=50} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
          {form_element field="cancel"}
        </th>
      </tr>
    </table>
  </div>
{/form}

<h2> {echo phrase="RENEW_DOMAIN"} </h2>
{form name="renew_domain"}
  <div class="form">
    <table style="width: 70%">
      <tr>
        <th> {form_description field="term"} </th> 
        <td> {form_element field="term"} </td> 
      </tr>
      <tr>
        <th> {form_description field="date"} </th>
        <td> {form_element field="date"} </td>
      </tr>
      <tr>
        <th> {form_description field="registrar"} </th>
        <td> {form_element field="registrar" option="true"} </td>
      </tr>
      <tr class="footer">
        <th colspan="2">
          {form_element field="continue"}
        </th>
      </tr>
    </table>
  </div>
{/form}
