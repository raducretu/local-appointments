var AppWpMixinsRoutesNewService = {
  props: ['id','service'],
  data: function(){
    var vm = this;
    return {
      form: false,
      form_witness: {},
      edit_rolling: false,
      loading: false,
      colors: [ '#F8C8C3', '#F5ACC3', '#EC0576', '#EB2026', '#A90035', '#A64B12', '#F8AA83', '#EF8C20', '#FABA18', '#FFE006', '#C2DC2F', '#90CB40', '#C9D7A7', '#158A52', '#0A684D', '#6CC9C6', '#107B85', '#ADE1EE', '#7FB0CB', '#0A63A4', '#04427B', '#C3C2E0', '#692091', '#546091', '#7A2082', '#949599', '#BAAB98', '#636466', '#4C3900', '#000000' ],

    }
  },
  mounted: function(){
    var vm = this;

    vm.form = vm.normalize( vm.models.service );
    vm.form_witness = vm.normalize( vm.form );

    if( ! _.isUndefined( vm.id ) && ! _.isUndefined( vm.service ) ){
      vm.form = vm.normalize( vm.service );
      vm.form_witness = vm.normalize( vm.service );
    } else if( ! _.isUndefined( vm.id ) && _.isUndefined( vm.service ) ){
      vm.loading = true;
      vm.getService();
    }

    var sticky = new Waypoint.Sticky({
      element: jQuery('.locapp-sticky-header .locapp-header' ),
      offset: 30
    })

  },
  methods: {
    getService: function(){
      var vm = this;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.services + vm.id,
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
          vm.form = vm.normalizeService(response.body);
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
        window.local_appointments_locale.rest_api_base.services + ( ! _.isUndefined( vm.id ) && parseInt( vm.id ) > 0 ? vm.id : '' ),
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
            message: 'Service created succesfully'
          });
          vm.$router.app.services.unshift( vm.normalizeService( response.body ) );
          vm.$router.push({ name: 'service', params: { id: response.body.id, service: response.body}});
        }

        /* Updated */
        else if( response.status === 200 ){
          vm.form_witness = vm.normalize(response.body);
          vm.form = vm.normalize(response.body);

          vm.$router.app.services = _.map( vm.$router.app.services, function(o){
            return o.id === response.body.id ? vm.normalizeService( response.body ) : o;
          });

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
