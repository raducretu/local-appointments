<script type="text/x-template" id="locapp-template__component__shortcode-services-choose-day">
  <div :class="preview ? 'loc-app-sc-services' : ''" :data-preview="preview">
    <div v-if="service" class="loc-app-sc-services__days loc-app-sc-services__days--default">
      <div class="loc-app-sc-services__days-header">
        <div><a href="#" v-on:click.prevent="backToServices" class="app-wp__link"><i class="fa far fa-long-arrow-left fa-lg"></i>{{options.label_back}}</a></div>
        <h3><i :style="'color:' + service.color" class="fa fas fa-circle"></i> {{service.name}}</h3>
        <div><i style="color: #3ECF70" class="fa fas fa-circle"></i> {{options.label_available}}</div>
      </div>
      <div class="loc-app-sc-services__month" v-if="options.label_select_day"><h4>{{options.label_select_day}}</h4></div>
      <div class="loc-app-sc-services__days-filters" v-if="options.show_filters_days || options.show_filters_hours">
        <div class="loc-app-sc-services__days-filters__days"  v-if="options.show_filters_days">
          <label class="loc-app-sc-services__days-filters__filter loc-app-sc-services__days-filters__filter--day">
            <input type="radio" v-model="filter_day" :value="-1"><?php esc_html_e( 'Any Day', 'local-appointments' ) ?>
          </label>
          <label class="loc-app-sc-services__days-filters__filter loc-app-sc-services__days-filters__filter--day"  v-for="day in week">
            <input type="radio" v-model="filter_day" :value="day">{{getDayName(day)}}
          </label>
        </div>
        <div class="loc-app-sc-services__days-filters__hours" v-if="options.show_filters_hours">
          <div class="loc-app-sc-services__days-filters__filter loc-app-sc-services__days-filters__filter--hour">
            {{options.label_starting}}
            <select v-model="filter_time_starting">
              <option v-for="n in filter_starting_times" :disabled="filter_time_ending - service.duration < n" :value="n">{{n|toHours}}</option>
            </select>
          </div>
          <div class="loc-app-sc-services__days-filters__filter loc-app-sc-services__days-filters__filter--hour">
            {{options.label_ending}}
            <select v-model="filter_time_ending">
              <option v-for="n in filter_ending_times" :value="n" :disabled="service.duration + filter_time_starting > n">{{n|toHours}}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="loc-app-sc-services__days-list" :class="classes">
        <template v-for="(day, day_key) in days">
          <div v-if="isSameMonth(day,day_key)" class="loc-app-sc-services__month"><h4>{{day.date|moment("MMMM YYYY")}}</h4></div>
          <div class="loc-app-sc-services__day" :class="getDayClasses(day)" v-on:click="selectDay(day)">
            <div class="loc-app-sc-services__day__content">
              <i class="fa fas fa-circle"></i>
              <span class="loc-app-sc-services__day-name">{{day.date|moment("ddd")}}</span>
              <span class="loc-app-sc-services__day-number">{{day.date|moment("DD")}}</span>
            </div>
          </div>
        </template>
      </div>
      <div class="loc-app-sc-services__days-footer">
        <a href="#" v-on:click.prevent="showMore()">Show More Available Days</a>
      </div>
    </div>
  </div>
</script>
