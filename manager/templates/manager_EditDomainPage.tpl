{form name="edit_domain"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <td colspan="2"> [EDIT_DOMAIN] </td>
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
      </tbody>
    </table>
  </div>
{/form}

{form name="renew_domain"}
  <div class="form">
    <table>
      <thead>
        <tr>
          <th colspan="2"> [RENEW_DOMAIN] </th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td class="left"/>
          <td class="right">
            {form_element field="continue"}
          </td>
        </tr>
      </tfoot>
      <tbody>
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
      </tfoot>
    </table>
  </div>
{/form}
