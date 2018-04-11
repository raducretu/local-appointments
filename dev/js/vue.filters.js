Vue.filter('moment', function (date, format) {
	return moment( date ).format(format);
});

Vue.filter('momentToNow', function (date, format) {
  var a = moment();
  var b = moment(date.replace(' ', ''));
  return a.to(b);
});

Vue.filter('toHours', function (minutes) {
	minutes = parseInt(minutes);

	var h = Math.floor( minutes / 60 );
			//h = h < 10 ? '0' + h : h;
	var m = minutes % 60;
			//m = m < 10 ? '0' + m : m;
	return moment().hour(h).minute(m).format( window.local_appointments_locale.time_format );
	return h + ':' + m;
});

Vue.filter('minToHours', function (minutes) {
	minutes = parseInt(minutes);
	var time  = '';
	var h = Math.floor( minutes / 60 );
	var m = minutes % 60;
	return h === 0 ? minutes + '\' ' : h + 'h ' + ( m === 0 ? '' : m + '\' ' );
});

Vue.directive('click-outside', {
  bind: function (el, binding, vnode) {
    el.event = function (event) {
      // here I check that click was outside the el and his childrens
      if (!(el == event.target || el.contains(event.target))) {
        // and if it did, call method provided in attribute value
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener('click', el.event)
  },
  unbind: function (el) {
    document.body.removeEventListener('click', el.event)
  },
});
