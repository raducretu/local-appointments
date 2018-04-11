//@codekit-prepend "dummy.js";
//@codekit-prepend "vue.filters.js";
//@codekit-prepend "../libs/sortable/Sortable.min.js";
//@codekit-prepend "../libs/sortable/vuedraggable.min.js";

//@codekit-prepend "global.mixins.js";
//@codekit-prepend "/json/currencies.js";
//@codekit-prepend "/routes/services.js";
//@codekit-prepend "/routes/service.js";
//@codekit-prepend "/routes/dashboard.js";
//@codekit-prepend "/routes/notification.js";
//@codekit-prepend "/routes/notifications.js";
//@codekit-prepend "/routes/appearance.js";
//@codekit-prepend "/routes/settings.js";
//@codekit-prepend "/routes/global/navigation.js";
//@codekit-prepend "/components/availability.js";
//@codekit-prepend "/components/shortcode-services.js";
//@codekit-prepend "/components/shortcode-services-choose-service.js";
//@codekit-prepend "/components/shortcode-services-choose-day.js";
//@codekit-prepend "/components/shortcode-services-choose-time.js";
//@codekit-prepend "/components/shortcode-services-choose-details.js";

if (typeof(document.getElementById("local-appointments")) != 'undefined' && document.getElementById("local-appointments") != null){

  ELEMENT.locale(window.local_appointments_locale.element_ui);

  const yoogapp_routes = [

    { path: '/', name: 'dashboard', component: { template: '#local-appointments-template__dashboard', mixins: [ AppWpMixinsDummy, AppWpMixinsRoutesDashboard ] }  },
    { path: '/settings/', name: 'settings', component: { template: '#local-appointmentstemplate__settings', mixins: [ AppWpMixinsRoutesSettings ] }  },
    { path: '/services/', name: 'services', component: { template: '#locapp-template__services', mixins: [ AppWpMixinsRoutesServices ] }  },
    { path: '/services/new', name: 'new-service', component: { template: '#locapp-template__new-service', mixins: [ AppWpMixinsRoutesNewService ] }  },
    {
      path: '/services/edit/:id',
      name: 'service',
      component: {
        template: '#locapp-template__new-service',
        mixins: [ AppWpMixinsRoutesNewService ],

      },
      props: true
    },
    { path: '/notifications/', name: 'notifications', component: { template: '#local-appointmentstemplate__notifications', mixins: [ AppWpMixinsDummy, AppWpMixinsRoutesNotifications ] }  },
    { path: '/notifications/new', name: 'new-notification', component: { template: '#local-appointmentstemplate__new-notification', mixins: [ AppWpMixinsRoutesNotification ] }  },
    {
      path: '/notifications/edit/:id',
      name: 'notification',
      component: {
        template: '#local-appointmentstemplate__new-notification',
        mixins: [ AppWpMixinsRoutesNotification ],

      },
      props: true
    },
    {
     path: '/appearance/', name: 'appearance', component: { template: '#locaapp-template__appearance', mixins: [ AppWpMixinsRoutesAppearance ] }
    }
  ];

  const router = new VueRouter({
    routes: yoogapp_routes
  });

  var AppWp = new Vue({
    el: '#local-appointments',
    router: router,
    data: function() {
      return {
        services: [],
        services_total: 0,
        notifications: [],
        notifications_total: 0,
        loading: false
      }
    }
  });

}
