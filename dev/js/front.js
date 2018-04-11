//@codekit-prepend "vue.filters.js";
//@codekit-prepend "global.mixins.js";
//@codekit-prepend "/components/shortcode-services.js";
//@codekit-prepend "/components/shortcode-services-choose-service.js";
//@codekit-prepend "/components/shortcode-services-choose-day.js";
//@codekit-prepend "/components/shortcode-services-choose-time.js";
//@codekit-prepend "/components/shortcode-services-choose-details.js";

var app_wp_apps = [];

Array.prototype.forEach.call( document.querySelectorAll('div.app'), function(el, index){
  var id = el.getAttribute('id').replace( 'local-appointments-', '' );
  app_wp_apps[index] = new Vue({
    el: '#local-appointments-' + id,
    mounted: function() {

    },
    data: function(){
      return {
        form: {
          show_duration: false,
          show_price: false,
          days_limit: 14,
          time_increments: 15,
          show_noon: true
        },
      }
    }
  });
});
