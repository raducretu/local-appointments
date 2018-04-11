var AppWpMixinsRoutesServices = {
  data: function(){
    return {
      services: [],
      multipleSelection: [],
      currentPage: 1,
      perPage: 9,
      total: 0,
      loading: false,
    }
  },
  computed: {
    services_total: function(){
      return this.$router.app.services_total;
    }
  },
  mounted: function(){
    var vm = this;
    if( vm.$router.app.services.length === 0 ) vm.getServices();

  },
  methods: {
    getServices: function(){
      var vm = this;
      vm.loading = true;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.services + '?status=any&page=' + vm.currentPage + "&per_page=" + vm.perPage,
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
        console.log(response);
        vm.services = _.map( response.body, vm.normalizeService );
        vm.total = parseInt( response.headers.map['x-wp-total'] );
        vm.loading = false;
      }, function(response){
        console.log(response);
        vm.loading = false;
      });
    },
    handleSizeChange: function(val) {
      var vm = this;
      vm.perPage = val;
      vm.getServices();
    },
    handleCurrentChange: function(val) {
      var vm = this;
      vm.currentPage = val;
      console.log(val, vm.currentPage);
      vm.getServices();
    },
    handleCommand: function(com){
      var vm = this;
      if( com.method === 'delete' ){
        vm.deleteService(com.service.id);
      }
      else if( com.method === 'edit' ){
        vm.$router.push({ name: 'service', params: { id: com.service.id, service: com.service } });
      }
      else if( com.method === 'duplicate' ){
        var duplicate = _.filter( vm.services, function(o){
          return o.id === com.service.id;
        });
        if( ! _.isUndefined( duplicate[0] ) ){
          delete duplicate[0].id;
          vm.duplicateService(duplicate[0]);
        }
      }
    },
    duplicateService: function(duplicate){
      var vm = this;
      vm.loading = true;
      vm.$http.post(
        window.local_appointments_locale.rest_api_base.services,
        duplicate, {
        emulateJSON: true,
        headers: {
          'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
        }
      }).then(function(response){
        console.log(response);
        if( response.status === 201 ){
          vm.$message({
            type: 'success',
            message: 'Service created succesfully'
          });
          vm.services.unshift( response.body );
        } else {
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
    deleteService: function(id){
      var vm = this;

      vm.$http.delete(
        window.local_appointments_locale.rest_api_base.services + id + '/?force=true',
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
        console.log(response);
        if( response.status === 200 && response.body.deleted ){
          vm.getServices();
          vm.$message({
            type: 'success',
            message: 'Service deleted succesfully'
          });
        }
      }, function(response){
        console.log(response);
        vm.$message({
          type: 'danger',
          message: 'Could not delete service. Please try again'
        });
      });

    },
    handleSelectionChange: function(val) {
      this.multipleSelection = val;
    },
    routeTo: function(route){
      this.$router.push(route);
    }
  }
}
