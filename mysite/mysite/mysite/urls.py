from django.conf.urls import patterns, include, url

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
    url(r'^hello/$', 'article.views.hello'),
    url(r'^prueba/$', 'article.views.ejemplo_template'),
    url(r'^search/$', 'search.views.basicSearch'),
    url(r'^search_titles/$','search.views.search_titles',name='search_titles'),
    url(r'^login/$', 'auth.views.login_user'),
    # url(r'^$', 'mysite.views.home', name='home'),
    # url(r'^mysite/', include('mysite.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # url(r'^admin/', include(admin.site.urls)),
)
