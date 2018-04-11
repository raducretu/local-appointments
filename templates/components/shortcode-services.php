<script type="text/x-template" id="locapp-template__component__shortcode-services">
  <div class="loc-app-shortcode-services">
    <div v-if="choose_service === true && options.services">
      <local-appointmentsshortcode-services-choose-service
        :options="options.services"
        v-on:service-selected="openDay">
       </local-appointmentsshortcode-services-choose-service>
    </div>
    <div v-else-if="choose_day === true && options.days">
      <local-appointmentsshortcode-services-choose-day
        :options="options.days"
        :service="form.service"
        v-on:day-selected="openTime">
      </local-appointmentsshortcode-services-choose-day>
    </div>
    <div v-else-if="choose_time === true && options.time">
      <local-appointmentsshortcode-services-choose-time
        :options="options.time"
        :service="form.service"
        :day="form.day"
        v-on:time-selected="openDetails">
      </local-appointmentsshortcode-services-choose-time>
    </div>
    <div v-else-if="choose_details === true && options.details">
      <local-appointmentsshortcode-services-choose-details
        :options="options.details"
        :service="form.service"
        :day="form.day"
        :time="form.time"
        :fields="options.details.fields">
      </local-appointmentsshortcode-services-choose-details>
    </div>
  </div>
</script>
