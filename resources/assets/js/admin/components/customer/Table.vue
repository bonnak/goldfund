<template>
	<md-table-card>
		<md-layout md-gutter>
			<md-layout>
				<md-button class="btn-refresh" @click.native="reloadData">
					<i class="fa fa-refresh"></i>
					<md-tooltip md-direction="bottom">Refresh</md-tooltip>
				</md-button>
			</md-layout>
			<md-layout></md-layout>
			<md-layout>
		  		<div class="search">
		  			<input type="text" 
                		class="form-control input-sm" 
                		placeholder="Search ..." 
                		v-model="query_search">		
				</div>
			</md-layout>
		</md-layout>
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
			<md-table-pagination v-if="pagination.per_page <= pagination.total"
				ref="pagination"
			    :md-size="pagination.per_page"
			    :md-total="pagination.total"
			    :md-page="pagination.current_page"
			    :md-page-options="[10, 50, 100]"
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
	      data_grid: 'customer/data',
	      pagination: 'customer/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	mounted(){
	},

	methods:{
		...mapActions({
  			fetchData: 'customer/fetchData'
  		})
	}
}
</script>