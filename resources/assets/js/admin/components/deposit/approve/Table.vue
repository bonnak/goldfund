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
		    	<md-table-head>Email</md-table-head>
		    	<md-table-head>Amount</md-table-head>
		    	<md-table-head>Status</md-table-head>
		    	<md-table-head>Plan</md-table-head>
		    	<md-table-head>Bankslip</md-table-head>
		    	<md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
	    		<md-table-cell>{{ el.owner.username }}</md-table-cell>
	    		<md-table-cell>{{ el.owner.email }}</md-table-cell>
		        <md-table-cell>{{ el.amount | currency }}</md-table-cell>
		        <md-table-cell>
		        	<span class="label label-sm label-warning" v-if="el.status == 0">Pending</span>
		        	<span class="label label-sm label-success" v-if="el.status == 1">Approve</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 2">Cancele</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 3">Canceled by user</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 4">Expire</span>
		        </md-table-cell>
		        <md-table-cell>{{ el.plan.name }}</md-table-cell>
		        <md-table-cell>
		        	<a class="btn" href="#" @click.stop.prevent="openDialog(el)">
		        		<i class="fa fa-eye"></i>
		        		<md-tooltip md-direction="top">View bankslip</md-tooltip>
		        	</a>
		        </md-table-cell>
		        <md-table-cell class="flex-end-action">
					<md-button 
		        		class="md-fab md-green md-mini btn-action"
		        		@click.native="showViewInfo(el)">
					    	<i class="fa fa-eye"></i>
					    	<md-tooltip md-direction="top">View</md-tooltip>
					</md-button>
		        </md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>

		<md-table-pagination v-if="pagination.per_page <= pagination.total" 
			ref="pagination"
		    :md-size="pagination.per_page"
		    :md-total="pagination.total"
		    :md-page="pagination.current_page"
		    :md-page-options="[2, 10, 50, 100]"
		    md-label="Per page"
		    @pagination="onPagination">
		</md-table-pagination>
		
		<md-dialog-alert
		  :md-content-html="contentHtml"
		  md-ok-text="Close"
		   @close="onCloseDlg"
		  ref="dialog_blankslip">
		</md-dialog-alert>
  </md-table-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../../core/mixins/table'

export default{

	mixins: [_mixin],

	data(){
		return {
			contentHtml : '<div></div>',
			approving_data: null
		}
	},

	computed: {
	    ...mapGetters({
	      data_grid: 'deposit/approve',
	      pagination: 'deposit/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	mounted(){
	},

	methods:{
		...mapActions({
	  		fetchData: 'deposit/fetchApprove',
	  		approveDeposit: 'deposit/approve'
	  	}),

	  	openDialog(data)
	  	{
	  		this.contentHtml = '<div style="width: 100%; text-align: center;"><b>Bitcoin address</b></div>' +
	  					'<div style="width: 100%; text-align: center;">'+ data.owner.bitcoin_account + '</div>' + 
	  					'<img src="/' + data.bankslip + '" style="max-width: 800px;">';
	  		this.$refs['dialog_blankslip'].open();
	  	},

	    onCloseDlg(type) {
	    	this.contentHtml = '<div></div>'
	    }
	},

	watch:{
		
	}
}
</script>