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

  <div id="info" name="[USER_INFO]" width="80">
    <div class="action">
      <p class="header">Actions</p>
      {form name="edit_user_action"}
        {form_element field="delete"}
      {/form}
    </div>

    {form name="edit_user"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [EDIT_USER]: {dbo_echo dbo="edit_user_dbo" field="username"} </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="left"/>
              <td class="right"> 
                <input type="submit" value="Update User"/> 
              </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="type"} </th>
              <td> {form_element dbo="edit_user_dbo" field="type"} </td>
            </tr>
            <tr>
              <th> {form_description field="contactname"} </th>
              <td> {form_element dbo="edit_user_dbo" field="contactname" size="30"} </td>
            </tr>
            <tr>
              <th> {form_description field="email"} </th>
              <td> {form_element dbo="edit_user_dbo" field="email" size="30"} </td>
            </tr>
            <tr>
              <th> {form_description field="language"} </th>
              <td> {form_element dbo="edit_user_dbo" field="language"} </td>
            </tr>
            <tr>
              <th> {form_description field="theme"} </th>
              <td> {form_element dbo="edit_user_dbo" field="theme"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div>

  <div id="password" name="[PASSWORD]" width="80">
    {form name="edit_user_pass"}
      <div class="form">
        <table>
          <thead>
            <tr>
              <th colspan="2"> [RESET_PASSWORD] </th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td/>
              <td class="right"> <input type="submit" value="Reset Password"/> </td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <th> {form_description field="password"} </th>
              <td> {form_element field="password" size="20"} </td>
            </tr>
            <tr>
              <th> {form_description field="repassword"} </th>
              <td> {form_element field="repassword" size="20"} </td>
            </tr>
          </tbody>
        </table>
      </div>
    {/form}
  </div> 
</div>
