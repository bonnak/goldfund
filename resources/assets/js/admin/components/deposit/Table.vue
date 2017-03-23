<template>
	<md-table-card>
		<div class="search">
		  	<input type="text" 
                class="form-control input-sm" 
                placeholder="Search ..." 
                v-model="search_query" 
                @keyup="searchData">
			<span class="input-group-addon"><i class="fa fa-search"></i></span>				
		</div>
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
		        	<span class="label label-sm label-success" v-if="el.status == 1">Approved</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 2">Expired</span>
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
		        		class="md-fab md-primary md-mini"
		        		@click.native="approveDeposit(el)"
		        		v-if="el.status == 0">
					    	<i class="fa fa-check"></i>
					    	<md-tooltip md-direction="top">Approve</md-tooltip>
					</md-button>
					<md-button 
		        		class="md-fab md-green md-mini"
		        		@click.native="showViewInfo(el)">
					    	<i class="fa fa-eye"></i>
					    	<md-tooltip md-direction="top">View</md-tooltip>
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
import _ from 'lodash'
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

	mixins: [_mixin],

	data(){
		return {
			contentHtml : '<div></div>',
			search_query: ''
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

	  	openDialog(data)
	  	{
	  		this.contentHtml = '<div style="width: 100%; text-align: center;"><b>Bitcoin address</b></div>' +
	  					'<div style="width: 100%; text-align: center;">'+ data.owner.bitcoin_account + '</div>' + 
	  					'<img src="storage/' + data.bankslip + '" style="max-width: 800px;">';
	  		this.$refs['dialog_blankslip'].open();
	  	},

	    onCloseDlg(type) {
	    	this.contentHtml = '<div></div>'
	    },

	    searchData: _.debounce(function () {
            this.fetchData(this.search_query);
        }, 500)
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