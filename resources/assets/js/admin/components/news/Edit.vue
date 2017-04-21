<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Edit News</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Title</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.title">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Content</dt>
                    <dd>
                        <div class="form-group">                            
                            <froala :tag="'textarea'" v-model="data.content"></froala>
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dd>
                        <div class="">                            
                            <input type="checkbox" v-model="data.published"> Publish
                        </div>
                    </dd>
                </dl>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="save(data)">Save</md-button>
            <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

    mixins: [_mixin],

    props: [ 'data' ],

    mounted(){
    },

    methods:{
        ...mapActions({
            update: 'news/update'
        }),

        save(model){
            this.update(model).then((response) => {
                this.closeForm();
            });
        }
    }
}
</script>