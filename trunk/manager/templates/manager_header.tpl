        <div class="content_mast">
          <h1>{$company_name}</h1>

          <p class="navigation">

            {* 
              Iterate through the location stack and produce a link
              for each item.  The last item does not have a link, but is
              printed.
            *}
            {section name="page" loop=$location_stack}

              {if $smarty.section.page.last}
                {$location_stack[page].name|capitalize}
              {else}
                <a href="{$location_stack[page].url}">{$location_stack[page].name|capitalize}</a> >
              {/if}

            {sectionelse}

              {echo phrase="HOME"}

            {/section}

          </p>

	  <p class="user_display">
            {echo phrase="LOGGED_IN_AS"}: {$username}
            (<a href="manager_content.php?page=home&action=logout">{echo phrase="LOGOUT"}</a>)
          </p>

          <p class="ip_display">
            {$version} {echo phrase="ON"} {$machine}
          </p>

        </div>
