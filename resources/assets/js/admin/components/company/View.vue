<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Company Profile</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Address</dt>
                    <dd>{{ model.address }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Email</dt>
                    <dd>{{ model.email }}</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Phone</dt>
                    <dd>{{ model.phone }}</dd>
                </dl>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="showEdit(model)">Edit</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import Api from '../../api/Api'
import _mixin from '../../core/mixins/table'

export default{
    mixins: [_mixin],
    
	data(){
        return {
            model: {}
        }
    },

    created(){        
        Api.get('company/profile').then(
            (response) => {
                this.model = Object.assign({}, response.data);
            }
        );
    },
}
</script>