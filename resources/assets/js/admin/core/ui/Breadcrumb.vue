<template>
	<el-breadcrumb separator="/">
    <el-breadcrumb-item v-for="bc in prepareBreadCrumb( $route.name )" :to="{ path: bc.path }">
      <span v-html="bc.name"></span>
    </el-breadcrumb-item>  

    <!-- <el-breadcrumb-item v-for="bc in abd( $route.name )" :to="{ path: $route.name }">
      <span v-html="bc"></span>
    </el-breadcrumb-item>   -->  
  </el-breadcrumb>
</template>

<script>
export default{
	methods : {
    prepareBreadCrumb(name){
      var _breadcrumb = [];

      this.$route.matched.forEach((el, i) => {
        if(el.name === name){
          var parent = el.parent; 

          if (el.parent !== undefined){ 
            _breadcrumb = this.prepareBreadCrumb(parent.name);

            // if(el.name == 'Home'){
            //   _breadcrumb.push({ name : '<i class="fa fa-home"></i>', path: '/' });
            // }
            // else{
              _breadcrumb.push({ name : name, path: el.path });
            //}
          }
        }
      });


      return _breadcrumb;
    },

    abd(name, seperator = '/'){
      var _names = name.split(seperator);

      // _names.forEach(el => {

      // });

      console.log(_names);

      return _names;
    }
	}
}
</script>