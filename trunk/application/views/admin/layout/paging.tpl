<del class="container">
<div class="pagination">
  <div class="limit">{'page_display'|lang_line} #
    <select name="limit" id="limit" class="inputbox" size="1" onchange="this.form.page.value=1;submitformget();">
      <option value="5" {if ($page_information.limit == 5)}selected="selected"{/if}>5</option>
      <option value="20" {if ($page_information.limit == 20)}selected="selected"{/if}>20</option>
      <option value="50" {if ($page_information.limit == 50)}selected="selected"{/if}>50</option>
      <option value="100" {if ($page_information.limit == 100)}selected="selected"{/if}>100</option>
      <option value="1000000" {if ($page_information.limit == 1000000)}selected="selected"{/if}>{'page_all'|lang_line}</option>
    </select>
  </div>
  {if ($page_information.current_page > 1)}
  <div class="button2-right">
    <div class="start"><a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.first_page}">{'page_first'|lang_line}</a></div>
  </div>
  {else}
  <div class="button2-right off">
    <div class="start"><span>{'page_first'|lang_line}</span></div>
  </div>
  {/if} 
  {if ($page_information.current_page > 1)}
  <div class="button2-right">
    <div class="prev"><a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.previous_page}">{'page_previous'|lang_line}</a></div>
  </div>
  {else}
  <div class="button2-right off">
    <div class="start"><span>{'page_previous'|lang_line}</span></div>
  </div>
  {/if}
  <div class="button2-left">
    <div class="page"> {foreach name=pages from=$page_information.all_pages item=page}
      {if $page == $page_information.current_page} <span>{$page}</span> {else} <a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page}">{$page}</a> {/if}
      {/foreach} </div>
  </div>
  {if ($page_information.current_page < $page_information.last_page)}
  <div class="button2-left">
    <div class="next"><a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.next_page}">{'page_next'|lang_line}</a></div>
  </div>
  {else}
  <div class="button2-left off">
    <div class="next"><span>{'page_next'|lang_line}</span></div>
  </div>
  {/if}
  {if ($page_information.current_page < $page_information.last_page)}
  <div class="button2-left">
    <div class="end"><a href="{$index_page_name|site_url}?{$page_information.query_string_paging}&page={$page_information.last_page}">{'page_end'|lang_line}</a></div>
  </div>
  {else}
  <div class="button2-left off">
    <div class="end"><span>{'page_end'|lang_line}</span></div>
  </div>
  {/if}
  <div class="limit">{'page_total'|lang_line}: {$page_information.count} {'page_records'|lang_line}</div>
  <input type="hidden" name="page" value="{$page_information.current_page}" />
</div>
</del>