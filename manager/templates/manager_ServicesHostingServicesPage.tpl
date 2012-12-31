<div class="manager_content"</div>
<div class="action">
  <p class="header">{echo phrase="ACTIONS"}</p>
  {form name="web_hosting_action"}
    {form_element field="add"}
  {/form}
</div>

<h2> {echo phrase="WEB_HOSTING_SERVICES"} </h2>
<div class="search">
  {form name="search_hosting_services"}
    <table>
      <tr>
        <th> {echo phrase="SEARCH"} </th>
        <td>
          {form_description field="title"} <br/>
          {form_element field="title" size="30"}
        </td>
        <td>
          {form_description field="description"} <br/>
          {form_element field="description" size="30"}
        </td>
        <td class="submit"> 
          {form_element field="search"}
        </td>
      </tr>
    </table>
  {/form}
</div>

<div class="table">
  {form name="hosting_services"}
    {form_table field="hosting_services"}

      {form_table_column columnid="id" header=""}
        <center> {form_table_checkbox option=$hosting_services.id} </center>
      {/form_table_column}

      {form_table_column columnid="title" header="[TITLE]"}
        <a target="content" href="manager_content.php?page=services_edit_hosting&hservice={$hosting_services.id}">{$hosting_services.title}</a>
      {/form_table_column}

      {form_table_column columnid="description" header="[DESCRIPTION]"}
        {$hosting_services.description|truncate:40:"..."}
      {/form_table_column}

      {form_table_column columnid="pricing" header="[PRICING]"}
        {$hosting_services.pricing}
      {/form_table_column}

      {form_table_column columnid="public" header="[PUBLIC]"}
        {$hosting_services.public}
      {/form_table_column}

      {form_table_footer}
        {form_element field="remove"}
      {/form_table_footer}

    {/form_table}
  {/form}
</div>