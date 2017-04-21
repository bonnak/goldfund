<template>
	<md-card class="content-form">
        <md-card-header>
            <div class="md-title">Create News</div>
        </md-card-header>
        <md-card-content class="content-body">
            <div class="col-md-12 sec-block">
                <dl class="dl-horizontal">
                    <dt>Title</dt>
                    <dd>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="model.title">
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Content</dt>
                    <dd>
                        <div class="form-group">                            
                            <froala :tag="'textarea'" v-model="model.content"></froala>
                        </div>
                    </dd>
                </dl>
                <dl class="dl-horizontal">
                    <dd>
                        <div class="">                            
                            <input type="checkbox" v-model="model.published"> Publish
                        </div>
                    </dd>
                </dl>
            </div>
        </md-card-content>
        <md-card-actions class="space-between">
            <md-button class="md-primary" @click.native="save(model)">Save</md-button>
            <md-button class="md-primary" @click.native="closeForm()">Close</md-button>
        </md-card-actions>
    </md-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

    mixins: [_mixin],

    data () {
        return {
            model: {
                title: '',
                content: '',
                published: true
            }
        }
    },

    mounted(){
    },

    methods:{
        ...mapActions({
            create: 'news/create'
        }),

        save(model){
            this.create(model).then((response) => {
                this.closeForm();
            });
        }
    }
}
</script>