<div class="topbar">
  <div class="container">
    <div class="row">

      <div class="topbar-left">
        <div id="top_bar_info"> {{ render_block('topbarinfo') }} </div>
        <div id="top_bar_lang"> {{ render_block('dropdownlanguage') }} </div>
      </div>

      <div class="topbar-right col-sm-4 col-xs-6">
        <div id="top_bar_user">
          {% if custom_account == '' %}
            <div class="login_link">  
              <a href="{{ login_link }}">{{'Login'|t}}</a>
            </div>  
          {% else %}
            {{ render_block('useraccountmenu') }} 
          {% endif %}  
        </div>
        <div class="social-list">
          {% if custom_social_link.facebook %}
            <a href="{{custom_social_link.facebook}}"><i class="fa fa-facebook"></i></a>
          {% endif %}
          {% if custom_social_link.twitter %}
            <a href="{{custom_social_link.twitter}}"><i class="fa fa-twitter-square"></i></a>
          {% endif %}
          {% if custom_social_link.skype %}
            <a href="{{custom_social_link.skype}}"><i class="fa fa-skype"></i></a>
          {% endif %}
          {% if custom_social_link.instagram %}
            <a href="{{custom_social_link.instagram}}"><i class="fa fa-instagram"></i></a>
          {% endif %}
          {% if custom_social_link.dribbble %}
            <a href="{{custom_social_link.dribbble}}"><i class="fa fa-dribbble"></i></a>
          {% endif %}
          {% if custom_social_link.linkedin %}
            <a href="{{custom_social_link.linkedin}}"><i class="fa fa-linkedin-square"></i></a>
          {% endif %}
          {% if custom_social_link.pinterest %}
            <a href="{{custom_social_link.pinterest}}"><i class="fa fa-pinterest"></i></a>
          {% endif %}
          {% if custom_social_link.google %}
            <a href="{{custom_social_link.google}}"><i class="fa fa-google-plus-square"></i></a>
          {% endif %}
          {% if custom_social_link.youtube %}
            <a href="{{custom_social_link.youtube}}"><i class="fa fa-youtube-square"></i></a>
          {% endif %}
          {% if custom_social_link.vimeo %}
            <a href="{{custom_social_link.vimeo}}"><i class="fa fa-vimeo-square"></i></a>
          {% endif %}
          {% if custom_social_link.tumblr %}
            <a href="{{custom_social_link.tumblr}}"><i class="fa fa-tumblr-square"></i></a>
          {% endif %}
        </div>
      </div>

    </div>
  </div>
</div>
