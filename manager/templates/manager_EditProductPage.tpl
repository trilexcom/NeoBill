<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXCommon.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar.js"></script>
<script type="text/javascript" src="../include/dhtmlxTabbar/js/dhtmlXTabbar_start.js"></script>

{if $tab != null}
  <script type="text/javascript">
    var activeTab = "{$tab}";
  </script>
{/if}

<div id="a_tabbar" 
     class="dhtmlxTabBar" 
     style="margin-top: 0.5em;"  
     imgpath="../include/dhtmlxTabbar/imgs/"
     skinColors="#FFFFFF,#F4F3EE">

  <div id="general" name="[GENERAL]" width="80">
    {form name="edit_product"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [PRODUCT] ([ID]: {dbo_echo dbo="product_dbo" field="id"}) </th>
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
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="name"} </th>
              <td> {form_element dbo="product_dbo" field="name" size="20"} </td>
            </tr>
            <tr>
              <th> {form_description field="description"} </th>
              <td> {form_element dbo="product_dbo" field="description" cols="40" rows="3"} </td>
            </tr>
            <tr>
              <th> {form_description field="public"} </th>
              <td> {form_element dbo="product_dbo" field="public" option="Yes"} </td>
            </tr>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div>

  <div id="pricing" name="[PRICING]" width="80">
    {form name="edit_product_pricing"}
      <div class="table">
        {form_table field="prices" style="width: 650px"}

          {form_table_column columnid="id" header=""}
            <center> {form_table_checkbox option=$prices.id} </center>
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

    {form name="edit_product_add_price"}
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