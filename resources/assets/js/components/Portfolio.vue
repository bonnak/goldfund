<template>
  <section class="focus">
    <div class="container">
        <div class="inner">
            <div class="table-stat">
                <div class="table-stat__left">
                    <div class="table-stat__title">Last Registrations</div>
                    <dl>
                    		<template v-for="customer in customers">
												    <dt>{{ customer.created_at | moment('from') }}</dt>
                            <dd>{{ customer.username }}</dd>
												</template>
                    </dl>
                </div>
                <div class="table-stat__center">
                    <div class="stat">
                        <p class="num">95</p>
                        <p class="text">Days Online</p>
                    </div>
                    <div class="stat">
                        <p class="num">{{ total_member }}</p>
                        <p class="text">Members</p>
                    </div>
                    <div class="stat">
                        <p class="num">{{ invested_capital }}$</p>
                        <p class="text">Invested</p>
                    </div>
                </div>
                <div class="table-stat__right">
                    <div class="table-stat__title">Last Investments</div>
                    <dl>
                        <template v-for="last_deposit in last_deposits">
												    <dt>{{ last_deposit.owner.username }}</dt>
                            <dd>{{ last_deposit.amount }}$</dd>
												</template>
                    </dl>
                </div>
            </div>
        </div>
    </div>
	</section>
</template>
<script>
    export default {
    		name: 'LivePorfolio',

    		data(){
    			return {
	    			customers: [],
	        	total_member: 0,
	          last_deposits: [],
	          invested_capital: 0
	        }
    		},

    		created(){
    			Axios.get('api/portfolio/live').then( response => {

    				var data = response.data;

    				data.customers.forEach(el => {
    					this.customers.push(el);
    				});

    				data.last_deposits.forEach(el => {
    					this.last_deposits.push(el);
    				});
    				
	        	this.total_member = data.total_member;
	          this.invested_capital = data.invested_capital;

    			});
    		},

        mounted() {
            
        }
    }
</script>
