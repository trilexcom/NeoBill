<div class="manager_content">

<div id="tabs">
<ul>
<li><a href="#tabs-1">General</a></li>
<li><a href="#tabs-2">Delete Pricing</a></li>
<li><a href="#tabs-3">Add/Update Price</a></li>
</ul>
<div id="tabs-1">
  <div id="general" name="[GENERAL]" width="80">
    {form name="edit_domain_service"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [DOMAIN_SERVICE] ([TLD]: .{dbo_echo dbo="domain_service_dbo" field="tld"}) </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left">
                {form_element field="cancel"}
              </td>
              <td class="right"> 
                {form_element field="save"}
              </td>
          </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="description"} </th>
              <td> {form_element dbo="domain_service_dbo" field="description" cols="40" rows="3"} </td>
            </tr>
            <tr>
              <th> {form_description field="modulename"} </th>
              <td> {form_element dbo="domain_service_dbo" field="modulename"} </td>
            </tr>
            <tr>
              <th> {form_description field="public"} </th>
              <td> {form_element dbo="domain_service_dbo" field="public" option="Yes"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div>

</div>
<div id="tabs-2">
  <div id="pricing" name="[PRICING]" width="80">
    {form name="edit_domain_pricing"}
      <div class="table">
        {form_table field="prices" style="width: 650px"}

          {form_table_column columnid="id" header=""}
            {form_table_checkbox option=$prices.id}
          {/form_table_column}

          {form_table_column columnid="type" header="[TYPE]"}
            {$prices.type}
          {/form_table_column}

          {form_table_column columnid="termlength" header="[TERM_LENGTH]"}
            {if $prices.type == "Onetime"}
              [N/A]
            {else}
              {$prices.termlength} [MONTHS]
            {/if}
          {/form_table_column}

          {form_table_column columnid="price" header="[PRICE]"}
            {$prices.price|currency}
          {/form_table_column}

          {form_table_column columnid="taxable" header="[TAXABLE]"}
            {$prices.taxable}
          {/form_table_column}

          {form_table_footer}
            {form_element field="delete"}
          {/form_table_footer}

        {/form_table}
      </div>
    {/form}

</div>
</div>
<div id="tabs-3">
    {form name="edit_domain_add_price"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="4"> [ADD_OR_UPDATE_PRICE] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td colspan="4" class="right"> {form_element field="add"} </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th style="width: 25%"> {form_description field="type"} </th>
              <th style="width: 25%"> {form_description field="termlength"} </th>
              <th style="width: 25%"> {form_description field="price"} </th>
              <th style="width: 25%"> {form_description field="taxable"} </th>
            </tr>
            <tr>
              <td style="width: 25%"> {form_element field="type"} </td>
              <td style="width: 25%"> {form_element field="termlength" size="4"} </td>
              <td style="width: 25%"> {form_element field="price" size="6"} </td>
              <td style="width: 25%"> {form_element field="taxable"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}  
  </div>
</div>
</div>
