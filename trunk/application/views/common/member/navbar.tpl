<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{'index'|site_url}"><img alt="16活动网" src="{$config.asset}/img/banner_logo.png"></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li id="navbar-index"><a href="{'index'|site_url}">首页</a></li>
              <li id="navbar-profile"><a href="{'profile'|site_url}">我的主页</a></li>
              <li id="navbar-activity"><a href="{'activity'|site_url}">挖活动</a></li>
              <li id="navbar-library"><a href="{'library'|site_url}">人生图书馆</a></li>
            </ul>
            <form class="navbar-search pull-right" action="{'search/query'|site_url}" method="post">
              <fieldset>
                <input type="text" class="search-query" placeholder="搜人、组织或公司~" name="member_name">
                <button type="submit" class="btn hidden">Search</button>
              </fieldset>
            </form>
            <a class="navbar-highlight" id="navbar-contact" href="{'contact_member'|site_url}">联系我们</a>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>