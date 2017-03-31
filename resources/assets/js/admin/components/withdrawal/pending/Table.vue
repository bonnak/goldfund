<template>
	<md-table-card>
		<div class="search">
		  	<input type="text" 
                class="form-control input-sm" 
                placeholder="Search ..." 
                v-model="search_query" 
                @keyup="searchData">		
		</div>
    	<md-table @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		    	<md-table-head>Username</md-table-head>
		    	<md-table-head>Email</md-table-head>
		    	<md-table-head>Amount</md-table-head>
		    	<md-table-head>Status</md-table-head>
		    	<md-table-head>Bitcoin Address</md-table-head>
		    	<md-table-head>Created Date</md-table-head>
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
		        	<span class="label label-sm label-success" v-if="el.status == 1">Approved</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 2">Canceled</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 3">Canceled by user</span>
		        </md-table-cell>
		        <md-table-cell>
		        	<a class="btn" href="#" @click.stop.prevent="openDialog(el)">
		        		<i class="fa fa-eye"></i>
		        	</a>
		        </md-table-cell>		        
		        <md-table-cell>{{ el.created_at }}</md-table-cell>
		        <md-table-cell class="flex-end-action">
		        	<md-button 
		        		class="md-fab md-primary md-mini"
		        		@click.native="openConfirmApprove(el)"
		        		v-if="el.status == 0">
					    	<i class="fa fa-check"></i>
					    	<md-tooltip md-direction="top">Approve</md-tooltip>
					</md-button>
					<md-button 
		        		class="md-fab md-danger md-mini"
		        		@click.native="openConfirmCancel(el)"
		        		v-if="el.status === 0">
					    	<i class="fa fa-close"></i>
					    	<md-tooltip md-direction="top">Cancel</md-tooltip>
					</md-button>
		        </md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>

		<md-table-pagination v-if="pagination.per_page <= pagination.total"
		    :md-size="pagination.per_page"
		    :md-total="pagination.total"
		    :md-page="pagination.current_page"
		    :md-page-options="[10, 50, 100]"
		    md-label="Per page"
		    @pagination="onPagination">
		</md-table-pagination>
		
		<md-dialog-alert
		  :md-content-html="contentHtml"
		  md-ok-text="Close"
		   @close="onCloseDlg"
		  ref="dialog_bitcoin_address">
		</md-dialog-alert>

		<md-dialog md-open-from="#fab" md-close-to="#fab" :ref="'dialog_approve'">
			<md-dialog-title>
				<span><i class="fa fa fa-check-circle icon-success"></i> Warning</span>
			</md-dialog-title>
			<md-dialog-content>Are you sure want to approve?</md-dialog-content>
			<md-dialog-actions>
		    	<md-button class="md-primary" @click.native="confirmApprove()">Yes</md-button>
		    	<md-button class="md-primary" @click.native="rejectApprove()">No</md-button>
			</md-dialog-actions>
		</md-dialog>

		<md-dialog md-open-from="#fab" md-close-to="#fab" :ref="'dialog_cancel'">
			<md-dialog-title>
				<span><i class="fa fa-exclamation-triangle icon-danger"></i> Warning</span>
			</md-dialog-title>
			<md-dialog-content>Are you sure want to cancel?</md-dialog-content>
			<md-dialog-actions>
		    	<md-button class="md-primary" @click.native="confirmCancel()">Yes</md-button>
		    	<md-button class="md-primary" @click.native="rejectCancel()">No</md-button>
			</md-dialog-actions>
		</md-dialog>
  </md-table-card>
</template>

<script>
import _ from 'lodash'
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../../core/mixins/table'

export default{

	mixins: [_mixin],

	data(){
		return {
			contentHtml : '<div></div>',
			search_query: '',
			canceling_data: null,
			approving_data: null
		}
	},

	computed: {
	    ...mapGetters({
	      data_grid: 'withdrawal/pending',
	      pagination: 'withdrawal/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	mounted(){
	},

	methods:{
		...mapActions({
	  		fetchData: 'withdrawal/getPending',
	  		approveWithdrawal: 'withdrawal/approve',
	  		cancelWithdrawal: 'withdrawal/cancel',
	  	}),

	  	openDialog(data)
	  	{
	  		this.contentHtml = '<div style="width: 100%; text-align: center;"><b>Bitcoin address</b></div>' +
	  					'<div style="width: 100%; text-align: center;">'+ data.owner.bitcoin_account + '</div>';
	  		this.$refs['dialog_bitcoin_address'].open();
	  	},

	    onCloseDlg(type) {
	    	this.contentHtml = '<div></div>'
	    },

	    searchData: _.debounce(function () {
            this.fetchData(this.search_query);
        }, 500),

        openConfirmCancel(data){
        	this.canceling_data = data;
        	this.$refs['dialog_cancel'].open();
        },

        confirmCancel(){
        	this.cancelWithdrawal(this.canceling_data);  
        	this.canceling_data = null;      	
        	this.$refs['dialog_cancel'].close();
        },

        rejectCancel(){
        	this.canceling_data = null;
        	this.$refs['dialog_cancel'].close();
        },

        openConfirmApprove(data){
        	this.approving_data = data;
        	this.$refs['dialog_approve'].open();
        },

        confirmApprove(){
			this.approveWithdrawal(this.approving_data);  
        	this.approving_data = null;      	
        	this.$refs['dialog_approve'].close();
        },

        rejectApprove(){
        	this.approving_data = null;
        	this.$refs['dialog_approve'].close();
        }
	}
}
</script>

<style lang="scss" scoped>
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

.search{
    position: relative;
    right: 0;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    width: 100%;

    input{
        border-radius: 20px;
        width: 250px;
    }

    span{
        border: none;
        background: transparent;
        padding: 0 0 0 5px;
        font-size: 22px;
        display: inline-block;
        margin-right: 15px;
    }
}
</style>