var AppWpMixinsRoutesNotification = {
  props: ['id','notification'],
  data: function(){
    var vm = this;
    return {
      form: false,
      form_witness: {},
      loading: false,
      preview_email: {},
      dialog_preview_email: false
    }
  },
  mounted: function(){
    var vm = this;

    vm.form = vm.normalize( vm.models.notification );
    vm.form_witness = vm.normalize( vm.form );

    if( ! _.isUndefined( vm.id ) && ! _.isUndefined( vm.notification ) ){
      vm.form = vm.normalize( vm.notification );
      vm.form_witness = vm.normalize( vm.notification );
    } else if( ! _.isUndefined( vm.id ) && _.isUndefined( vm.notification ) ){
      vm.loading = true;
      vm.getNotification();
    }


  },
  methods: {
    showEmailPreview: function(email){
      var vm = this;
      vm.dialog_preview_email = true;
      vm.preview_email = vm.normalize( vm.form );
      vm.preview_email.sent_date = moment().format('D MMMM YYYY [at] HH:mm');
      vm.preview_email.recipient = 'Alexander McQueen';
    },
    previewEmail: function(f, ret){
      var vm = this;
      var dummy = {
        event_name : 'Yoga Class',
        team_member_name: 'John Doe',
        event_date: moment().format('MMMM D, YYYY'),
        event_time: moment().format('hh:mm a'),
        invitee_full_name: 'Alexander McQueen',
        event_description: '',
        location: '',
        questions_and_answers: ''
      };
      _.each(dummy, function(o,i){
        f = f.replace( new RegExp( '{{'+i+'}}' ), o);
      });
      return ret === false ? f : marked(f);
    },
    getNotification: function(){
      var vm = this;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.notifications + vm.id,
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
          console.log(response);
          if( response.status === 200 ){
            vm.form = response.body;
          }
          vm.loading = false;
          vm.form = vm.normalizeNotification(response.body);
          vm.form_witness = vm.normalize(vm.form);

      }, function(response){
        vm.loading = false;
        console.log(response);
      });
    },
    saveChanges: function(){
      var vm = this;
      vm.loading = true;
      if( _.isUndefined( vm.id ) && parseInt( vm.form.id ) === 0 ){
        delete vm.form.id;
      }
      vm.$http.post(
        window.local_appointments_locale.rest_api_base.notifications + ( ! _.isUndefined( vm.id ) && parseInt( vm.id ) > 0 ? vm.id : '' ),
        vm.form, {
        emulateJSON: true,
        headers: {
          'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
        }
      }).then(function(response){
        console.log(response);
        /* Created */
        if( response.status === 201 ){
          vm.$message({
            type: 'success',
            message: 'Notification created succesfully'
          });
          vm.$router.push({ name: 'notification', params: { id: response.body.id, notification: response.body }});
        }

        /* Updated */
        else if( response.status === 200 ){
          vm.form_witness = vm.normalize(response.body);
          vm.form = vm.normalize(response.body);

          console.log( vm.form, vm.form_witness );

          vm.$message({
            type: 'success',
            message: 'Service update succesfully'
          });
        }

        /* Error */
        else {
          vm.$message({
            type: 'danger',
            message: 'Something went wrong. Please try again'
          });
        }

        vm.loading = false;

      }, function(response){
        vm.$message({
          type: 'danger',
          message: 'Something went wrong. Please try again'
        });
        vm.loading = false;
        console.log(response);
      });
    },
    reventChanges: function(){
      var vm = this;
      vm.form = vm.normalize( vm.form_witness );
    },
    hasChanges: function(){
      var vm = this;
      return !_.isEqual(vm.normalize( vm.form ), vm.form_witness);
    },
    routeTo: function(route){
      route === -1 ? this.$router.go(route) : this.$router.push(route);
    }
  }
}
