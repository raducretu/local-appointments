<script type="text/x-template" id="locapp-template__component__shortcode-services-choose-time">
  <div :class="preview ? 'loc-app-sc-services' : ''" :data-preview="preview">
    <div v-if="service" class="loc-app-sc-services__times loc-app-sc-services__times--default">
      <div class="loc-app-sc-services__times-header">
        <div><a href="#" v-on:click.prevent="backToDays" class="app-wp__link"><i class="fa far fa-long-arrow-left fa-lg local-appointmentsm--right-05"></i>Back</a></div>
        <h3><i :style="'color:' + service.color" class="fa fas fa-circle"></i>{{service.name}} <small>{{ day | moment( date_format ) }} </small></h3>
        <div><i style="color: #3ECF70" class="fa fas fa-circle local-appointmentsm--left-05"></i> Available</div>
      </div>
      <div class="loc-app-sc-services__times-list">
        <div  class="loc-app-sc-services__month">
          <h4>Select Time</h4>
        </div>
        <template v-for="(time, time_key) in times">
          <div v-if="options.show_noon && isSamePeriod(time,time_key)" class="loc-app-sc-services__month"><h4>Noon</h4></div>
          <div class="loc-app-sc-services__time" :class="getTimeClasses(time)" v-on:click.prevent="confirmTime(time)">
            <div class="loc-app-sc-services__time__content">
              <i class="fa fas fa-circle"></i>
              <span class="loc-app-sc-services__time-name">{{time|toHours}}</span>
            </div>
            <div v-if="confirm_time === time" class="loc-app-sc-services__time__confirm" v-click-outside="clearConfirmation">
              <a href="#" class="loc-app-sc-services__time__confirm-button" v-on:click.prevent="confirmTime(time, true)">Confirm</a>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</script>
