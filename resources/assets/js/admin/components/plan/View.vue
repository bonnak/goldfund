<template>
	<md-card class="content-form">
		<md-card-header>
      <div class="md-title">Plan Package Detail</div>
    </md-card-header>
		<md-card-content class="content-body">
      <div class="row">
        <div class="col-md-4 sec-block">
        	<dl class="dl-horizontal">
        		<dt>Name</dt>
        		<dd>{{ data.name }}</dd>
      		</dl>
      		<dl class="dl-horizontal">
        		<dt>Min Deposit</dt>
        		<dd>{{ data.min_deposit | currency }}</dd>
      		</dl>
      		<dl class="dl-horizontal">
        		<dt>Max Deposit</dt>
        		<dd>{{ data.max_deposit | currency }}</dd>
      		</dl>
        </div>
        <div class="col-md-4 sec-block">
      		<dl class="dl-horizontal">
        		<dt>Daily</dt>
        		<dd>{{ data.daily | percentage }}</dd>
      		</dl>
      		<dl class="dl-horizontal">
        		<dt>Binary Earning</dt>
        		<dd>{{ data.pairing | percentage }}</dd>
      		</dl>
      		<dl class="dl-horizontal">
        		<dt>Earning Duration</dt>
        		<dd>{{ data.duration | pluralize('day') }}</dd>
      		</dl>
        </div>
        <div class="col-md-4 sec-block">
          <dl class="dl-horizontal">
            <dt>Sponsor</dt>
            <dd>{{ data.sponsor | percentage }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Level</dt>
            <dd v-for="level in data.sponsor_levels">
              {{ level.level }} -> {{ level.commission | percentage }}
            </dd>
          </dl>
        </div>
      </div>
    </md-card-content>
    <md-card-actions class="space-between">
	    <md-button class="md-primary" @click.native="showEdit(data)">Edit</md-button>
      <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
	  </md-card-actions>
  </md-card>
</template>

<script>
import { mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

	mixins: [_mixin],

	props: ['data'],

	methods:{
		...mapActions({
  	})
	}
}
</script>


<style lang="scss" scoped>
.sec-block{
	padding: 0;
}
</style>