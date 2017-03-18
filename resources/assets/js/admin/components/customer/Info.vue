<template>
	<md-card>
		<md-card-header>
      <div class="md-title">Customer Information Detail</div>
    </md-card-header>
		<md-card-content>
      <div class="col-md-12 sec-block">
      	<dl class="dl-horizontal">
      		<dt>Username</dt>
      		<dd>{{ data.username }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>First Name</dt>
      		<dd>{{ data.first_name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Last Name</dt>
      		<dd>{{ data.last_name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Gender</dt>
      		<dd>{{ data.gender | sex }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Country</dt>
      		<dd>{{ data.country.name }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Date of Birth</dt>
      		<dd>{{ data.date_of_birth }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Email</dt>
      		<dd>{{ data.email }}<md-button class="md-icon-button" @click="test()"><md-icon>edit</md-icon></md-button></dd>
    		</dl>
				<dl class="dl-horizontal">
      		<dt>Sponsor</dt>
      		<dd>{{ data.sponsor !== null ? data.sponsor.username : '' }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Address Bitcoin</dt>
      		<dd>{{ data.bitcoin_account }}<md-button class="md-icon-button"><md-icon>edit</md-icon></md-button></dd>
    		</dl>
      </div>
    </md-card-content>
    <md-card-actions>
	    <md-button class="md-primary" @click="closeForm()">Close</md-button>
	  </md-card-actions>
  </md-card>
</template>

<script>

export default{

	props: ['data'],

	created(){
	},

	mounted(){
		console.log(this.data);
	},

	methods:{
		test(){
			console.log('edit');
		},

		closeForm(){
			this.$emit('close-form-message');
		}
	}
}
</script>


<style lang="scss" scoped>
.sec-block{
	padding: 0;
}

.md-raised.auto-size{
	width: auto !important;
}

.md-button.md-icon-button{
	top: -16px;
}
</style>