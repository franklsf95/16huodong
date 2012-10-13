<del class="container">
<div class="pagination">
  <div class="limit">__('page_display'|lang_line)__ #
    <select name="limit" id="limit" class="inputbox" size="1" onchange="this.form.page.value=1;submitformget();">
      <option value="5" __(if ($page_information.limit == 5))__selected="selected"__(/if)__>5</option>
      <option value="20" __(if ($page_information.limit == 20))__selected="selected"__(/if)__>20</option>
      <option value="50" __(if ($page_information.limit == 50))__selected="selected"__(/if)__>50</option>
      <option value="100" __(if ($page_information.limit == 100))__selected="selected"__(/if)__>100</option>
      <option value="1000000" __(if ($page_information.limit == 1000000))__selected="selected"__(/if)__>__('page_all'|lang_line)__</option>
    </select>
  </div>
  __(if ($page_information.current_page > 1))__
  <div class="button2-right">
    <div class="start"><a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.first_page)__">__('page_first'|lang_line)__</a></div>
  </div>
  __(else)__
  <div class="button2-right off">
    <div class="start"><span>__('page_first'|lang_line)__</span></div>
  </div>
  __(/if)__ 
  __(if ($page_information.current_page > 1))__
  <div class="button2-right">
    <div class="prev"><a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.previous_page)__">__('page_previous'|lang_line)__</a></div>
  </div>
  __(else)__
  <div class="button2-right off">
    <div class="start"><span>__('page_previous'|lang_line)__</span></div>
  </div>
  __(/if)__
  <div class="button2-left">
    <div class="page"> __(foreach name=pages from=$page_information.all_pages item=page)__
      __(if $page == $page_information.current_page)__ <span>__($page)__</span> __(else)__ <a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page)__">__($page)__</a> __(/if)__
      __(/foreach)__ </div>
  </div>
  __(if ($page_information.current_page < $page_information.last_page))__
  <div class="button2-left">
    <div class="next"><a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.next_page)__">__('page_next'|lang_line)__</a></div>
  </div>
  __(else)__
  <div class="button2-left off">
    <div class="next"><span>__('page_next'|lang_line)__</span></div>
  </div>
  __(/if)__
  __(if ($page_information.current_page < $page_information.last_page))__
  <div class="button2-left">
    <div class="end"><a href="__($index_page_name|site_url)__?__($page_information.query_string_paging)__&page=__($page_information.last_page)__">__('page_end'|lang_line)__</a></div>
  </div>
  __(else)__
  <div class="button2-left off">
    <div class="end"><span>__('page_end'|lang_line)__</span></div>
  </div>
  __(/if)__
  <div class="limit">__('page_total'|lang_line)__: __($page_information.count)__ __('page_records'|lang_line)__</div>
  <input type="hidden" name="page" value="__($page_information.current_page)__" />
</div>
</del>