<template>
	<md-table-card>
    <md-table @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		    	<md-table-head>Username</md-table-head>
		    	<md-table-head>Amount</md-table-head>
		    	<md-table-head>Status</md-table-head>
		    	<md-table-head>Bitcoin Account</md-table-head>
		    	<md-table-head>Deposited Date</md-table-head>
		    	<md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
		    	<md-table-cell>{{ el.owner.username }}</md-table-cell>
		        <md-table-cell>{{ el.amount }}</md-table-cell>
		        <md-table-cell>
		        	<span class="label label-sm label-warning" v-if="el.status == 0">Pending</span>
		        	<span class="label label-sm label-success" v-if="el.status == 1">Approved</span>
		        	<span class="label label-sm label-danger" v-if="el.status == 2">Expired</span>
		        </md-table-cell>
		        <md-table-cell>{{ el.owner.bitcoin_account }}</md-table-cell>
		        <md-table-cell>{{ el.created_at }}</md-table-cell>
		        <md-table-cell>
		        	<md-button 
		        		class="md-raised md-primary" 
		        		@click="approveDeposit(el)"
		        		v-if="el.status == 0">
		        		Approve
		        	</md-button>
		        	<md-button 
		        		class="md-raised md-accent" 
		        		@click="sendMoney(el)"
		        		v-if="el.status == 1">
		        		Send money
		        	</md-button>
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
	      data_grid: 'deposit/data',
	      pagination: 'deposit/pagination'
	    })
	},

	created(){
		this.fetchData({ size : 100, page: 1});
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

		...mapActions({
	  		fetchData: 'deposit/fetchData',
	  		approveDeposit: 'deposit/approve',
	  		sendMoney: 'deposit/sendMoney'
	  	})
	}
}
</script>

<style lang="scss">
.md-theme-app{
	&.md-button{
		&.md-raised{
			width: 100%;
		}
	}
}
</style>