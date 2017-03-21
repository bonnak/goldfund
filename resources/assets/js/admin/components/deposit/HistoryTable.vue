<template>
	<md-table-card>
    <md-table @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		    	<md-table-head>Username</md-table-head>
		    	<md-table-head>Amount</md-table-head>
		    	<md-table-head>Status</md-table-head>
		    	<md-table-head>Plan</md-table-head>
		    	<md-table-head>Bitcoin Account</md-table-head>
		    	<md-table-head>Deposited Date</md-table-head>
		    	<md-table-head>Issue Date</md-table-head>
		    	<md-table-head>Expire Date</md-table-head>
		    	<md-table-head>Bankslip</md-table-head>
		    	<md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
		    	<md-table-cell>{{ el.owner.username }}</md-table-cell>
		        <md-table-cell>{{ el.amount | currency }}</md-table-cell>
		        <md-table-cell>
		        	<span class="label label-sm label-warning" v-if="el.status == 0">Pending</span>
		        	<span class="label label-sm label-success" v-if="el.status == 1">Approved</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 2">Expired</span>
		        </md-table-cell>
		        <md-table-cell>{{ el.plan.name }}</md-table-cell>
		        <md-table-cell>{{ el.owner.bitcoin_account }}</md-table-cell>
		        <md-table-cell>{{ el.created_at }}</md-table-cell>
		        <md-table-cell>{{ el.issue_date }}</md-table-cell>
		        <md-table-cell>{{ el.expire_date }}</md-table-cell>
		        <md-table-cell>
		        	<a class="btn" href="#" @click.stop.prevent="openDialog(el.bankslip)"><i class="fa fa-eye"></i></a>
		        </md-table-cell>
		        <md-table-cell>
		        	<md-button 
		        		class="md-fab md-primary md-mini"
		        		@click.native="approveDeposit(el)"
		        		v-if="el.status == 0">
					    	<i class="fa fa-check"></i>
					</md-button>
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
import _mixin from '../../core/mixins/table'

export default{

	mixins: [_mixin],

	data(){
		return {
			contentHtml : '<div></div>'
		}
	},

	computed: {
	    ...mapGetters({
	      data_grid: 'deposit/data',
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
	  		fetchData: 'deposit/fetchData',
	  		approveDeposit: 'deposit/approve'
	  	}),

	  	openDialog(img)
	  	{
	  		this.contentHtml = '<img src="storage/' + img + '" style="max-width: 800px;">';
	  		this.$refs['dialog_blankslip'].open();
	  	},

	    onCloseDlg(type) {
	    	this.contentHtml = '<div></div>'
	    }
	}
}
</script>

<style lang="scss">
.md-theme-app{
	&.md-button{
		&.md-raised{
			width: 100%;
		}

		i{
		    display: block;
		    margin-left: -5px;
		    color: #fff;
		}
	}
}
</style>