<template>
	<md-card class="content-form">
		<md-card-header>
      <div class="md-title">Customer Information Detail</div>
    </md-card-header>
		<md-card-content class="content-body">
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
      		<dd v-if="!show_edit_email">
      				{{ data.email }}
      				<a href="#" @click.prevent.stop="show_edit_email = true"><i class="fa fa-pencil"></i></a>
      		</dd>
      		<dd v-if="show_edit_email">
      				<input type="text" v-model="data.email" />
      				<a href="#" @click.prevent.stop="editEmail(data)"><i class="fa fa-save"></i></a>
      				<span style="color: red" v-if="validation.email != ''">{{ validation.email }}</span>
      		</dd>
    		</dl>
				<dl class="dl-horizontal">
      		<dt>Sponsor</dt>
      		<dd>{{ data.sponsor !== null ? data.sponsor.username : '' }}</dd>
    		</dl>
    		<dl class="dl-horizontal">
      		<dt>Address Bitcoin</dt>
      		<dd v-if="!show_edit_bitcoin_account">
      				{{ data.bitcoin_account }}
      				<a href="#" @click.prevent.stop="show_edit_bitcoin_account = true"><i class="fa fa-pencil"></i></a>
      		</dd>
      		<dd v-if="show_edit_bitcoin_account">
      				<input type="text" v-model="data.bitcoin_account" />
      				<a href="#" @click.prevent.stop="editBitCoinAddress(data)"><i class="fa fa-save"></i></a>
      				<span style="color: red" v-if="validation.bitcoin_account != ''">{{ validation.bitcoin_account }}</span>
      		</dd>
    		</dl>
      </div>
    </md-card-content>
    <md-card-actions>
	    <md-button class="md-primary" @click="closeForm()">Close</md-button>
	  </md-card-actions>
  </md-card>
</template>

<script>
import { mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

	mixins: [_mixin],

	props: ['data'],

	data(){
		return {
			show_edit_email: false,
			show_edit_bitcoin_account: false,
			validation: {
				email: '',
				bitcoin_account: ''
			}
		}
	},

	methods:{
		editEmail(data){
			this.saveEmail(data).then(
				(response) => {
					this.show_edit_email = false;
					this.validation.email = '';
				},
				(err_response) => {
					this.validation.email = err_response.data.error;
				}
			);
		},

		editBitCoinAddress(data){
			this.saveBitCoinAddress(data).then(
				(response) => {
					this.show_edit_bitcoin_account = false;
					this.validation.bitcoin_account = '';
				},
				(err_response) => {
					this.validation.bitcoin_account = err_response.data.error;
				}
			);
		},

		...mapActions({
  		saveEmail: 'customer/editEmail',
  		saveBitCoinAddress: 'customer/editBitCoinAddress'
  	})
	}
}
</script>


<style lang="scss" scoped>
.sec-block{
	padding: 0;
}
</style>