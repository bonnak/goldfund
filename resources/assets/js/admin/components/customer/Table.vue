<template>
	<md-table-card>
    <md-table @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		    	<md-table-head>Username</md-table-head>
		        <md-table-head>First Name</md-table-head>
		        <md-table-head>Last Name</md-table-head>
		        <md-table-head>Sponsor By</md-table-head>
		        <md-table-head>Created Date</md-table-head>
		        <md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
			    <md-table-cell>{{ el.username }}</md-table-cell>
		        <md-table-cell>{{ el.first_name }}</md-table-cell>
		        <md-table-cell>{{ el.last_name }}</md-table-cell>
		        <md-table-cell>{{ el.sponsor !== null ? el.sponsor.username : '' }}</md-table-cell>
		        <md-table-cell>{{ el.created_at }}</md-table-cell>
		        <md-table-cell>
			        <a href="" class="btn" @click.stop.prevent="showViewInfo(el)"><i class="fa fa-eye" aria-hidden="true"></i></a>
		        </md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>
		<md-table-pagination
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

export default{

	computed: {
	    ...mapGetters({
	      data_grid: 'customer/data',
	      pagination: 'customer/pagination'
	    })
	},

	created(){
		this.fetchData({ size : 5, page: 1});
	},

	mounted(){
	},

	methods:{
		onSelect(data){
		 	console.log(data);
		},

		onSort(data){
		 	console.log(data);
		},

		onPagination(pagination){
			this.loadData(pagination);
		},

		showViewInfo(data){
			this.$emit('show-view-info', data);
		},

		...mapActions({
	  		fetchData: 'customer/fetchData'
	  	})
	}
}
</script>