<template>
	<md-table-card>
    <md-table @select="onSelect" @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		      <md-table-head>Name</md-table-head>
		      <md-table-head>Min Deposit</md-table-head>
		      <md-table-head>Max Deposit</md-table-head>
		      <md-table-head>Daily Earning</md-table-head>
		      <md-table-head>Binary Earning</md-table-head>
		      <md-table-head>Earning Duration</md-table-head>
		      <md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(data, rowIndex) in data_grid" :key="rowIndex" :md-item="data">
		      <md-table-cell>{{ data.name }}</md-table-cell>
		      <md-table-cell>{{ data.min_deposit | currency }}</md-table-cell>
		      <md-table-cell>{{ data.max_deposit | currency }}</md-table-cell>
		      <md-table-cell>{{ data.daily | percentage }}</md-table-cell>
		      <md-table-cell>{{ data.pairing | percentage }}</md-table-cell>
		      <md-table-cell>{{ data.duration | pluralize('day') }}</md-table-cell>
		      <md-table-cell>
		        <a href="" class="btn" @click.stop.prevent="showViewInfo(data)"><i class="fa fa-eye"></i></a>
		      </md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>
		<md-table-pagination v-if="pagination.per_page <= pagination.total"
	    :md-size="pagination.per_page"
	    :md-total="pagination.total"
	    :md-page="pagination.current_page"
	    :md-page-options="[5, 10, 25, 50]"
	    md-label="Per page"
	    @pagination="onPagination">
	  </md-table-pagination>
  </md-table-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{
	mixins: [_mixin],

	computed: {
	    ...mapGetters({
	      data_grid: 'plan/data',
	      pagination: 'plan/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	methods:{
		...mapActions({
  		fetchData: 'plan/fetchData'
  	})
	}
}
</script>